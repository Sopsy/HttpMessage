<?php
declare(strict_types=1);

namespace HttpMessage\Message;

use HttpMessage\Contract\Headers as HeadersInterface;

use function array_key_exists;
use function str_replace;
use function str_starts_with;
use function strtolower;
use function substr;

final class Headers implements HeadersInterface
{
    /**
     * @param array<string, array<array-key, string>> $headers
     */
    public function __construct(private array $headers = [])
    {
    }

    /**
     * @param array $superglobalServer
     * @return static
     */
    public static function fromSuperglobals(array $superglobalServer): self
    {
        /** @var array<string, array<array-key, string>> $headers */
        $headers = [];
        /** @var string $value - Technically it's not always a string, but we only care about HTTP headers which are */
        foreach ($superglobalServer as $name => $value) {
            $name = (string)$name;

            if (!str_starts_with($name, 'HTTP_')) {
                continue;
            }

            $name = substr($name, 5);
            $name = strtolower(str_replace('_', '-', $name));

            if (!isset($headers[$name])) {
                $headers[$name] = [];
            }

            $headers[$name][] = $value;
        }

        return new self($headers);
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function header(string $name): array
    {
        $name = strtolower($name);
        if (!array_key_exists($name, $this->headers)) {
            return [];
        }

        return $this->headers[$name];
    }

    public function withHeader(string $name, string $value): self
    {
        $name = strtolower($name);
        $headers = $this->headers;

        unset($headers[$name]);

        $new = clone $this;
        $new->headers = $headers;

        return $new->withAddedHeader($name, $value);
    }

    public function withAddedHeader(string $name, string $value): self
    {
        $name = strtolower($name);
        $headers = $this->headers;

        if (isset($headers[$name])) {
            $headers[$name][] = $value;
        } else {
            $headers[$name] = [$value];
        }

        $new = clone $this;
        $new->headers = $headers;

        return $new;
    }
}