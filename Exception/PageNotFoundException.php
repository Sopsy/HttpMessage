<?php
declare(strict_types=1);

namespace HttpMessage\Exception;

use Throwable;

use function _;
use function in_array;

final class PageNotFoundException extends PublicErrorException
{
    public function __construct(string $message = '', int $code = 404, Throwable $previous = null)
    {
        if ($message === '') {
            $message = _('Page not found');
        }

        if (!in_array($code, [404, 410], true)) {
            $code = 404;
        }

        parent::__construct($message, $code, $previous);
    }
}