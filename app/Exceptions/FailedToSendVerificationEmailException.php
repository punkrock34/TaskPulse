<?php

namespace App\Exceptions;

use Exception;

class FailedToSendVerificationEmailException extends Exception
{
    protected $message = 'Failed to send the verification email. Please try again.';

    protected $code = 'error';
}
