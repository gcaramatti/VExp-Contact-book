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
  
        $("#state").css('background-color', '#d3d3d385');
        $("#city").css('background-color', '#d3d3d385');
        $("#district").css('background-color', '#d3d3d385');
        $("#address").css('background-color', '#d3d3d385');
  
    }).fail(function (textStatus) {
        console.log(name + " -> Request failed: " + textStatus);
  
    }).always(function (response) {
      console.log(response);
        console.log(name + " -> completou");
    });
  }