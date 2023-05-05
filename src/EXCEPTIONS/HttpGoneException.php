<?php

namespace Vanier\Api\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpGoneException extends HttpSpecializedException
{
    /**
     * @var int
     */
    protected $code = 406;

    /**
     * @var string
     */
    protected $message = 'Gone.';

    protected $title = '406 Gone';
    protected $description = 'The requested data does not exist.';
}
