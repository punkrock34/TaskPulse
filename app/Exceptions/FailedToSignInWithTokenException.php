<?php

namespace App\Exceptions;

use Exception;

class FailedToSignInWithTokenException extends Exception
{
    protected $message = 'Failed to authenticate with the custom token. Please try again.';

    protected $code = 'error';
}
