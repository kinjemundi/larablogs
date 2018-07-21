<?php

namespace App\Http\Controllers;

use App\Blog;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use App\Mail\BlogPublished;
use Illuminate\Support\Facades\Mail;

//blog model
class BlogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('author', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('admin', ['only' => ['destroy', 'trash', 'restore', 'permanentDelete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $blogs = Blog::latest()->get();
        // $blogs = Blog::where('status', 1)->latest()->get();
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::latest()->get();

        return view('blogs.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //first way of create data
        // $blog = new Blog();
        // $blog->title = $request->title;
        // $blog->body = $request->body;
        // $blog->save();
        //validate
        $rules = [
            'title' => ['required', 'min:10', 'max:160'],
            'body' => ['required', 'min:10'],
        ];

        $this->validate($request, $rules);
        $kinput = $request->all();
        //meta stuff
        $kinput['slug'] = str_slug($request->title);
        $kinput['meta_title'] = str_limit($request->title, 55);
        $kinput['meta_description'] = str_limit($request->body, 155);
        //Image upload
        if ($file = $request->file('featured_image')) {
            $name = uniqid() . $file->getClientOriginalName();
            $name = strtolower(str_replace(' ', '-', $name));
            $file->move('images/featured_image/', $name);
            $kinput['featured_image'] = $name;
        }
        // $blog = Blog::create($kinput);
        $blogByUser = $request->user()->blogs()->create($kinput);
        //sync with categories
        if ($request->category_id) {
            $blogByUser->category()->sync($request->category_id);
        }

        //mail
        $users = User::all();
        foreach($users as $user){
            Mail::to($user->email)->queue(new BlogPublished($blogByUser,$user));
        }
        $request->session()->flash('blog_created_message', 'Congratulations on creating a great blog');

        return redirect('/blogs');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //
        // $blog = Blog::findOrFail($id);
        $blog = Blog::whereSlug($slug)->first();
        return view('blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $categories = Category::latest()->get();
        $blog = Blog::findOrFail($id);
        $bc = array();
        foreach ($blog->category as $c) {
            $bc[] = $c->id - 1;
        }
        $filtered = array_except($categories, $bc);

        return view('blogs.edit', ['blog' => $blog, 'categories' => $categories, 'filtered' => $filtered]);
        // return view('blogs.edit',compact($blog));
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

        $kinput = $request->all();
        $blog = Blog::findOrFail($id);

        if ($file = $request->file('featured_image')) {
            if ($blog->featured_image) {
                unlink('images/featured_image/' . $blog->featured_image);
            }
            $name = uniqid() . $file->getClientOriginalName();
            $name = strtolower(str_replace(' ', '-', $name));
            $file->move('images/featured_image/', $name);
            $kinput['featured_image'] = $name;

        }
        $blog->update($kinput);

        if ($request->category_id) {
            $blog->category()->sync($request->category_id);
        }
        return redirect('blogs');
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
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect('blogs');
    }

    public function trash()
    {
        $trashedblog = Blog::onlyTrashed()->get();
        return view('blogs.trash', compact('trashedblog'));
    }
    public function restore($id)
    {
        $restoredblog = Blog::onlyTrashed()->findOrFail($id);
        $restoredblog->restore($restoredblog);
        return redirect('blogs');
    }

    public function permanentDelete($id)
    {
        $permanentDeleteBlog = Blog::onlyTrashed()->findOrFail($id);
        $permanentDeleteBlog->forceDelete($permanentDeleteBlog);
        return back();
    }
}
