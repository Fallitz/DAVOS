$(document).on('click', '#CancelarUser', function(){ 
    $( ".registerForm" ).remove();
    $('.admin-header').show();
  
    loadAlunos();
  }); 
  
  $(document).on('click', '#registerPage', function(){ 
    var clickBtnValue = this.id;
    var ajaxurl = '/backend/api/v1/pages/register.php',
    data =  {'action': clickBtnValue};
  
    $.post(ajaxurl, data, function (response) {
        var resposta = JSON.parse(response);
        if(resposta.type == "register"){
          $('.admin-header').hide();
          $( ".column" ).remove();
          $('.card-deck').append('<div id="columnListUsers" class="column">');
          $('.column').append(resposta.data);
        }
    });
  
    
  }); 

  $(document).on('click', '#updatePage', function(){ 
    $( ".column" ).remove();
    $('.card-deck').append('<div id="columnListUsers" class="column">');
    loadAlunos();
  }); 

  
  $(document).on('click', '#register', function(){ 
    var clickBtnValue = this.id;
    var ajaxurl = '/backend/api/v1/pages/register.php',
    data =  {'action': clickBtnValue};
  
    $.post(ajaxurl, data, function (response) {
        var resposta = JSON.parse(response);
        if(resposta.type == "register"){
          $('.admin-header').hide();
          $( ".column" ).remove();
          $('.admin-content').append(resposta.data);
        }
    });
  
  }); 

  $(document).on('click', '#deleteLine', function(){ 
    var clickBtnValue = this.id;
    var ajaxurl = '/backend/api/v1/pages/register.php',
    data =  {'action': clickBtnValue};
  
    $.post(ajaxurl, data, function (response) {
        var resposta = JSON.parse(response);
        if(resposta.type == "register"){
          $('.admin-header').hide();
          $( ".column" ).remove();
          $('.admin-content').append(resposta.data);
        }
    });
  
  }); 
  
  
  function removeDiv(elem){
    $(elem).parent('div').parent('div').remove();

  }
  
  
  function loadAlunos(){
    $.get( "/backend/api/v1/aluno/getall/", function( data ) {
      var resposta = JSON.parse(data);
      resposta.data.forEach(element => {
        $('.column').append('<div class="card">'+
          '<div class="card-body">'+
              '<input class="card-text" placeholder="Nome" value="'+ (element.nome ? element.nome : "") +'" disabled/>'+
              '<input class="card-text" placeholder="Email" value="'+ (element.email ? element.email : "") +'" disabled/>'+
              '<input class="card-text" placeholder="Telefone" value="'+ (element.phone ? element.phone : "") +'" disabled/>'+
              '<input class="card-text" placeholder="Preço" value="'+ (element.price ? element.price : "") +'" disabled/>'+
              '<input class="card-text" placeholder="Observação" value="'+ (element.note ? element.note : "") +'" disabled/>'+
              '<input class="card-text" placeholder="Status" value="'+ (element.status ? element.status : "") +'" disabled/>'+
              '<a class="btn btn-primary">Edit</a>'+
              '<a id="deleteLine" class="btn btn-primary">X</a>'+
          '</div>'+
       '</div>');
      }
      );
    });
  }
  
  loadAlunos();