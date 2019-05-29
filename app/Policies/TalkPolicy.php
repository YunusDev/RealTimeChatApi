<?php

namespace App\Policies;

use App\Model\Talk;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TalkPolicy
{
    use HandlesAuthorization;



    /**
     * Determine whether the user can create talks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the talk.
     *
     * @param  \App\User  $user
     * @param  \App\Talk  $talk
     * @return mixed
     */
    public function view(User $user, Talk $talk)
    {
        //

        $talkUsers = $talk->users;

        $json = json_decode($talkUsers);

        $status = false;

        foreach($json as $obj){

            if ($obj->id === $user->id){

                $status = true;

            }

        }

        return $status;
    }

    /**
     * Determine whether the user can delete the talk.
     *
     * @param  \App\User  $user
     * @param  \App\Talk  $talk
     * @return mixed
     */
    public function delete(User $user, Talk $talk)
    {
        //
    }

    /**
     * Determine whether the user can restore the talk.
     *
     * @param  \App\User  $user
     * @param  \App\Talk  $talk
     * @return mixed
     */
    public function restore(User $user, Talk $talk)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the talk.
     *
     * @param  \App\User  $user
     * @param  \App\Talk  $talk
     * @return mixed
     */
    public function forceDelete(User $user, Talk $talk)
    {
        //
    }
}
