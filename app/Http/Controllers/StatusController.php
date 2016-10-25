<?php
namespace Chatty\Http\Controllers;
use Chatty\Models\User;
use Chatty\Models\Status;
use Illuminate\Http\Request;
use Auth;


Class StatusController extends Controller{
	public function postStatus(Request $request){
		$this->validate($request,[
			'status' =>'required|max:1000',
			]);

		Auth::user()->statuses()->create([
			'body'=>$request->input('status'),
			]);

		return redirect()->route('home')->with('info', 'Status posted.');
	}
	public function postReply(Request $request, $statusId){
		$this->validate($request, [
			"reply-{$statusId}"=> 'required|max:1000'], [
			'required'=>  'The reply body is required.']);
		//retrieve the status we want to reply to
		$status = Status::notReply()->find($statusId);

		if(!$status){
			return redirect()->route('home');
		}
		if(!Auth::user()->isFriendsWith($status->user) && Auth::user()->id !== $status->user->id){
			return redirect()->route('home');
		}
		//this creates the reply and bind it to the var $reply
		$reply = Status::create([
			'body'=> $request->input("reply-{$statusId}"),
			])->user()->associate(Auth::user());
        //this binds the replies to the status 
		$status->replies()->save($reply);

		return redirect()->back();
	}

	public function getLike($statusId){
		$status = Status::find($statusId);

		if (!$status){
			return redirect()->route('home');
		}
		if (!Auth::user()->isFriendsWith($status->user)){
			return redirect()->route('home');
		}
		if (Auth::user()->hasLikedStatus($status)){
			return redirect()->back();
		}
		$like = $status->likes()->create([]);
		Auth::user()->likes()->save($like);
		return redirect()->back();

	}
	
	}
