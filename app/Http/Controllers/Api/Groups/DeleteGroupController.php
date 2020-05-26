<?php

namespace App\Http\Controllers\Api\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\DeleteGroupDeleteRequest;
use App\Models\Group;

class DeleteGroupController extends Controller
{
    public function __invoke(DeleteGroupDeleteRequest $request, Group $group)
    {
        $group->delete();

        return response()->json([
            'message' => 'Group deleted',
        ], 200);
    }
}
