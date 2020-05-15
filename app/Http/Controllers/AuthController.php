<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class AuthController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return new UserResource(auth()->user());
    }
}
