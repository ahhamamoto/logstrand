<?php

namespace App\Http\Controllers\Api\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\ViewAllGroupGetRequest;
use App\Http\Resources\Api\Groups\GroupCollection;

class ViewAllGroupController extends Controller
{
    public function __invoke(ViewAllGroupGetRequest $request)
    {
        return new GroupCollection($request->user()->groups()->paginate(10));
    }
}
