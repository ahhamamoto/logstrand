<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Authentication\RegisterPostRequest;
use App\Http\Resources\Api\Users\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @group Authentication
 */
class RegisterController extends Controller
{
    /**
     * Register a new user.
     *
     * Validates and registers a new user
     *
     * @bodyParam name string required New name for new user Example: Anderson Hamamoto
     * @bodyParam email string required Email for new user Example: anderson@logster.com
     * @bodyParam password string required Password for new user Example: password
     * @bodyParam password_confirmation string required Password confirmation Example: password
     *
     * @response 200 {
     *  "data": {
     *   "id": 2,
     *   "name": "Anderson Hamamoto",
     *   "email": "anderson@logster.com",
     *   "created_at": "2020-05-22T16:21:03.000000Z",
     *   "updated_at": "2020-05-22T16:21:03.000000Z"
     *  }
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *   "name": [
     *    "The name field is required."
     *   ],
     *   "email": [
     *    "The email field is required."
     *   ],
     *   "password": [
     *    "The password field is required."
     *   ]
     *  }
     * }
     */
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
