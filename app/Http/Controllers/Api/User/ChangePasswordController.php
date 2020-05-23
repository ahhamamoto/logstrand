<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\ChangePasswordPostRequest;
use Illuminate\Support\Facades\Hash;

/**
 * @group User
 */
class ChangePasswordController extends Controller
{
    /**
     * Change password for the user.
     *
     * The password can only be changed if the current password is provided
     * in the request, despite having the Authorization Token in the header.
     *
     * @authenticated
     *
     * @bodyParam password string required Current password for the user Example: password
     * @bodyParam new_password string required New password for the user Example: new_password
     * @bodyParam new_password_confirmation string required New password confirmation for the user Example: new_password
     *
     * @response 200 {
     *  "message": "Password changed successfully"
     * }
     * @response 401 {
     *  "error": true,
     *  "message": "Current password does not match"
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *   "new_password": [
     *     "The new password confirmation does not match."
     *   ]
     *  }
     * }
     */
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
