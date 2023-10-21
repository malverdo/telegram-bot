<?php

declare(strict_types=1);

namespace App\Application\UseCase\ArgumentResolver;

use App\Application\UseCase\Request\StartRequest;
use Exception;
use LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class StartRequestResolver implements ArgumentValueResolverInterface
{

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     * @throws LogicException
     */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return StartRequest::class === $argument->getType();
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     * @throws NotFoundHttpException
     * @throws UnprocessableEntityHttpException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $content = json_decode($request->getContent(), true);



        yield new StartRequest($content);
    }
}
