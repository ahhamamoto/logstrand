<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Authentication\LoginPostRequest;
use App\Http\Resources\Api\Users\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @group Authentication
 */
class LoginController extends Controller
{
    /**
     * User login.
     *
     * Issues a new token for user and returns it in plain text. Any previously
     * issued token will still be active. The token is visible only when generated,
     * if the token is lost another have to be issued.
     *
     * @bodyParam email string required Email for new user Example: anderson@logster.com
     * @bodyParam password string required Password for new user Example: password
     *
     * @response 200 {
     *  "data": {
     *   "id": 2,
     *   "name": "Anderson Hamamoto",
     *   "email": "anderson@logster.com",
     *   "created_at": "2020-05-22T16:21:03.000000Z",
     *   "updated_at": "2020-05-22T16:21:03.000000Z",
     *   "token": "xg1vKzALMlhjeC3daezBwPxePATH1jASKCH3XBDWy14kdAYKSkbgFFqOW1l1l6vpUqiFwedAlEBxA7nn"
     *  }
     * }
     * @response 200 {
     *   "error": true,
     *   "message": "E-mail\/Password doesn't match our database"
     * }
     * @response 422 {
     *  "message": "The given data was invalid.",
     *  "errors": {
     *   "email": [
     *    "The email field is required."
     *   ],
     *   "password": [
     *    "The password field is required."
     *   ]
     *  }
     * }
     */
    public function __invoke(LoginPostRequest $request)
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
