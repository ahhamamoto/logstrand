<?php

namespace App\Http\Controllers\Api\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\CreateGroupPostRequest;
use App\Http\Resources\Api\Groups\GroupResource;

class CreateGroupController extends Controller
{
    public function __invoke(CreateGroupPostRequest $request)
    {
        $user = $request->user();

        $group = $user->groups()->create($request->validated());

        return new GroupResource($group);
    }
}
