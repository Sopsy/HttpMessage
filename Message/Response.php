<?php
declare(strict_types=1);

namespace HttpMessage\Message;

use HttpMessage\Contract\Headers as HeadersInterface;
use HttpMessage\Contract\Response as ResponseInterface;

final class Response implements ResponseInterface
{
    private HeadersInterface $headers;
    /** @var callable[] */
    private array $runAfter = [];
    /** @var callable[] */
    private array $runBefore = [];

    /**
     * @param string $body
     * @param int $statusCode
     * @param array<string, array<array-key, string>> $headers
     */
    public function __construct(
        private readonly string $body = '',
        private readonly int $statusCode = 200,
        array $headers = []
    ) {
        $this->headers = new Headers($headers);
    }

    public function body(): string
    {
        return $this->body;
    }

    public function headers(): array
    {
        return $this->headers->headers();
    }

    public function header(string $name): array
    {
        return $this->headers->header($name);
    }

    public function withHeader(string $name, string $value): self
    {
        $new = clone $this;
        $new->headers = $new->headers->withHeader($name, $value);

        return $new;
    }

    public function withAddedHeader(string $name, string $value): self
    {
        $new = clone $this;
        $new->headers = $new->headers->withAddedHeader($name, $value);

        return $new;
    }

    public function runBefore(): array
    {
        return $this->runBefore;
    }

    public function withRunBefore(callable $callable): self
    {
        $new = clone $this;
        $new->runBefore[] = $callable;

        return $new;
    }

    public function runAfter(): array
    {
        return $this->runAfter;
    }

    public function withRunAfter(callable $callable): self
    {
        $new = clone $this;
        $new->runAfter[] = $callable;

        return $new;
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }
}