<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index()
    {
        $dataUser = User::query()
            ->orderBy('name')
            ->get();

        $dataUser = UserResource::collection($dataUser);

        return inertia('users/Index', compact('dataUser'));
    }
}
