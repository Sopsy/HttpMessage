<?php
declare(strict_types=1);

namespace HttpMessage\Contract;

interface Response extends Headers
{
    public function statusCode(): int;

    public function body(): string;

    public function withHeader(string $name, string $value): self;

    public function withAddedHeader(string $name, string $value): self;

    /**
     * @return callable[]
     */
    public function runBefore(): array;

    public function withRunBefore(callable $callable): self;

    /**
     * @return callable[]
     */
    public function runAfter(): array;

    public function withRunAfter(callable $callable): self;
}