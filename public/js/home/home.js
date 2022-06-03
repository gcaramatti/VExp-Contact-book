$(document).ready(function(){
    $('#cellphone').mask('(00) 00000-0000');
    $('#zip_code').mask('00000-000');
    for(let i = 0; i < $('.phone-format').length; i++){
      $('.phone-format')[i].innerText = formatPhoneNumber($('.phone-format')[i].innerText);
  }
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

$('#collapse-toggle').on('click', function(){
  $('#filter').toggleClass('show', 900000);
});

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
        'cellphone': removeMasks(cellphone),
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
            title: 'Contato cadastrado',
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
        text: 'Não foi possível cadastrar esse contato',
      });
    }
  });
}

function removeMasks(value) {
  return value.replace(/[^A-Z0-9]/ig, "");
}

function deleteContact(e){
  let idContact = $(e).attr("data-id");
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
          ajaxDelete(idContact, token)
      }
  })
}

function ajaxDelete(idContact, token){
  if(idContact !== null && idContact !== undefined){
      $.ajax({
          type:'DELETE',
          url: "/apagar-contato/"+idContact,
          data: {
              "id": idContact,
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
              text: 'Não foi possível apagar esse contato',
          });
        }
      });
  } else {
      Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Não foi possível apagar essa categoria!',
      }).then(() => {
          document.location.reload(false);
      });
  }
}

function formatPhoneNumber(phoneNumberString) {
  phoneNumberString = phoneNumberString.replace(/\D/g,'');
  var size = phoneNumberString.length;
  if (size>0) {phoneNumberString="("+phoneNumberString}
  if (size>1) {phoneNumberString=phoneNumberString.slice(0,3)+") "+phoneNumberString.slice(3,12)}
  if (size>6) {phoneNumberString=phoneNumberString.slice(0,10)+"-" +phoneNumberString.slice(10)}
  return phoneNumberString;
}


searchContactByName()
searchContactByCategory()

function searchContactByName(){
  let delayTimer;
  $('#search-contact-name').on("keyup", function(){
    const searchInputText = this.value;
    const allTasks = $(".contact-row");
    delayTimer = setTimeout(function(){
      for(let i = 0; i < allTasks.length; i++){
        const taskTitle = allTasks[i].childNodes[3].innerText;
        allTasks[i].style.display = "none";

        if(searchInputText != '' && (taskTitle.toLowerCase().includes(searchInputText.toLowerCase()))){
          allTasks[i].style.display = "table-row";
        }
        
        if(searchInputText == ''){
          allTasks[i].style.display = "table-row";
        }
      }
    }, 500);

  });
}
function searchContactByCategory(){
  $('#contact-category').on('change', function() {
    const searchInputText = $("#contact-category option:selected").text();
    const allTasks = $(".contact-row");
    delayTimer = setTimeout(function(){
      for(let i = 0; i < allTasks.length; i++){
        const taskTitle = allTasks[i].cells[2].innerText;
        allTasks[i].style.display = "none";

        if(searchInputText != '' && (taskTitle.toLowerCase().includes(searchInputText.toLowerCase()))){
          allTasks[i].style.display = "table-row";
        }
        
        if(searchInputText == 'Todas'){
          allTasks[i].style.display = "table-row";
        }
      }
    }, 500);
  });
}
