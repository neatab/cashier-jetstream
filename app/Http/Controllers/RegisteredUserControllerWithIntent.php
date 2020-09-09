<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisteredUserControllerWithIntent 
{
    public function create(Request $request)
    {
        $user = new User;
        return view('auth.register', [
            'intent' => $user->createSetupIntent(),
        ]);
    }
}
