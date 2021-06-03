<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\VerifyEmail;
use App\Role;
use Illuminate\Http\Request;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignUpController extends Controller
{
    public function __invoke(Request $data)
    {
        return "hi.";
    }
    public function byPhone($data)
    {
        return "register by phone";
    }
    public function byEmail($data)
    {
        return "signi by meail";
    }
}
