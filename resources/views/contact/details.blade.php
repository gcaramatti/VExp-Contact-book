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
                    <?php //dd($categoryDetails); ?>
                    <div class="col-md-12 text-end mt-4 mb-4">
                        <a class="login-a a-button pointer" data-bs-toggle="modal" data-bs-target="#add-phone">
                            Adicionar telefone
                        </a>
                        <a class="login-a a-button pointer" style="margin-left: 20px" data-bs-toggle="modal" data-bs-target="#add-address">
                            Adicionar endereço
                        </a>
                    </div>
                    <div class="col-md-12 mt-3 mb-3">
                        <h3>{{$categoryDetails[0]->name}}</h3>
                        <p>{{$categoryDetails[0]->cat_name}}</p>
                    </div>
                    <hr>
                    <div class="col-md-12 mt-3 mb-3">
                        <h4>Telefones:</h4>
                        @foreach ($phoneList as $phone)
                            <p>{{$phone->cellphone}}</p>
                        @endforeach
                    </div>
                    <hr>
                    <div class="col-md-12  mt-3 mb-3">
                        <h4>Endereços:</h4>
                        @foreach ($addressList as $address)
                            <p>{{$address->address}}, {{$address->complement}} - {{$address->district}} - {{$address->city}} / {{$address->state}}</p>
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
            <form id="new-category">
                <div class="modal-body" style="background-color: #262626; display: flex;flex-wrap: wrap;">
                    <div class="width-100">
                        <input id="cellphone" type="text" class="form-control" name="cellphone" placeholder="(00) 00000-0000" required autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button id="btn-save-phone" type="submit" class="btn btn-primary">Criar</button>
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
            <form id="new-category">
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
                    <button id="btn-save-address" type="submit" class="btn btn-primary">Criar</button>
                </div>
            </form>
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
