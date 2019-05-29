<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TalkCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'messages_count' => $this->messages->count(),
            'links' => [

                [
                    'rel' => 'self',
                    'href' => route('talk.show', $this->slug)
                ],
                [
                    'rel' => 'talk.users',
                    'href' => route('talk.users', $this->id),
                ],
                [
                    'rel' => 'talk.messages',
                    'href' => route('talk.messages', $this->id),
                ],

            ]
        ];
    }
}
