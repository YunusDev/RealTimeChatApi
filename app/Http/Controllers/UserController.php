<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{
    //

    public function __construct()
    {
        parent::__construct();
        $this->middleware('can:view,user')->only('show');
        $this->middleware('can:update,user')->only('update');
        $this->middleware('can:destroy,user')->only('destroy');

    }

//    public function __construct()
//    {
//        $this->middleware('client.credentials')->only(['store']);
//
//    }

    public function index()
    {

        $users = User::all();

        return $this->showAll($users);
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = $request->all();
        $user['password'] = bcrypt($request->password);

        $create = User::create($user);

        return $this->showOne($create, 201);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        return $this->showOne($user);
    }

    public function show(User $user)
    {
        return $this->showOne($user);

    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);


        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($user->isClean()) {
            return $this->errorResponse('You need to make a change before updating a user', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user);
    }


}
