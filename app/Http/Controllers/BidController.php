<?php

namespace App\Http\Controllers;

use Auth;
use App\Bid;
use App\Comment;
use Illuminate\Http\Request;

class BidController extends Controller
{
    public function index()
    {
        if (Auth::user()->role->id == 3) {
            $bids = Bid::where('supplier_id', Auth::user()->id)->get();
        }
        else{
            $bids = Bid::all();
        }
        return view('admin.bids', compact('bids'));
    }

    public function create(Request $request)
    {
        $this->validate($request, array(
            'quote_id' => 'required|integer',
            'amount' => 'required|integer',
        ));
                
        //store in the database
        $bid = new Bid;
        $bid->quote_id = $request->quote_id;
        $bid->supplier_id = Auth::user()->id;
        $bid->amount = $request->amount;
        $bid->message = $request->message;
        $bid->save();
        return redirect()->back()->with('success', ' Bid has been placed successfully!');
    }

    public function deny(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'comment' => 'required'
        ]);
        $bid = Bid::findOrFail($request->id);
        $bid->status=1;

        $comment = new Comment;
        $comment->comment = $request->input('comment');
        $comment->comment_id = $bid->id;
        $comment->type = 'B';
        $comment->save();

        $bid->save();

        return redirect('/bids')->with('success', ' Bid has been denied!');
    }

    public function award(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $bid = Bid::findOrFail($request->id);
        $bid->status=2;
        $bid->save();

        return redirect('/bids')->with('success', 'Bid  has been accepted!');
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
        $bid = Bid::findOrFail($request->id);

        if($bid->delete()){
            
            return redirect('/bids')->with('success', $bid->name. ' has been deleted!');
        }
    }
}
