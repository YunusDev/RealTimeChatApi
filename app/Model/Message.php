<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //

    protected $appends = ['time'];

    public $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function talk()
    {
        return $this->belongsTo(Talk::class);
    }

    public function getTimeAttribute(){

        return $this->created_at->diffForHumans();
    }
}
