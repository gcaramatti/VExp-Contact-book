<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
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
        $contactList = DB::table('contact_book as cb')
            ->leftJoin('contact_phones', 'cb.id', '=', 'contact_phones.contact_id')
            ->leftJoin('categories AS cat', 'cb.category_id', '=', 'cat.id')
            ->select('cb.id as contact_id', 'cb.name', 'cb.category_id', 'contact_phones.cellphone', 'contact_phones.is_main_phone','cat.id', 'cat.name AS cat_name')
            ->where('is_main_phone', 'T')
            ->get();

        return view ('home')->with([
            'categories' => $category, 
            'contactList' => $contactList
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
            $phoneDataArray = array("contact_id"=>$createContact->id, "cellphone"=>$input['cellphone'], "is_main_phone"=>"T");
            $createContact->phones()->create($phoneDataArray);
            
            //Array Endereço:
            $addressArray = array("contact_id"=>$createContact->id, "address"=>$input['address'], "district"=>$input['district'], "complement"=>$input['addressComplement'], "city"=>$input['city'], "state"=>$input['addressState']);
            $createContact->addresses()->create($addressArray);

            return response()->json($input);
        }
        return response()->json([
            "message" => "Erro ao cadastrar novo contato"
        ], 400);
    }
 
    
    public function show($id)
    {
        $category = Contact::find($id);
        return response()->json($category);
    }
 
    
    public function edit($id)
    {
        $category = DB::table('contact_book as cb')
        ->leftJoin('categories AS cat', 'cb.category_id', '=', 'cat.id')
        ->select('cb.id as contact_id', 'cb.name', 'cb.category_id','cat.id', 'cat.name AS cat_name')
        ->where('cb.id', '=', $id)
        ->get();
        
        $phoneList = DB::table('contact_phones')
        ->where('contact_phones.contact_id', '=', $id)
        ->get();

        $addressList = DB::table('contact_addresses')
        ->where('contact_addresses.contact_id', '=', $id)
        ->get();

        return view ('/contact/details')->with([
            'categoryDetails' => $category, 
            'phoneList' => $phoneList, 
            'addressList' => $addressList
        ]);
    }
 
  
    public function update(Request $request, $id)
    {
        $category = Contact::find($id);
        return response()->json($category);
    }
 
   
    public function destroy($id)
    {
        if(!empty($id) && !is_null($id)){

            Contact::destroy($id);

            return response()->json(['success'=>'Contato apagado']);
        }
        return Response::json([
            "message" => "Erro ao apagar contato"
        ], 400);
    }

    public function storePhone(Request $request)
    {
        $input = $request->except('_token');

        if(!empty($input) && !is_null($input)){
            $createContact = new Contact;
            $createContact->id = (int)$input['contactId'];
            
            //Array telefone:
            $phoneDataArray = array("contact_id"=>$createContact->id, "cellphone"=>$input['cellphone'], "is_main_phone"=>"F");
            $createContact->phones()->create($phoneDataArray);

            return response()->json($input);
        }
        return Response::json([
            "message" => "Erro ao adicionar telefone"
        ], 400);
    }

    public function storeAddress(Request $request)
    {
        $input = $request->except('_token');
        if(!empty($input) && !is_null($input)){
            $createAddress = new Contact;
            $createAddress->id = (int)$input['contactId'];

            //Array telefone:
            $addressArray = array("contact_id"=>$createAddress->id, "address"=>$input['address'], "district"=>$input['district'], "complement"=>$input['addressComplement'], "city"=>$input['city'], "state"=>$input['addressState']);
            $createAddress->addresses()->create($addressArray);

            return response()->json($input);
        }
        return Response::json([
            "message" => "Erro ao adicionar endereço"
        ], 400);
    }
}
