<?php

namespace App\Exceptions;

use Exception;

class UnexpectedErrorException extends Exception
{
    protected $message = 'An unexpected error occurred. Please try again later.';

    protected $code = 'error';
}
