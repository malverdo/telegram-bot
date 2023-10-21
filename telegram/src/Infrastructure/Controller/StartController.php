<?php

namespace App\Infrastructure\Controller;

use App\Application\Service\CallbackQueryService;
use App\Application\Service\CommandService;
use App\Application\Service\TextService;
use App\Application\UseCase\Request\StartRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;


class StartController extends AbstractController
{

    private CallbackQueryService $callbackQueryService;
    private TextService $textService;
    private CommandService $commandService;

    public function __construct(
        CallbackQueryService $callbackQueryService,
        TextService $textService,
        CommandService $commandService
    ) {
        $this->callbackQueryService = $callbackQueryService;
        $this->textService = $textService;
        $this->commandService = $commandService;
    }

    /**
     */
    #[Route('/start', name: 'create', methods: ['POST'])]
    public function create(StartRequest $request): Response
    {
        $update = $request->update;

        if ($update->getCallbackQuery()) {
            $this->callbackQueryService->handlerSelection($update);
        } elseif (strpos($update->getMessage()->getText(),'/') == 0) {
            $this->commandService->handlerSelection($update);
        } elseif ($update->getMessage()) {
            $this->textService->handlerSelection($update);
        }





        // Здесь ваша логика обработки данных...

        return new Response("true");
    }
}