<?php

namespace App\Exceptions;

use Exception;

class EmailNotVerifiedException extends Exception
{
    protected $message = 'Your email address needs to be verified before logging in.';

    protected $code = 'email_not_verified';
}
