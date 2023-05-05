<?php

namespace Vanier\Api\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpInvalidFormatException extends HttpSpecializedException
{
    /**
     * @var int
     */
    protected $code = 403;

    /**
     * @var string
     */
    protected $message = 'Invalid Format.';

    protected $title = '403 Invalid Format';
    protected $description = 'The format in the body is not valid.';
}
