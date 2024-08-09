<?php

namespace App\Exceptions;

use Exception;

class TokenVerificationException extends Exception
{
    protected $message = 'Token verification failed. Please try again later.';

    protected $code = 'error';
}
