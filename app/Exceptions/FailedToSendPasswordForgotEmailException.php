<?php

namespace App\Exceptions;

use Exception;

class FailedToSendPasswordForgotEmailException extends Exception
{
    protected $message = 'Failed to send password forgot email. Please try again later.';

    protected $code = 'error';
}
