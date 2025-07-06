<?php
declare(strict_types=1);
namespace App\Command;

use App\Domain\CreateChargeRequest;
use App\Service\ChargeFactory;
use App\Service\CreateChargeInterface;
use App\ValueObject\Card;
use App\ValueObject\CardExpiration;
use Money\Currency;
use Money\Money;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:create-charge')]
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
        );
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $chargeProvider = $this->chargeFactory->createChargeProvider($input->getArgument('provider'));

        $request = new CreateChargeRequest(
            amount: Money::EUR(10_00),
            card: new Card(
                "4242424242424242",
                new CardExpiration(
                    11,
                    2026,
                ),
                "336"
            ),
        );
        $createChargeResponse = $chargeProvider->createCharge($request);

        $output->writeln(
            $this->serializer->serialize($createChargeResponse, 'json')
        );


        return Command::SUCCESS;
    }
}