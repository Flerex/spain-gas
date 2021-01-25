<?php


namespace Flerex\SpainGas\Exceptions;

use Exception;
use Throwable;

class MissingRequiredParameterException extends Exception
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
