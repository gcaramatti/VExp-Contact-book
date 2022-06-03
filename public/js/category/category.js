$(document).ready(function(){
    $('#btn-create-category').prop('disabled', true)
});

$('#new-category').submit(function(e) {
    e.preventDefault();
    let nameCat = $('#cat-name').val();
    let token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
        url: '/nova-categoria',
        type: 'POST',
        data: {
            'name': nameCat,
            '_token': token
        },
        dataType: 'JSON',
        success: function(){
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Categoria cadastrada',
                showConfirmButton: false,
                timer: 1500
            }).then(()=>{
                document.location.reload(false);
            });
        },
        error: function(e){
            console.log(e)
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: e.responseText,
            });
        }
    });
});

function deleteCategory(e){
    let idCategory = $(e).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");
    Swal.fire({
        title: 'Excluir Categoria?',
        text: "Você não poderá reverter essa ação depois!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar'
      }).then((result) => {
        if (result.isConfirmed) {
            ajaxDelete(idCategory, token)
        }
    })
}

function ajaxDelete(idCategory, token){
    if(idCategory !== null && idCategory !== undefined){
        $.ajax({
            type:'DELETE',
            url: "/apagar-categoria/"+idCategory,
            data: {
                "id": idCategory,
                "_token": token,
            },
            success:function(data){
                if($.isEmptyObject(data.error)){
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(()=>{
                        document.location.reload(false);
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Não foi possível apagar essa categoria!',
                    })
                }
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Não foi possível apagar essa categoria!',
        })
    }
}

$('#cat-name').on("keyup", function(){
    if(this.value.length >= 1){
        $('#btn-create-category').prop('disabled', false)
    }
});