<?php

namespace App\Exceptions;

use Exception;

class InvalidCredentialsException extends Exception
{
    protected $message = 'Invalid credentials. Please check your credentials and try again.';

    protected $code = 'error';
}
