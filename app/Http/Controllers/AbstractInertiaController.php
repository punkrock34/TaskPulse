<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class AbstractInertiaController extends Controller
{
    abstract public function index(Request $request);
}
