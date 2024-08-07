<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    protected $message = 'The specified user could not be found.';

    protected $code = 'error';
}
