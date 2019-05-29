<?php

namespace App\Http\Controllers;

use App\Model\Talk;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;

class TalkController extends Controller
{
    //
    use ApiResponser;

    public function all(){

        $talks = Talk::all();

        return $this->showAll($talks);
    }


    public function store(Request $request, User $user){


        $this->validate(request(), [

            'name' => 'required|unique:talks',
            'description' => 'required',
            'users_arr' => 'required'
        ]);

        $talk = new Talk;

        $talk->name = $request->name;
        $talk->slug = str_slug($request->name);
        $talk->description = $request->description;
        $talk->user_id = $user->id ;

        $talk->save();

        $talk->users()->sync(explode(', ', $request->users_arr));

        return $this->showOne($talk, 201);
    }



    public function chat($slug){

        $user_id = auth()->id();

        $talk = Talk::where('slug', $slug)->first();

        $talkUsers = $talk->users;

        $json = json_decode($talkUsers);

        $status = false;

        foreach($json as $obj){

            if ($obj->id === $user_id){

                $status = true;

            }

        }
        if (!$status){

            abort(404);
        }

        return view('chat', compact('talk'));

    }


}
