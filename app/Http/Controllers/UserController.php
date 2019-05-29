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
//        parent::__construct();
        $this->middleware('client.credentials')->except(['login', 'register']);
        $this->middleware('can:view,user')->only('show');
        $this->middleware('can:update,user')->only('update');
        $this->middleware('can:destroy,user')->only('destroy');
        $this->middleware('can:logout,user')->only('logout');

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

    public function login(Request $request){
        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {

                $http = new Client;

                $response = $http->post('http://your-app.com/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => 4,
                        'client_secret' => 'L0vOqWgumOITjUJK3RaWEzQV6NlOMuLvWeHWOrCH',
                        'username' => $user->email,
                        'password' => $user->password
                    ],
                ]);

                return json_decode((string) $response->getBody(), true);
//                return $this->showMessage($response);

            } else {
                $response = "Password missmatch";
                return $this->showMessage($response, 422);

            }

        } else {
            $response = 'User does not exist';
            return $this->showMessage($response, 422);
        }



    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], 200);
    }


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

    public function logout(User $user){

        $user->token()->revoke();

        return response()->json(['success'=>'Logged Out Successfully'], 200);


    }

}
