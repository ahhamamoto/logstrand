<?php

namespace App\Http\Controllers\Api\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\UpdateGroupPutRequest;
use App\Http\Resources\Api\Groups\GroupResource;
use App\Models\Group;

class UpdateGroupController extends Controller
{
    public function __invoke(UpdateGroupPutRequest $request, Group $group)
    {
        $group->update($request->validated());

        return new GroupResource($group);
    }
}
