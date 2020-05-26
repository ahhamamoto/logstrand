<?php

namespace App\Http\Controllers\Api\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\ViewGroupGetRequest;
use App\Http\Resources\Api\Groups\GroupResource;
use App\Models\Group;

class ViewGroupController extends Controller
{
    public function __invoke(ViewGroupGetRequest $request, Group $group)
    {
        return new GroupResource($group);
    }
}
