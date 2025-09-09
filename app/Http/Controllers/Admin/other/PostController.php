<?php

namespace App\Http\Controllers\admin;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(10);
        //dd($posts);
        return view('admin.posts.list', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::orderBy('name','ASC')->get();
        $tags       = Tag::orderBy('name','ASC')->get();

        return view('admin.posts.create', compact('categories','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        if($request->ajax()){

            $validator = Validator::make($request->all(), [
                'title' => 'required',
            ]);

            if($validator->passes()){

                $post = new Post();
                $post->title        = $request->title;
                $post->slug         = Str::slug($request->title,'-');
                $post->description  = $request->description;
                $post->category_id  = $request->category;
                $post->user_id      = auth()->user()->id;
                $post->published_at = Carbon::now();
                $post->is_active    = isset($request->is_active) ? 1 : 0;
              //$post->is_active    = $request->is_active;

                if($request->hasFile('featured_image')){

                    $image = $request->featured_image;

                    $ext = $image->getClientOriginalExtension();
                    $image_new_name = time().'.'.$ext;

                    $image->move(public_path().'/uploads/posts/', $image_new_name); 
                  //$image->move('uploads/posts/', $image_new_name); 

                    $post->image = $image_new_name;
                }
                
                $post->save();

                $post->tags()->attach($request->tags);

                $request->session()->flash('success', 'Post created Successfully');

                return response()->json([
                    'status'  => true,
                    'message' => 'Post created Successfully'
                ]);

            } else {

                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }
        }
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
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        
        $categories = Category::orderBy('name','ASC')->get();
        $tags = Tag::orderBy('name','ASC')->get();

        return view('admin.posts.edit', compact(['post','categories','tags']));
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
        //dd($request->all());

        if($request->ajax()){

            $validator = Validator::make($request->all(), [
                'title_edit' => 'required',
            ]);

            if($validator->passes()){

                $post = Post::findOrFail($id);

                $post->title        = $request->title_edit;
                $post->slug         = Str::slug($request->title_edit,'-');
                $post->description  = $request->description_edit;
                $post->category_id  = $request->category_edit;
                $post->user_id      = auth()->user()->id;
                $post->published_at = Carbon::now();
                $post->is_active    = isset($request->is_active_edit) ? 1 : 0;
              //$post->is_active    = $request->is_active;
                $old_image          = $request->old_image_edit;
                
                if($request->hasFile('featured_image_edit')){

                    $image = $request->featured_image_edit;

                    $ext = $image->getClientOriginalExtension();
                    $image_new_name = time().'.'.$ext;

                    $image->move(public_path().'/uploads/posts/', $image_new_name); 
                    $post->image = $image_new_name;

                    //Delete previous image from uploads folder.
                    File::delete(public_path().'/uploads/posts/'.$old_image);
                }
                
                $post->save();

                $post->tags()->sync($request->tags_edit);

                $request->session()->flash('success', 'Post updated Successfully');

                return response()->json([
                    'status'  => true,
                    'message' => 'Post updated Successfully'
                ]);

            } else {

                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ]);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}