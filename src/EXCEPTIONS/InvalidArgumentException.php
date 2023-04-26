<?php
namespace Vanier\Api\Exceptions;

use Slim\Exception\HttpSpecializedException;
class InvalidArgumentException extends HttpSpecializedException{
     /**
     * @var int
     */
    protected $code = 400;

    /**
     * @var string
     */
    protected $message = 'Missing Data.';

    protected $title = '406 Bad Request';
    protected $description = 'Missing parameter in Body. Required parameters not met.';
}


?>