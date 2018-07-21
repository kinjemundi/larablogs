<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::latest()->get();
        return view('categories.index',['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Category $category)
    {
        
        //dd($request);
        $category->create([
            'name' => $request['name'],
            'slug' => str_slug($request['name'],'-'),
        ]);

         return redirect('categories');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //
        $category = Category::where('slug',$slug)->first();
        return view('categories.show',compact('category',$category));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    //     $category = Category::findOrFail($id);
    //     return view('categories.edit',compact('category',$category));
    // }
    public function edit(Category $category)
    {
        //
        $category->findOrFail($category->id);
         return view('categories.edit',compact('category',$category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $category->findOrFail($category->id);
        $category->update([
            'name' => $request['name'],
            'slug' => str_slug($request['name'],'-'),
        ]);
        return redirect('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $category->findOrFail($category->id);
        $category->delete();
        return redirect('categories');
        
    }
}
