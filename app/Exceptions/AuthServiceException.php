<?php

namespace App\Exceptions;

use Exception;

class AuthServiceException extends Exception
{
    protected $message = 'An error occurred while trying to authenticate. Please try again.';

    protected $code = 'error';
}
