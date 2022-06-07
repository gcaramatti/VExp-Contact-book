<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $category = Category::all();
        return view ('/category/category')->with('categories', $category);
    }
   
    public function store(Request $request)
    {
        $input = $request->except('_token');
        if(!empty($input) && !is_null($input['name'])){
            Category::create($input);
            return response()->json($input);
        }
        return response()->json(['error' => 'Preencha o nome da categoria'], 400);
    }
 
    public function show($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $input = $request->except('_token');
        if(!empty($input)){
            try{
                $category = Category::find($id);

                $category->name = $request["name"];
                $category->save();
                return response()->json(['success' => 'Categoria atualizada com sucesso']);
            } catch(e){

            }
        }
        return response()->json(['error' => 'Erro ao apagar categoria'], 400);
    }
   
    public function destroy($id)
    {
        if(!empty($id)){
            Category::destroy($id);
            return response()->json(['success'=>'Categoria apagada']);
        }
        return response()->json(['error' => 'Erro ao apagar categoria'], 400);
    }
}
