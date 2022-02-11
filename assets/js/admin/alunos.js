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

  $(document).on('click', '#SalvarUser', function(){
		var nome = $("#nomeUser").val();
		var email = $("#emailUser").val();
		var password = $("#passwordUser").val();
		var phone = $("#phoneUser").val();
		var price = $("#priceUser").val();
		var note = $("#noteUser").val();

		var ajaxurl = '/backend/api/v1/aluno/register/', 
		data =  {'typePost': '1', 'name': nome, 'email': email, 'password': password, 'phone': phone, 'price': price, 'note': note};

		$.post(ajaxurl, data, function (response) {
			$( ".registerForm" ).remove();
			$('.admin-header').show();
			loadAlunos();
		});
  });

  $(document).on('click', '#deleteLine', function(){ 

    var email = $(this).parent('div').children('input').eq(1).val();

    var ajaxurl = '/backend/api/v1/aluno/delete/',
    data =  {'typePost': 1, 'email': email};

    $.post(ajaxurl, data, function (response) {
        $( ".registerForm" ).remove();
        $('.admin-header').show();
        $( ".column" ).remove();
        $('.card-deck').append('<div id="columnListUsers" class="column">');
        loadAlunos();
    });
  
  }); 

  $(document).on('click', '#updateLine', function(){
    var email = $(this).parent('div').children('input').eq(1).val() ?? $(this).parent('div').children('input').eq(1).val();
    var nome = $(this).parent('div').children('input').eq(0).val() ?? $(this).parent('div').children('input').eq(0).val();
    var phone = $(this).parent('div').children('input').eq(2).val() ?? $(this).parent('div').children('input').eq(2).val();
    var price = $(this).parent('div').children('input').eq(3).val() ?? $(this).parent('div').children('input').eq(3).val();
    var note = $(this).parent('div').children('input').eq(4).val() ?? $(this).parent('div').children('input').eq(4).val();
    var status = $(this).parent('div').children('input').eq(5).val() ?? $(this).parent('div').children('input').eq(5).val();

    var ajaxurl = '/backend/api/v1/aluno/update/', 
    data =  {'typePost': 1, 'email': email, 'nome': nome, 'phone': phone, 'price': price, 'note': note, 'status': status};

    $.post(ajaxurl, data, function (response) {
        $( ".registerForm" ).remove();
        $('.admin-header').show();
        $( ".column" ).remove();
        $('.card-deck').append('<div id="columnListUsers" class="column">');
        loadAlunos();
    });

  });
  
  function loadAlunos(){
    $.get( "/backend/api/v1/aluno/getall/", function( data ) {
      var resposta = JSON.parse(data);
      resposta.data.forEach(element => {
        $('.column').append('<div class="card">'+
          '<div class="card-body">'+
              '<input id="nomeInput" class="card-text" placeholder="Nome" value="'+ (element.nome ?? element.nome) +'"/>'+
              '<input id="emailInput" class="card-text" placeholder="Email" value="'+ (element.email ?? element.email) +'" disabled/>'+
              '<input id="phoneInput" class="card-text" placeholder="Telefone" value="'+ (element.phone ?? element.phone) +'"/>'+
              '<input id="priceInput" class="card-text" placeholder="Preço" value="'+ (element.price ?? element.price) +'"/>'+
              '<input id="noteInput" class="card-text" placeholder="Observação" value="'+ (element.note ?? element.note) +'"/>'+
              '<input id="statusInput" class="card-text" placeholder="Status" value="'+ (element.status ?? element.status) +'"/>'+
              '<a id="updateLine" class="btn btn-primary">Edit</a>'+
              '<a id="deleteLine" class="btn btn-primary">X</a>'+
          '</div>'+
       '</div>');
      }
      );
    });
  }

  loadAlunos();