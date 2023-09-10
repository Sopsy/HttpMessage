<?php
declare(strict_types=1);

namespace HttpMessage\Contract;

interface Headers
{
    /** @return array<string, array<array-key, string>> */
    public function headers(): array;

    /**
     * @param string $name
     * @return array<array-key, string>
     */
    public function header(string $name): array;

    public function withHeader(string $name, string $value): self;

    public function withAddedHeader(string $name, string $value): self;
}