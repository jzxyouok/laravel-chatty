<?php

namespace Chatty\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model{

	protected $table = 'likeable';
//this sets a polymorphic relationship that can be used in other models
	public function likeable(){
		return $this->morphTo();
	}
	public function user(){
		return $this->belongsTo('Chatty\Models\User', 'user_id');
	}
}