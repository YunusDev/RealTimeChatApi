<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    public $guarded = [];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users(){

        return $this->belongsToMany(User::class, 'user_talks')->withTimestamps();

    }
}
