<?php
declare(strict_types=1);
namespace App\Command;

use App\Domain\CreateChargeRequest;
use App\Service\ChargeFactory;
use App\ValueObject\Card;
use App\ValueObject\CardExpiration;
use Money\Currency;
use Money\Money;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:create-charge', description: "Create charge via one of provider. \"Shift4\" or \"ACI\"")]
final class CreateChargeCommand extends Command
{

    public function __construct(private readonly ChargeFactory $chargeFactory, private readonly SerializerInterface $serializer)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'provider',
            InputArgument::REQUIRED,
            'Provider name: "Shift4" or "ACI"',
            null,
            ["Shift4", "ACI"],
        )   ->addArgument('card-number', InputArgument::REQUIRED, 'Card number example: 4242424242424242')
            ->addArgument('card-exp-month',  InputArgument::REQUIRED, 'Month of expiration from 1-12')
            ->addArgument('card-exp-year', InputArgument::REQUIRED, 'Year of expiration example: 2026')
            ->addArgument('card-cvv', InputArgument::REQUIRED, 'CVC/CVV example: 466')
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount: 10.00 or 1000 for 10 EUR')
            ->addArgument('currency', InputArgument::REQUIRED, 'Currency');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $chargeProvider = $this->chargeFactory->createChargeProvider($input->getArgument('provider'));
        $input->validate();

        $request = new CreateChargeRequest(
            amount: new Money(
                $input->getArgument('amount'),
                new Currency($input->getArgument('currency'))
            ),
            card: new Card(
                $input->getArgument('card-number'),
                new CardExpiration(
                    (int)$input->getArgument('card-exp-month'),
                    (int)$input->getArgument('card-exp-year'),
                ),
                $input->getArgument('card-cvv')
            ),
        );
        $createChargeResponse = $chargeProvider->createCharge($request);

        $output->writeln(
            $this->serializer->serialize($createChargeResponse, JsonEncoder::FORMAT, [JsonEncode::OPTIONS => JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT])
        );


        return Command::SUCCESS;
    }
}