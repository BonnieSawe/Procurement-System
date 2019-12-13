<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
// use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    public function index()
    {
        if (Auth::user()->role->id > 1) {
            return redirect('/');
        }
        $users  = User::all();
        $roles = Role::all();
        return view('admin.users', compact('users', 'roles'));
    }

    public function create(Request $request)
    {
        $message = 'i can see you';
        return $message;
        
    }

    public function editUser(Request $request)
    {
        $this->validate($request, [
            'id'=>'required|integer',
            'firstname'=>'required|string',
            'lastname'=>'sometimes|string',
            'email'=>'required|string',
            'phonenumber'=>'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|sometimes',
        ]);
        // return 1;

        $id = $request->id;
        $user = User::find($id);
        $user->first_name = $request->input('firstname');
        $user->other_names = $request->input('lastname');
        $user->email = $request->input('email');
        $user->role_id = $request->role_id;
        $user->phone_number1 = $request->input('phonenumber');
        

        if($request->hasFile('image')){
            $oldFilename = $user->avatar;
            
            $fileNamewithExt = $request->file('image')->getClientOriginalName();
            //Get just file name
            $filename = pathinfo($fileNamewithExt,PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Filename to store
            $user->avatar = 'u'.$user->id.'_avt'.time().'.'.$extension;
            //Upload Image
            Storage::delete($oldFilename);
            $path = $request->file('image')->storeAs('public/user',$user->avatar);
            $user->avatar = 'storage/user/'.$user->avatar;
            
        }


        $user->save();

        return redirect('/users')->with('success', $user->first_name.' '.$user->other_names.' '.'updated successfully');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname'=>'required|string',
            'lastname'=>'sometimes|string',
            'email'=>'required|string',
            'phonenumber'=>'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|sometimes',
        ]);

        $user = new User;
        $user->first_name = $request->input('firstname');
        $user->other_names = $request->input('lastname');
        $user->email = $request->input('email');
        $user->role_id = $request->role_id;
        $user->phone_number1 = $request->input('phonenumber');

        $user->password = bcrypt($request->phonenumber);           
        

        if($request->hasFile('image')){
            $oldFilename = $user->avatar;
            
            $fileNamewithExt = $request->file('image')->getClientOriginalName();
            //Get just file name
            $filename = pathinfo($fileNamewithExt,PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Filename to store
            $user->avatar = 'u'.$user->id.'_avt'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('image')->storeAs('public/user',$user->avatar);
            $user->avatar = 'storage/user/'.$user->avatar;
            
        }


        $user->save();

        return redirect('/users')->with('success', $user->first_name.' '.$user->other_names.' '.'added successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $schoolDetail
     * @return \Illuminate\Http\Response
     */

    public function show(User $User)
    {
        $user  = User::find(1);
        return view('admin.settings')->with('user', $user);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
            $id = $request->id;
            $user = User::find($id);
            $user->first_name = $request->input('firstname');
            $user->other_names = $request->input('lastname');
            $user->email = $request->input('email');
            $user->phone_number1 = $request->input('phonenumber');

            if(!empty($request->oldpass) || !empty($request->newpass) || !empty($request->cnewpass)){
                $this->validate($request, [
                    'oldpass' => 'required',
                    'newpass' => 'required|same:newpass',
                    'cnewpass' => 'required|same:newpass'
                ]);
    
                // if(Hash::check($request->oldpass,$user->password) ){
                if(Hash::make($request->oldpass) == $user->password ){
                    return redirect('/users/settings')->with('error', 'Old password is incorrect!');
                }else if($request->newpass != $request->cnewpass ){  
                    return redirect('/users/settings')->with('error', 'New password confirmation doesn\'t match!');
                }else{
                    $user->password = Hash::make($request->newpass);
                }
            }

            if($request->hasFile('image')){
                $oldFilename = $user->avatar;
                
                $fileNamewithExt = $request->file('image')->getClientOriginalName();
                //Get just file name
                $filename = pathinfo($fileNamewithExt,PATHINFO_FILENAME);
                //Get just extension
                $extension = $request->file('image')->getClientOriginalExtension();
                //Filename to store
                $user->avatar = 'u'.$user->id.'_avt'.time().'.'.$extension;
                //Upload Image
                $path = $request->file('image')->storeAs('public/user',$user->avatar);
                $user->avatar = 'storage/user/'.$user->avatar;
                
                Storage::delete($oldFilename);
            }
    

            $user->save();

            return redirect('/users/settings')->with('success', 'Password updated successfully');


            ;}

    public function deactivate(Request $request)
    {
        //
        $this->validate($request, [
            'id' => 'required'
        ]);
        $user = User::findOrFail($request->id);
        $user->active=false;
        $user->save();

        return redirect('/users')->with('success', $user->title.'  has been deactivated!');
    }

    public function activate(Request $request)
    {
        //
        $this->validate($request, [
            'id' => 'required'
        ]);
        $user = User::findOrFail($request->id);
        $user->active=true;
        $user->save();

        return redirect('/users')->with('success', $user->title.'  has been activated!');
    }

    public function delete(Request $request)
    {
        //
        $this->validate($request, [
            'id' => 'required'
        ]);
        $user = User::findOrFail($request->id);

        if($user->delete()){
            
            return redirect('/users')->with('success', $user->first_name.' '.$user->other_names. ' has been deleted!');
        }
    }



}