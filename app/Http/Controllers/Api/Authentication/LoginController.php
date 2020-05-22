<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Users\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => true,
                'message' => 'E-mail/Password doesn\'t match our database',
            ]);
        }

        $token = $user->createToken('login')->plainTextToken;

        $user->token = explode('|', $token)[1];

        return new UserResource($user);
    }
}
