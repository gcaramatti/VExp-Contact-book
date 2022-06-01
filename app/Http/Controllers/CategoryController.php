<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json($category);
        //return view ('category.index')->with('category', $category);
    }
 
    
    public function create()
    {
        return view('category.create');
    }
 
   
    public function store(Request $request)
    {
        $input = $request->all();
        Category::create($input);
        return response()->json($category);
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
