<?php

namespace App\Exceptions;

use Exception;

class GeneralFirebaseException extends Exception
{
    protected $message = 'An error occurred. Please try again later.';

    protected $code = 'error';
}
