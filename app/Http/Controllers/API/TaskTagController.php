<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\TaskTagCollection;

use App\Models\Tag;
use Illuminate\Http\Request;

class TaskTagController extends BaseController
{  
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return new TaskTagCollection(Tag::all());
    }
}
