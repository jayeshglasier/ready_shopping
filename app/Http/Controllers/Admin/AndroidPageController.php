<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Helper\Exceptions;

class AndroidPageController extends Controller
{
    public function privacyPolicy()
    {
        return view('privacy-policy');
    }
}