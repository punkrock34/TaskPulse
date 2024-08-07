<?php

namespace App\Exceptions;

use Exception;

class TooManyAttemptsException extends Exception
{
    protected $message = 'Too many attempts. Please try again later.';

    protected $code = 'error';
}
