<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $departments = Department::all();

        return view('admin.departments', compact('departments'));
    }

    public function create(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|max:255',
            ));
                
        //store in the database
        $department = new Department;
        $department->name = $request->name;
        if($request->hasFile('image')){           
            
            $fileNamewithExt = $request->file('image')->getClientOriginalName();
            //Get just file name
            $filename = pathinfo($fileNamewithExt,PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Filename to store
            $department->image = 'u'.$department->id.'_avt'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('image')->storeAs('public/department',$department->image);
            $department->image = 'storage/department/'.$department->image;
        }
        $department->save();

        return redirect('/departments')->with('success', $department->name.'  has been created!');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Save a new department and then redirect back to index
        $this->validate($request, array(
            'name' => 'required|max:255',
            ));

        $department = new Department();

        $department->name = $request->name;
        $department->save();

        return redirect('/departments')->with('success', 'New Department has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Display the department and all the departments in that department
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
        $this->validate($request, [
            'id' => 'required|integer',
            'name'=>'required|string',   
        ]);

        $department = Department::findOrFail($request->id);
        $department->name = $request->name;
        
        if($request->hasFile('image')){           
            
            $fileNamewithExt = $request->file('image')->getClientOriginalName();
            //Get just file name
            $filename = pathinfo($fileNamewithExt,PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Filename to store
            $department->image = 'u'.$department->id.'_avt'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('image')->storeAs('public/department',$department->image);
            $department->image = 'storage/department/'.$department->image;
        }
        $department->save() ;

        return redirect('/departments')->with('success', $department->name. ' has been updated!');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    public function deactivate(Request $request)
    {
        //
        $this->validate($request, [
            'id' => 'required'
        ]);
        $department = Department::findOrFail($request->id);
        $department->active=false;
        $department->save();

        return redirect('/departments')->with('success', $department->name.'  has been deactivated!');
    }

    public function activate(Request $request)
    {
        //
        $this->validate($request, [
            'id' => 'required'
        ]);
        $department = Department::findOrFail($request->id);
        $department->active=true;
        $department->save();

        return redirect('/departments')->with('success', $department->name.'  has been activated!');
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
        $department = Department::findOrFail($request->id);

        if($department->delete()){
            
            return redirect('/departments')->with('success', $department->name. ' has been deleted!');
        }
    }
}
