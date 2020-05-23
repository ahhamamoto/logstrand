<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Authentication\RegisterPostRequest;
use App\Http\Resources\Api\Users\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __invoke(RegisterPostRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return new UserResource($user);
    }
}
