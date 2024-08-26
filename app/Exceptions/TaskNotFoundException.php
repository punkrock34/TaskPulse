<?php

namespace App\Exceptions;

use Exception;

class TaskNotFoundException extends Exception
{
    protected $message = 'The task you are looking for does not exist.';

    protected $code = 'error';
}
