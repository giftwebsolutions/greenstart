<?php

namespace Modules\SysAdmin\Http\Controllers\Auth;

use Modules\SysAdmin\Http\Controllers\Controller;
use Modules\SysAdmin\Http\Traits\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
}
