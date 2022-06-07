<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SendEmailController;
use App\Models\Category;
use App\Models\Contact;
use App\Models\ContactPhone;
use App\Models\ContactAddress;

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
            $addressArray = array("contact_id"=>$createContact->id, "zip_code"=>$input['zip_code'], "address"=>$input['address'], "district"=>$input['district'], "complement"=>$input['addressComplement'], "city"=>$input['city'], "state"=>$input['addressState']);
            $createContact->addresses()->create($addressArray);

            $mailController = new SendEmailController;
            $mailController->index();
            
            return response()->json(['success'=>'Contato cadastrado com sucesso']);
        }
        return response()->json(['error'=>'Erro ao editar contato'], 400);
    }
 
    
    public function show($id)
    {
        $category = Contact::find($id);
        return response()->json($category);
    }
 
    
    public function edit($id)
    {
        $allCategories = Category::all();

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
            'allCategories' => $allCategories,
            'categoryDetails' => $category, 
            'phoneList' => $phoneList, 
            'addressList' => $addressList
        ]);
    }
 
  
    public function update(Request $request, $id)
    {
        try{
            $contact = Contact::find($id);
            $contact->name = $request["name"];
            $contact->category_id = $request["category_id"];
            $contact->save();
            return response()->json(['success'=>'Contato atualizado com sucesso!']);
        } catch(error){
            return response()->json(['error'=>'Erro ao editar contato'], 400);
        }
    }
 
   
    public function destroy($id)
    {
        if(!empty($id)){
            try{
                Contact::destroy($id);
                return response()->json(['success'=>'Contato apagado']);
            } catch(error){
                return response()->json(['error'=>'Erro ao apagar contato'], 400);
            }
        }
        return response()->json(['error'=>'Erro ao apagar contato'], 400);
    }

    public function showAddress($id){
        $address = ContactAddress::find($id);
        return response()->json($address);
    }

    public function storePhone(Request $request)
    {
        $input = $request->except('_token');

        if(!empty($input)){
            try{
                $createContact = new Contact;
                $createContact->id = (int)$input['contactId'];
                
                //Array telefone:
                $phoneDataArray = array("contact_id"=>$createContact->id, "cellphone"=>$input['cellphone'], "is_main_phone"=>"F");
                $createContact->phones()->create($phoneDataArray);

                return response()->json(['success' => 'Telefone adicionado!']);
            } catch(error){
                return response()->json(['error'=>'Erro ao adicionar telefone'], 400);
            }
        }
        return response()->json(['error'=>'Erro ao adicionar telefone'], 400);
    }

    public function storeAddress(Request $request)
    {
        $input = $request->except('_token');
        if(!empty($input)){
            try{
                $createAddress = new Contact;
                $createAddress->id = (int)$input['contactId'];

                //Array endereço:
                $addressArray = array("contact_id"=>$createAddress->id,"zip_code"=>$input["zipCode"] , "address"=>$input['address'], "district"=>$input['district'], "complement"=>$input['addressComplement'], "city"=>$input['city'], "state"=>$input['addressState']);
                $createAddress->addresses()->create($addressArray);

                return response()->json(['success' => 'Endereço adicionado']);
            } catch(error){
                return response()->json(['error'=>'Erro ao adicionar endereço'], 400);
            }
        }
        return response()->json(['error'=>'Erro ao adicionar endereço'], 400);
    }

    public function updateAddress(Request $request, $id)
    {   
        $input = $request->except('_token');
        if(!empty($input)){
            try{
                $contactAddress = ContactAddress::find($input['id']);
                $contactAddress->zip_code = $input['zip_code'];
                $contactAddress->address = $input['address'];
                $contactAddress->district = $input['district'];
                $contactAddress->complement = $input['complement'];
                $contactAddress->city = $input['city'];
                $contactAddress->state = $input['state'];
                $contactAddress->save();
            } catch(error){
                return response()->json(['error'=>'Erro ao editar endereço'], 400);
            }
            
            return response()->json(['success'=>'Endereço atualizado com sucesso!']);
        }
        return response()->json(['error'=>'Erro ao editar endereço'], 400);
    }

    public function updatePhone(Request $request)
    {
        if(!empty($request)){
            foreach($request["arrayPhones"] as $req){
                try{
                    $contactPhone = ContactPhone::find($req['phoneId']);
                    $contactPhone->cellphone = $req['cellphone'];                
                    $contactPhone->save();
                } catch(error){
                    return response()->json(['error'=>'Erro ao editar contato'], 400);
                }
            }
            return response()->json(['success'=>'Contato atualizado com sucesso!']);
        }
        return response()->json(['error'=>'Erro ao editar contato'], 400);
    }

    public function destroyPhone($id)
    {
        if(!empty($id)){
            try
            {
                ContactPhone::find($id)->delete();
            } catch(error) {

            }
            return response()->json(['success'=>'Telefone apagado']);
        }
        return response()->json(['error'=>'Erro ao apagar telefone'], 400);
    }

    public function destroyAddress($id)
    {
        if(!empty($id)){
            try
            {
                ContactAddress::find($id)->delete();
                return response()->json(['success'=>'Endereço apagado']);
            } catch (error){
                return response()->json(['error'=>'Erro ao apagar endereço'], 400);
            }
        }
        return response()->json(['error'=>'Erro ao apagar endereço'], 400);
    }
}
