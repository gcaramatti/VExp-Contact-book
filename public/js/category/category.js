$('#new-category').submit(function() {
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

        success: function(data){
            console.log(data);
        }
    });
});

function deleteCategory(e){
    let idCategory = $(e).attr("data-id");
    let token = $("meta[name='csrf-token']").attr("content");

    $.ajax({
        type:'DELETE',
        url: "/apagar-categoria/"+idCategory,
        data: {
            "id": idCategory,
            "_token": token,
        },
        success:function(data){
             if($.isEmptyObject(data.error)){
                 alert(data.success);
                 location.reload();
             }else{
                 printErrorMsg(data.error);
             }
        }
     });
}