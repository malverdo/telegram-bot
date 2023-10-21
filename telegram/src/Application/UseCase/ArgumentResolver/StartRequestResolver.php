<?php

declare(strict_types=1);

namespace App\Application\UseCase\ArgumentResolver;

use App\Application\UseCase\Request\StartRequest;
use App\Domain\Entity\Message\Update;
use Exception;
use LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Serializer\SerializerInterface;

final class StartRequestResolver implements ArgumentValueResolverInterface
{
    private SerializerInterface $serializer;

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

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
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
        if (empty($request->getContent())) {
            throw new Exception('Empty body', 1);
        }

        $update = $this->serializer->deserialize($request->getContent(), Update::class, 'json');

        yield new StartRequest($update);
    }
}
