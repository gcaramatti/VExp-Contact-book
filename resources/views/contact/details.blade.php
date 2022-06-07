@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Contatos</div>

                <div class="card-body text-start">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-md-12 text-end mt-4 mb-4">
                        <a class="login-a a-button pointer" data-bs-toggle="modal" data-bs-target="#add-phone">
                            Adicionar telefone
                        </a>
                        <a class="login-a a-button pointer" style="margin-left: 20px" data-bs-toggle="modal" data-bs-target="#add-address">
                            Adicionar endereço
                        </a>
                    </div>
                    <div class="col-md-12 mt-3 mb-3">
                        <div class="col-md-12" style="display: flex;">
                            <h4>Contato:</h4>
                            <span class="pointer" style="margin-left: auto;" data-bs-toggle="modal" data-bs-target="#edit-contact-modal">
                                <img style="color: white" src="/icons/pencil-square.svg" />
                            </span>
                        </div>
                        <h5>{{$categoryDetails[0]->name}}</h5>
                        <p>{{$categoryDetails[0]->cat_name}}</p>
                    </div>
                    <hr>
                    <div class="col-md-12 mt-3 mb-3">
                        <div class="col-md-12" style="display: flex;">
                            <h4>Telefones:</h4>
                            <span class="pointer" style="margin-left: auto;" data-bs-toggle="modal" data-bs-target="#edit-phones-modal">
                                <img style="color: white" src="/icons/pencil-square.svg" />
                            </span>
                        </div>
                        @foreach ($phoneList as $phone)
                            <div class="col-md-12" style="display: flex;">
                                <p style="opacity: 0.7;" class="phone-format">{{$phone->cellphone}}</p>
                                <span class="pointer" style="margin-left: auto;" onclick="deletePhone(this)" data-phone-id="{{$phone->id}}">
                                    <img src="/icons/trash3.svg" />
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="col-md-12  mt-3 mb-3">
                        <div class="col-md-12" style="display: flex;">
                            <h4>Endereços:</h4>
                        </div>
                        @foreach ($addressList as $address)
                            <div class="col-md-12" style="display: flex;">
                                <p style="opacity: 0.7">{{$address->address}}, {{$address->complement}} - {{$address->district}} - {{$address->city}} / {{$address->state}}</p>
                                <span class="pointer" style="margin-left: auto;" onclick="showAddress(this)" data-bs-toggle="modal" data-bs-target="#edit-addresses-modal" data-address-id-edit="{{$address->id}}">
                                    <img src="/icons/pencil-square.svg" />
                                </span>
                                <span class="pointer" style="margin-left: 5px;" onclick="deleteAddress(this)" data-address-id="{{$address->id}}"><img style="color: white" src="/icons/trash3.svg" /></span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-phone" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-min-width">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Adicionar telefone para {{$categoryDetails[0]->name}}</h5>
            </div>
            <form id="add-phone-form">
                <div class="modal-body" style="background-color: #262626; display: flex;flex-wrap: wrap;">
                    <div class="width-100">
                        <input id="cellphone" type="text" class="form-control" name="cellphone" placeholder="(00) 00000-0000" required data-contact-id="{{$categoryDetails[0]->contact_id}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button id="btn-save-phone" type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="modal fade" id="add-address" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-min-width">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Adicionar endereço para {{$categoryDetails[0]->name}}</h5>
            </div>
            <form id="add-address-form">
                <div class="modal-body" style="background-color: #262626; display: flex;flex-wrap: wrap;">
                    <div class="width-100 mb-3 mt-3 flex">
                        <div class="col-md-6 mobile">
                            <input id="zip_code" type="text" class="form-control" name="zip_code" placeholder="CEP" required autofocus>
                        </div>
                        <div class="col-md-5 ml-36px mobile">
                            <input id="state" type="text" class="form-control" name="state" placeholder="Estado" readonly autofocus>
                        </div>
                        <div class="width-100 mt-3 mobile">
                            <input id="address" type="text" class="form-control" name="address" placeholder="Logradouro" readonly autofocus>
                        </div>
                        <div class="col-md-6 mt-3 mobile">
                            <input id="city" type="text" class="form-control" name="city" placeholder="Cidade" readonly autofocus>
                        </div>
                        <div class="col-md-5 mt-3 ml-36px mobile">
                            <input id="district" type="text" class="form-control" name="district" placeholder="Bairro" readonly autofocus>
                        </div>
                        <div class="col-md-12 mb-3 mt-3">
                            <input id="address-complement" type="text" class="form-control" name="address-complement" placeholder="Complemento (Apt, bloco...)" required autofocus>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button id="btn-save-address" type="submit" class="btn btn-primary" data-contact-id="{{$categoryDetails[0]->contact_id}}">Salvar</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    
    <div class="modal fade" id="edit-contact-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-min-width">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar {{$categoryDetails[0]->name}}</h5>
            </div>
            <form id="edit-contact-form">
                <div class="modal-body" style="background-color: #262626; display: flex;flex-wrap: wrap;">
                    <div class="width-100 mb-3 mt-3 flex">
                        <div class="col-md-12 mb-3">
                            <input id="contact-name" type="text" class="form-control" name="contact-name" placeholder="Nome" value="{{$categoryDetails[0]->name}}" required autofocus>
                        </div>
                        <div class="col-md-12 mobile">
                            <select name="contact-category" id="contact-category" class="select-control">
                                @foreach ($allCategories as $category)
                                    <?php 
                                    $selected = ""; 
                                    if($categoryDetails[0]->category_id == $category->id){
                                        $selected = "selected";
                                    }
                                    ?>
                                    <option style="color: black" value="{{$category->id}}" {{$selected}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button id="btn-save-address" type="submit" class="btn btn-primary" data-contact-id="{{$categoryDetails[0]->contact_id}}">Salvar</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    
    <div class="modal fade" id="edit-phones-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-min-width">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar {{$categoryDetails[0]->name}}</h5>
                </div>
                <form id="edit-contact-phone-form">
                    <div class="modal-body" style="background-color: #262626; display: flex;flex-wrap: wrap;">
                        <div class="width-100 mb-3 mt-3 flex">
                            @foreach($phoneList as $phone)
                                <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control phone-format edit-phone" name="cellphone-edit" data-phone-id="{{$phone->id}}" placeholder="Nome" value="{{$phone->cellphone}}" required>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button id="btn-save-address" type="submit" class="btn btn-primary" data-contact-id="{{$categoryDetails[0]->contact_id}}">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-addresses-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-min-width">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar telefones {{$categoryDetails[0]->name}}</h5>
                </div>
                <div id="loader">
                    <div class="d-flex justify-content-center mt-5 mb-5">
                        <div class="spinner-border text-light" role="status">
                        <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
                <div id="edit-addresses-content" style="display: none;">
                    <form id="edit-addresse-form">
                        <div class="modal-body" style="background-color: #262626; display: flex;flex-wrap: wrap;">
                            <div class="width-100 mb-3 mt-3 flex">
                                    <h3 style="color: white">Endereço</h3>
                                    <div class="width-100 mb-3 mt-3 flex">
                                        <div class="col-md-6 mobile">
                                            <input id="edit-zip-code" type="text" class="form-control zip-code-format" name="zip_code" placeholder="CEP" required>
                                        </div>
                                        <div class="col-md-5 ml-36px mobile">
                                            <input id="edit-state" type="text" class="form-control" name="state" placeholder="Estado">
                                        </div>
                                        <div class="width-100 mt-3 mobile">
                                            <input id="edit-address" type="text" class="form-control" name="address" placeholder="Logradouro">
                                        </div>
                                        <div class="col-md-6 mt-3 mobile">
                                            <input id="edit-city" type="text" class="form-control" name="city" placeholder="Cidade">
                                        </div>
                                        <div class="col-md-5 mt-3 ml-36px mobile">
                                            <input id="edit-district" type="text" class="form-control" name="district" placeholder="Bairro">
                                        </div>
                                        <div class="col-md-12 mb-3 mt-3">
                                            <input id="edit-complement" type="text" class="form-control" name="address-complement" placeholder="Complemento (Apt, bloco...)" required>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button id="btn-save-address" type="submit" class="btn btn-primary" data-contact-id="{{$categoryDetails[0]->contact_id}}">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/mask/dist/jquery.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="{{ asset('js/mask/dist/jquery.mask.min.js') }}"></script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/details/details.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</div>
@endsection
