<?php
declare(strict_types=1);

namespace HttpMessage\Contract;

use Exception;
use HttpMessage\Exception\PageNotFoundException;
use HttpMessage\Exception\PublicErrorException;

interface RequestHandler
{
    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     * @throws PageNotFoundException
     * @throws PublicErrorException
     */
    public function handle(Request $request): Response;
}