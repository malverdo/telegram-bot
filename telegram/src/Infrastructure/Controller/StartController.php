<?php

namespace App\Infrastructure\Controller;

use App\Application\UseCase\Request\StartRequest;
use App\Domain\Entity\Message\Update;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;


class StartController extends AbstractController
{
    private DenormalizerInterface $serializer;

    public function __construct(DenormalizerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/start', name: 'create', methods: ['POST'])]
    public function create(StartRequest $request): Response
    {
        $message = $request->update;
        $update = $this->serializer->denormalize($message, Update::class);

        dd($update);

        // Здесь ваша логика обработки данных...

        return new Response("true");
    }
}