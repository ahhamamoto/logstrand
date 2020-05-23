<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\ChangePasswordPostRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordPostRequest $request)
    {
        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return response()->json([
                'error' => true,
                'message' => 'Current password does not match',
            ], 401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'message' => 'Password changed successfully',
        ]);
    }
}
