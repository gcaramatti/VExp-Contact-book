<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Contact;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $category = Category::all();
        $contactsData = DB::table('users_contact_book')
            ->leftJoin('contact_phones', 'users_contact_book.id', '=', 'contact_phones.contact_id')
            ->leftJoin('contacts_addresses', 'users_contact_book.id', '=', 'contacts_addresses.contact_id')
            ->get();

        return view ('home')->with([
            'categories' => $category, 
            'contacts' => $contactsData
        ]);
    }
    public function create()
    {
        return view('category.create');
    }
 
   
    public function store(Request $request)
    {
        $input = $request->except('_token');

        if(!empty($input) && !is_null($input)){
            //Array de contatos
            $contactDataArray = array("name"=>$input['contactName'], "category_id"=>$input['contactCategory']);
            $createContact = Contact::create($contactDataArray);
            
            //Array telefone:
            $phoneDataArray = array("contact_id"=>$createContact->id, "cellphone"=>$input['cellphone']);
            $createContact->phones()->create($phoneDataArray);
            
            //Array Endereço:
            $addressArray = array("contact_id"=>$createContact->id, "address"=>$input['address'], "district"=>$input['district'], "number"=>1, "complement"=>$input['addressComplement'], "city"=>$input['city'], "state"=>$input['addressState']);
            $createContact->addresses()->create($addressArray);

            return response()->json($input);
        }
        return Response::json([
            "message" => "Erro ao cadastrar novo contato"
        ], 400);
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
        if(!empty($id) && !is_null($id)){
            Category::destroy($id);
            return response()->json(['success'=>'Categoria apagada']);
        }
        return Response::json([
            "message" => "Erro ao apagar categoria"
        ], 400);
    }
}
