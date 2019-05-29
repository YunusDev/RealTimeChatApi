<?php

namespace App\Http\Controllers;

use App\Http\Resources\TalkCollection;
use App\Http\Resources\TalkResource;
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

        $talk_res =  TalkCollection::collection($talks);

        return $this->showAll($talk_res);
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

        $talk = new TalkResource($talk);

        return $this->showOne($talk, 201);
    }

    public function show($slug){

        $talk = Talk::where('slug', $slug)->first();

        $talk = new TalkResource($talk);

        return $this->showOne($talk);
    }


    public function talkUsers(Talk $talk){

        $users = $talk->users;

        return $this->showAll($users);
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
