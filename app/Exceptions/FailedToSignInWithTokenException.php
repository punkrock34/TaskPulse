<?php

namespace App\Exceptions;

use Exception;

class FailedToSignInWithTokenException extends Exception
{
    protected $message = 'The link you used is either invalid or has expired. Please request a new link and try again.';

    protected $code = 'error';
}
