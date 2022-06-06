@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Categorias</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (!isset($categories[0]))
                    <div>
                        Você ainda não tem categorias cadastradas. Cadastre-as no botão abaixo!
                    </div>
                        @else
                            <table class="display" style="width:100%">
                                <table class="table card-table">
                                    <thead>
                                    <tr>
                                        <th scope="col">N°</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                        <tr>
                                            <th scope="row">{{$category->id}}</th>
                                            <td class="name">{{$category->name}}</td>
                                            <td>{{$category->created_at}}</td>
                                            <td>
                                                <a class="pointer" onclick="showCategory(this)" data-cat-id="{{$category->id}}" data-bs-toggle="modal" data-bs-target="#edit-category-modal">
                                                    <img style="color: white" src="/icons/pencil-square.svg" />
                                                </a>
                                                <a class="pointer" onclick="deleteCategory(this)" data-id="{{$category->id}}"><img style="color: white" src="/icons/trash3.svg" /></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="new-contact" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <div class="btn-new-contact">
            Nova categoria
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-min-width">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cadastrar nova categoria</h5>
            </div>
            <form id="new-category">
                <div class="modal-body" style="background-color: #262626; display: flex;flex-wrap: wrap;">
                    <div class="width-100">
                        <input id="cat-name" type="text" class="form-control" name="cat-name" placeholder="Nome da categoria" required autofocus>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button id="btn-create-category" type="submit" class="btn btn-primary">Criar</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <div class="modal fade" id="edit-category-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-min-width">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar categoria</h5>
            </div>
            <div id="loader">
                <div class="d-flex justify-content-center mt-5 mb-5">
                    <div class="spinner-border text-light" role="status">
                    <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            <div id="content-edit-modal" style="display: none">
                <form id="edit-category-form">
                    <div class="modal-body" style="background-color: #262626; display: flex;flex-wrap: wrap;">
                        <div class="width-100">
                            <input id="cat-name-edit" type="text" class="form-control" name="cat-name-edit" placeholder="Nome da categoria" required autofocus>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button id="btn-create-category" type="submit" class="btn btn-primary">Criar</button>
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
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/category/category.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</div>
@endsection
