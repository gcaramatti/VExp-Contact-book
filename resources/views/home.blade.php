@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Contatos</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-md-12 text-end mt-3 mb-3">
                        <a class="login-a a-button" href="{{ route('categorias') }}">
                            Gerenciar categorias
                        </a>
                    </div>
                    Você está logado!
                </div>
            </div>
        </div>
    </div>

    <div class="new-contact" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <div class="btn-new-contact">
            Novo contato
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-min-width">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cadastrar novo contato</h5>
            </div>
            <form id="new-contact">
                <div class="modal-body" style="background-color: #262626; display: flex;flex-wrap: wrap;">
                    <div class="form-group width-100 mt-2 mb-2" style="color: white">
                        <div class="card-header" style="padding-top:0px; padding-left:0px; border-bottom: 1px solid white;">
                            <h4 class="card-title">Contato</h4>
                        </div>
                    </div>
                    <div class="width-100 mb-3 mt-3 flex">
                        <div class="col-md-12 mb-3 mt-3">
                            <input id="contact-name" type="text" class="form-control" name="contact-name" placeholder="Nome" required autofocus>
                        </div>
                        <div class="col-md-6">
                            <input id="cellphone" type="text" class="form-control" name="cellphone" placeholder="Telefone" required autofocus>
                        </div>
                        <div class="col-md-5 ml-36px">
                            <select name="" id="contact-category" class="select-control">
                                @foreach ($categories as $category)
                                <option style="color: black" value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group width-100 mt-2" style="color: white">
                        <div class="card-header" style="padding-top:0px; padding-left:0px; border-bottom: 1px solid white;">
                            <h4 class="card-title">Endereço</h4>
                        </div>
                    </div>
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
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <script src="{{ asset('js/mask/dist/jquery.min.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="{{ asset('js/mask/dist/jquery.mask.min.js') }}"></script>
    
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    
    <script src="{{ asset('js/home/home.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    
</div>
@endsection
