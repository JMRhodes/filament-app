<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::paginate());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return UserResource::make(User::findOrFail($id));
    }
}
