<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Author;
use App\Category;
use App\Tag;
use App\PostTag;
use Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get and list all posts
        $posts = Post::orderBy('created_at', 'DESC')->get();
        $authors = Author::all();
        $categories = Category::all();        
        $tags = Tag::all();        
        return view('admin.posts', compact('posts', 'categories', 'authors', 'tags'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, array(
            'title' => 'required|max:255|unique:posts',                       
            'body' => 'required',
            'category_id' => 'required|integer',
            'author_id' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|sometimes',            
            ));

        $category = Category::where('id', $request->category_id)->first();
                
        //store in the database
        $post = new Post;
        $post->title = $request->title;        
        $post->category_id = $request->category_id;
        $post->author_id = $request->author_id;
        $post->body = $request->body;
        $post->slug = str_slug($post->title);
        // $post->slug = $post->title;
        
        if($request->hasFile('image')){           
                
            $fileNamewithExt = $request->file('image')->getClientOriginalName();
            //Get just file name
            $filename = pathinfo($fileNamewithExt,PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Filename to store
            $post->image = 'u'.$post->id.'_img'.time().'.'.$extension;
            //Upload Image
            $path = $request->file('image')->storeAs('public/post',$post->image);
            $post->image = 'storage/post/'.$post->image;
            
        // }else{            
            // return redirect('Error: Please attach an image',null);  
        //     return redirect('posts')->with('withErrors',  'Please attach an image',null);
        }
        
        $post->save();

        if($request->tags != null && count($request->tags)>0){

            foreach($request->tags as $tag_id){
                $hasTag=false;
                foreach($post->postTags as $post_tag){
                    if($post_tag->tag->id == $tag_id){
                        $hasTag=true;
                    }
                }
    
                if(!$hasTag){
                    $post_tag = new PostTag;
                    $post_tag->post_id = $post->id;
                    $post_tag->tag_id = $tag_id;
    
                    $post_tag->save();
                }
            }
        }

        return redirect('/manage/posts')->with('success', $post->title.'  has been created!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
         //
        $this->validate($request, [
            'title' => 'required|max:255',                       
            'author_id' => 'required|integer',
            'body' => 'required',
            'category_id' => 'required|integer',
            'id' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|sometimes',
        ]);

        $category = Category::where('id', $request->category_id)->first();        

        //GET TERM FROM DB
        $post = Post::findOrFail($request->id);
        $post->author_id = $request->author_id;
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->body = $request->body;
        $post->slug = str_slug($post->title);
        //Handle File Upload
        if($request->hasFile('image')){
            $oldFiletitle = $post->image;   
                    
            $fileNamewithExt = $request->file('image')->getClientOriginalName();
            //Get just file name
            $filename = pathinfo($fileNamewithExt,PATHINFO_FILENAME);
            //Get just extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Filename to store
            $post->image = 'u'.$post->id.'_img'.time().'.'.$extension;
            Storage::delete($oldFiletitle);
            //Upload Image
            $path = $request->file('image')->storeAs('public/post',$post->image);
            $post->image = 'storage/post/'.$post->image;

        }

        $post->save();

        //deleting unchecked activities NB: delete must come before assign         
        foreach($post->postTags as $post_tag){            
            $tagDeleted=true;
            foreach($request->tags as $tag_id){
                if($post_tag->tag_id == $tag_id){
                    $tagDeleted=false;
                    break;
                    
                }
            }

            if($tagDeleted){
                
                $post_tag->delete();
            }

        
        }


        //adding newly checked activities
        foreach($request->tags as $tag_id){
            $hasTag=false;
            foreach($post->postTags as $post_tag){
                if($post_tag->tag_id == $tag_id){
                    $hasTag=true;
                    break;
                }
            }

            if(!$hasTag)
            {
                $post_tag = new PostTag;
                $post_tag->post_id = $post->id;
                $post_tag->tag_id = $tag_id;

                $post_tag->save();
            }
        }

        return redirect('/manage/posts')->with('success', $post->title.' updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate(Request $request)
     {
        //
        $this->validate($request, [
            'id' => 'required'
        ]);
        $post = Post::findOrFail($request->id);
        $post->active=false;
        $post->save();

        return redirect('/manage/posts')->with('success', $post->title.'  has been deactivated!');
    }

    public function activate(Request $request)
    {
        //
        $this->validate($request, [
            'id' => 'required'
        ]);
        $post = Post::findOrFail($request->id);
        $post->active=true;
        $post->save();

        return redirect('/manage/posts')->with('success', $post->title.'  has been activated!');
    }

    public function destroy(Request $request)
    {
        //
        $this->validate($request, [
            'id' => 'required'
        ]);
        $post = Post::findOrFail($request->id);
        $post->tags()->detach();

        Storage::delete($post->image);

        if($post->delete()){
            
            return redirect('/manage/posts')->with('error', $post->title. ' has been deleted!');
        }
    }

    function image_rename($data){
		$data = preg_replace("[^A-Za-z0-9]", " ", $data);
		$data = ltrim($data);
		$data = rtrim($data);
		$data = str_replace(' ', '-',$data);
		$data = stripslashes($data);
		return $data;
	}
}
