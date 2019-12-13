<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Quote;
use App\QuoteItem;
use App\Department;

class QuoteController extends Controller
{
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotes = Quote::all();
        if (Auth::user()->role->id == 3) {
            $quotes = Quote::where('status', 2)->get();
        }
        $departments = Department::all();
        return view('admin.quotes', compact('quotes', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, array(
            'department_id' => 'required|integer',
        ));
        $quote = new Quote;
        $quote->department_id = $request->input('department_id');
        $quote->desc = $request->input('description');
        if($quote->save()){
            if(!empty($request->input('qty'))){
                $i = 0;
                for($i = 0; $i <5; $i++){
                    if(!empty($request->input('qty.'.$i)) && !empty($request->input('qty.'.$i))){
                        $quote_item = new QuoteItem;
                        $quote_item->qty =  $request->input('qty.'.$i);
                        $quote_item->unit = $request->input('unit.'.$i);
                        $quote_item->price = $request->input('price.'.$i);                        
                        $quote_item->desc = $request->input('desc.'.$i);
                        $quote_item->quote_id = $quote->id;
                        $quote_item->save();
                    }
                    
                }
            }
        }
                
        return redirect('/quotes')->with('success', 'Quote has been Successfully Added!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function decline(Request $request)
    {
        //
        $this->validate($request, array(
            'id' => 'required|integer',
        ));

        $quote = Quote::findOrFail($request->id);
        $quote->status=1;
        if($quote->save()){
            return redirect('/quotes')->with('warning', 'Quote has been declined!');
        }

    }

    public function approve(Request $request)
    {
        $this->validate($request, array(
            'id' => 'required|integer',
        ));

        $quote = Quote::findOrFail($request->id);
        $quote->status = 2;
        if($quote->save()){
            return redirect('/quotes')->with('success', 'Quote has been Successfully Approved!');
        }

    }

    public function destroy(Request $request)
    {
        $this->validate($request, array(
            'id' => 'required|integer',
        ));

        $quote = Quote::findOrFail($request->id);

        if($quote->delete()){
            return redirect('/quotes')->with('error', 'Quote has been Deleted!');
        }
    }    
}
