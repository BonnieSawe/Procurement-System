<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Quote;
use App\User;
use App\Bid;
use App\Comment;
use App\LoginField;

class MainController extends Controller
{
    public function index()
    {
        $quotes = Quote::all();
        $user_login = LoginField::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->skip(1)->take(1)->first();
        $users  = User::all();
        $bids  = Bid::all();
        $suppliers  = User::where('role_id', 3)->get();
        return view ('admin.main-dash', compact('quotes', 'users', 'suppliers', 'bids'));
    }

    public function showComments()
    {
        $comments = Comment::where('approved', false)->get();
        return view('admin.comments', compact('comments'));
    }

    public function deactivate(Request $request)
    {
        //
        $this->validate($request, [
            'id' => 'required'
        ]);
        $comment = Comment::findOrFail($request->id);
        $comment->approved=false;
        $comment->save();

        return redirect('/manage/comments')->with('success', 'comment by '.$comment->name.'  has been deactivated!');
    }

    public function activate(Request $request)
    {
        //
        $this->validate($request, [
            'id' => 'required'
        ]);
        $comment = Comment::findOrFail($request->id);
        $comment->approved=true;
        $comment->save();

        return redirect('/manage/comments')->with('success', 'comment by '.$comment->name.'  has been approved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //delete
        $this->validate($request, [
            'id' => 'required'
        ]);
        $comment = Comment::findOrFail($request->id);

        if($comment->delete()){
            
            return redirect('/manage/comments')->with('success', 'comment by '.$comment->name. ' has been deleted!');
        }
    }

    public function storeImage(Request $request)
    {
        $image = $request->file('image');
        $filename = 'image_'.time().'_'.$image->hashName();
        $image = $image->move(public_path('img'), $filename);
        return mce_back($filename);
    }
}
