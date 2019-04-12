<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message','roomChannel'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
