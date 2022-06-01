<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        //return response()->json($category);
        return view ('/category/category')->with('categories', $category);
    }
 
    
    public function create()
    {
        return view('category.create');
    }
 
   
    public function store(Request $request)
    {
        $input = $request->except('_token');
        Category::create($input);
        return response()->json($input);
    }
 
    
    public function show($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }
 
    
    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }
 
  
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }
 
   
    public function destroy($id)
    {
        Category::destroy($id);
        return response()->json(['success'=>'Categoria apagada']);
    }
}
