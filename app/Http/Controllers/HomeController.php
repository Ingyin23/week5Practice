<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\storePostRequest;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        //$this->middleware('auth')->only('index','create';)
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$data=Post::all();
        //dd(auth()->user()->id);
        $data=Post::where('user_id',auth()->id())->orderBy('id','desc')->get();
        //$data=Post::latest()->first();
        return view('home',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories= Category::all();
        return view('create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storePostRequest $request)
    {
      //dd($request->all());
    
      
      //$post =new Post();
     // $post->name=$request->name;
     // $post->description=$request->description;
     //$post->save();
     
     // Post::create([
     //     'name' =>$request->name,
     //     'description' =>$request->description,
     //     'category_id' =>$request->category,
     // ]);

      $validated = $request->validated();
      Post::create($validated);

     return redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //dd($post->categories->name);

        //if($post->user_id != auth()->id()){ //Manually
        //    abort(403);
        //}

        $this->authorize('view',$post); // Laravel Policy
       return view('show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
       // if($post->user_id != auth()->id()){
       //    abort(403);
       // }

        $this->authorize('view',$post);
        $categories= Category::all();
        return view('edit',compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(storePostRequest $request,Post $post)
    {
       
       // $post->name=$request->name;
       // $post->description=$request->description;
       // $post->save();

       // $post->update([
       //     'name' =>$request->name,
      //      'description' =>$request->description,
       //     'category_id' =>$request->category,
        //]);

        $validated = $request->validated();
        $post->update($validated);
        return redirect('/posts');
  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= Post::findOrFail($id)->delete();
        return redirect('/posts');
    }
}
