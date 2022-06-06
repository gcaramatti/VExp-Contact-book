$(document).ready(function(){
    $('.phone-format').mask('(00) 00000-0000');
    $('#cellphone').mask('(00) 00000-0000');
    $('#zip_code').mask('00000-000');
    for(let i = 0; i < $('.phone-format').length; i++){
        $('.phone-format')[i].innerText = formatPhoneNumber($('.phone-format')[i].innerText);
    }
    $('#btn-save-phone').prop('disabled', true)
    $('#btn-save-address').prop('disabled', true)
});

function myCallback(response) {
    response = JSON.parse(response);
  
    if (response['status'] == 200) {
        $("#city").val(response['city']);
        $("#district").val(response['district']);
        $("#state").val(response['state']);
        $("#address").val(response['address'].split(" -")[0]);
    }
}
  
// Seleciona a lista e passando parâmetros de consulta para o AJAX 
function refreshAdress() {
var zip_code = $("#zip_code").val();
getDataFromCep("https://ws.apicep.com/cep/" + zip_code + ".json", "", "Get Data From CEP");
}
  
document.getElementById("zip_code").onchange = function () { refreshAdress() };
  
  
function getDataFromCep(script, data, name) {
$.ajax({
    url: script,
    type: "GET",
    data: data,
    dataType: "html",
    success: myCallback

}).done(function () {
    $("#state").attr("readonly", "readonly");
    $("#city").attr("readonly", "readonly");
    $("#district").attr("readonly", "readonly");
    $("#address").attr("readonly", "readonly");

}).fail(function (textStatus) {
    console.log(name + " -> Request failed: " + textStatus);

}).always(function (response) {
    console.log(response);
    console.log(name + " -> completou");
});
}


$('#add-phone-form').submit(function(e) {
    e.preventDefault();
    let token = $("meta[name='csrf-token']").attr("content");
    ajaxAddPhone(token);
});

function ajaxAddPhone(token){
    let cellphone = $('#cellphone').val();
    let contactId = $('#cellphone').attr('data-contact-id');

    if(cellphone !== null && cellphone !== undefined){
        $.ajax({
        url: '/adicionar-telefone',
        type: 'POST',
        data: {
            'contactId': contactId,
            'cellphone': removeMasks(cellphone),
            '_token': token
        },
        dataType: 'JSON',
        success: function(){
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Telefone adicionado',
                showConfirmButton: false,
                timer: 1500
            }).then(()=>{
                document.location.reload(false);
            });
        },    
        error: function(){
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Não foi possível adicionar esse telefone',
            });
        }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Não foi possível adicionar esse telefone',
        });
    }
}

$('#add-address-form').submit(function(e) {
    e.preventDefault();
    let token = $("meta[name='csrf-token']").attr("content");
    ajaxAddAddress(token);
});

function ajaxAddAddress(token){
    let zipCode = $('#zip_code').val();
    let addressState = $('#state').val();
    let address = $('#address').val();
    let city = $('#city').val();
    let district = $('#district').val();
    let addressComplement = $('#address-complement').val();
    let contactId = $('#btn-save-address').attr('data-contact-id');

    if(zipCode !== null && zipCode !== undefined){
        $.ajax({
        url: '/adicionar-endereco',
        type: 'POST',
        data: {
            'zipCode': zipCode,
            'addressState': addressState,
            'address': address,
            'city' : city,
            'district': district,
            'addressComplement': addressComplement,
            'contactId': contactId,
            '_token': token
        },
        dataType: 'JSON',
        success: function(){
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Telefone adicionado',
                showConfirmButton: false,
                timer: 1500
            }).then(()=>{
                document.location.reload(false);
            });
        },    
        error: function(){
            Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Não foi possível adicionar esse endereço',
            });
        }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Não foi possível adicionar esse endereço',
        });
    }
}

function removeMasks(value) {
return value.replace(/[^A-Z0-9]/ig, "");
}

function formatPhoneNumber(phoneNumberString) {
    phoneNumberString = phoneNumberString.replace(/\D/g,'');
    var size = phoneNumberString.length;
    if (size>0) {phoneNumberString="("+phoneNumberString}
    if (size>1) {phoneNumberString=phoneNumberString.slice(0,3)+") "+phoneNumberString.slice(3,12)}
    if (size>6) {phoneNumberString=phoneNumberString.slice(0,10)+"-" +phoneNumberString.slice(10)}
    return phoneNumberString;
}

$('#cellphone').on("keyup", function(){
    if(this.value.length >= 15){
        $('#btn-save-phone').prop('disabled', false)
    }
});

$('#zip_code').on("keyup", function(){
    if(this.value.length >= 9 && $('#address').val() != ''){
        $('#btn-save-address').prop('disabled', false)
    }
});


function deleteAddress(e){
    let idAddress = $(e).attr("data-address-id");
    let token = $("meta[name='csrf-token']").attr("content");
    Swal.fire({
        title: 'Excluir Contato?',
        text: "Você não poderá reverter essa ação depois!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar'
      }).then((result) => {
        if (result.isConfirmed) {
            ajaxDeleteAddress(idAddress, token)
        }
    })
}

function ajaxDeleteAddress(idAddress, token){
    if(idAddress !== null && idAddress !== undefined){
        $.ajax({
            type:'DELETE',
            url: "/apagar-endereco/"+idAddress,
            data: {
                "id": idAddress,
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
                }
            },    
            error: function(){
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Não foi possível apagar esse endereço',
            });
          }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Não foi possível apagar esse endereço!',
        }).then(() => {
            document.location.reload(false);
        });
    }
}

function deletePhone(e){
    let idPhone = $(e).attr("data-phone-id");
    let token = $("meta[name='csrf-token']").attr("content");
    Swal.fire({
        title: 'Excluir Contato?',
        text: "Você não poderá reverter essa ação depois!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirmar'
      }).then((result) => {
        if (result.isConfirmed) {
            ajaxDeletePhone(idPhone, token)
        }
    })
}

function ajaxDeletePhone(idPhone, token){
    if(idPhone !== null && idPhone !== undefined){
        $.ajax({
            type:'DELETE',
            url: "/apagar-telefone/"+idPhone,
            data: {
                "id": idPhone,
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
                }
            },    
            error: function(){
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.error,
            });
          }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Não foi possível apagar esse telefone!',
        }).then(() => {
            document.location.reload(false);
        });
    }
}

$('#edit-contact-form').submit(function(e) {
    e.preventDefault();

    let contactId = $('#cellphone').attr('data-contact-id');
    let token = $("meta[name='csrf-token']").attr("content");
    let contactName = $("#contact-name").val();
    let categoryId = $("#contact-category").val();

    $.ajax({
        type:'PUT',
        url: "/editar-contato/"+contactId,
        data: {
            "name": contactName,
            "category_id": categoryId,
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
            }
        },    
        error: function(){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.error,
        });
      }
    });
});

$('#edit-contact-phone-form').submit(function(e){
    e.preventDefault();
    let token = $("meta[name='csrf-token']").attr("content");

    let teste = $('.edit-phone').map(function(){
        


        let phoneId = $(this).attr('data-phone-id');
        let obj = {};
        let myArray = [];

        obj['cellphone'] = removeMasks($(this).val());
        obj['phoneId'] = phoneId;
        myArray.push(obj);
        return myArray;
    }).get();
    console.log(teste)
    updatePhoneAjax(teste, token)
});

function updatePhoneAjax(teste, token){
    $.ajax({
        type:'PUT',
        url: "/editar-telefone",
        data: {
            "arrayPhones": teste,
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
            }
        },    
        error: function(data){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: data.error,
        });
      }
    });
}