<?php
declare(strict_types=1);

namespace App\Controller;

use App\Domain\CreateChargeRequest;
use App\Service\ChargeCreationFailer;
use App\Service\ChargeFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
final readonly class ChargeController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }


    #[Route(path: '/charge/{provider}', name: 'charge', requirements: [
        'provider' => 'Shift4|ACI',
    ], methods: ['POST'], format: 'json')]
    public function createCharge(string $provider, #[MapRequestPayload] CreateChargeRequest $request, ChargeFactory $chargeFactory): Response
    {
        $provider = $chargeFactory->createChargeProvider($provider);
        try {
            $charge = $provider->createCharge(
                $request
            );
        } catch (ChargeCreationFailer $e) {
            return new JsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST, json: true);
        }

        return new JsonResponse(
            $this->serializer->serialize($charge, JsonEncoder::FORMAT),
            json: true
        );
    }
}