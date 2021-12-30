<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $blogs =  Blog::all();
        return response()->json([
            'status' => 1,
            'blogs' => $blogs,

        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        $user_id = auth()->user()->id;

        if($user_id){

            //validation handled by BlogRequest

            $data = Blog::create([
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'description' => $request->description,
            ]);


            return  response()->json([
                'status' => 1,
                'blog' => $data,
            ]);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return response()->json([
            'status' => 1,
            'blog' => $blog
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        if(isset($request->title) ? $blog->title = $request->title : $blog->title = $blog->title);
        if(isset($request->description) ?  $blog->description = $request->description : $blog->description = $blog->description);
        $blog->user_id = $blog->user_id;


        $blog->update();

        if($blog->update()){

            return response([
                'status' => 1,
                'blog' => $blog,
            ], 200);

        }else{
            return response([
                'status' => false,
            ], 404);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return response([
            'status' => 1,
            'message' => 'Deleted'
        ],200);
    }
}
