<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Users\UserResource;
use Illuminate\Http\Request;

/**
 * @group User
 */
class UserController extends Controller
{
    /**
     * Return information about the user.
     *
     * @authenticated
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
     */
    public function __invoke(Request $request)
    {
        return new UserResource($request->user());
    }
}
