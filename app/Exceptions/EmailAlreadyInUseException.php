<?php

namespace App\Exceptions;

use Exception;

class EmailAlreadyInUseException extends Exception
{
    protected $message = 'The email address is already in use. Please try logging in instead.';

    protected $code = 'email_already_in_use';
}
