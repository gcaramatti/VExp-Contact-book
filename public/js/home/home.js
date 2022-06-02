$(document).ready(function(){
    $('#cellphone').mask('(00) 00000-0000');
    $('#zip_code').mask('00000-000');
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

$('#new-contact').submit(function(e) {
  e.preventDefault();
  let token = $("meta[name='csrf-token']").attr("content");
  ajaxNewContact(token);
});

function ajaxNewContact(token){
  let contactName = $('#contact-name').val();
  let cellphone = $('#cellphone').val();
  let contactCategory = $('#contact-category').val();
  let zipCode = $('#zip_code').val();
  let addressState = $('#state').val();
  let address = $('#address').val();
  let city = $('#city').val();
  let district = $('#district').val();
  let addressComplement = $('#address-complement').val();


  $.ajax({
    url: '/novo-contato',
    type: 'POST',
    data: {
        'contactName': contactName,
        'cellphone': cellphone,
        'contactCategory':contactCategory,
        'zipCode': zipCode,
        'addressState': addressState,
        'address': address,
        'city' : city,
        'district': district,
        'addressComplement': addressComplement,
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
    }
  });
}