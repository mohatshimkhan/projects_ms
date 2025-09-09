<?php

namespace App\Http\Controllers\admin;

use Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        
        return view('admin.tags.list', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
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

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:tags',
        ]);

        if($validator->passes()){

            $tag = new Tag();
            $tag->name = $request->name;
            $tag->slug = $request->slug;
            $tag->description = $request->description;
            $tag->is_active = $request->is_active;
            $tag->save();

            $request->session()->flash('success', 'Tag added Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Tag added Successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
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
        $tag = Tag::findOrFail($id);

        return view('admin.tags.edit', compact('tag'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:tags',
        ]);

        if($validator->passes()){

            $tag = Tag::findOrFail($id);

            $tag->name  = $request->name;
            $tag->slug  = $request->slug;
            $tag->description = $request->description;
            $tag->is_active   = $request->is_active;
            $tag->save();

            $request->session()->flash('success', 'Tag updated Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Tag updated Successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
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
        $tag = Tag::findOrFail($id);

        if($tag){

            $tag->delete();

            $request->session()->flash('success', 'Tag deleted Successfully');

            return response()->json([
                'status' => true,
                'message' => 'Tag deleted Successfully'
            ]);

        } else {
            
            return response()->json([
                'status' => false,
                'message' => 'Tag not found'
            ]);
        }
    }



}