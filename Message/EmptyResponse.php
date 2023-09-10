<?php
declare(strict_types=1);

namespace HttpMessage\Message;

use HttpMessage\Contract\Response as ResponseInterface;

final class EmptyResponse implements ResponseInterface
{
    private ResponseInterface $response;
    /** @var callable[] */
    private array $runAfter = [];
    /** @var callable[] */
    private array $runBefore = [];

    /**
     * @param int $statusCode
     * @param array<string, array<array-key, string>> $headers
     */
    public function __construct(
        int $statusCode = 200,
        array $headers = []
    ) {
        $this->response = new Response('', $statusCode, $headers);
    }

    public function body(): string
    {
        return $this->response->body();
    }

    public function headers(): array
    {
        return $this->response->headers();
    }

    public function header(string $name): array
    {
        return $this->response->header($name);
    }

    public function withHeader(string $name, string $value): self
    {
        $new = clone $this;
        $new->response = $new->response->withHeader($name, $value);

        return $new;
    }

    public function withAddedHeader(string $name, string $value): self
    {
        $new = clone $this;
        $new->response = $new->response->withAddedHeader($name, $value);

        return $new;
    }

    public function statusCode(): int
    {
        return $this->response->statusCode();
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
}