$(function(){
		$(".actionCategoriaGerenciar").on("click",function(){
			$(".gerCategorias").slideToggle();
		});
		$(".actionSubcategoriaGerenciar").on("click",function(){
			$(".gerSubCategorias").slideToggle();
		});
		$('#criaCategorias,#criaSubCategorias,#addProdutos,#myModalItens,#myModalTable').on('hidden', function () {
			location.reload();
		});
		$("#actionAddCat").on("click",function(){
			var eventCategoria = $("#criaCategorias .tituloCat").val();
			$.ajax({
				url: basePatch+"/administrador/categorias/insert",
				type: "post",
				async:false,
				data: {eventCategoria:eventCategoria},
				success: function(data) {
					if(data == "")
						{
						$("#criaCategorias #message").removeClass('alert-error');
						$("#criaCategorias #message").addClass("alert-success");
						$("#actionAddCat").fadeOut();
						$("#criaCategorias #message").html("- Categoria adicionada com sucesso.");
						
						}
					else
						{
						$("#criaCategorias #message").addClass("alert-error");
						$("#criaCategorias #message").html(data);
						}
					$("#criaCategorias #message").fadeIn();
				}
			});
			
			return false;
		});
		
		$("#actionAddSubCat").on("click",function(){
			var eventCategoria = $("#criaSubCategorias .categoriaId").val();
			var eventSubcategoria = $("#criaSubCategorias .tituloSubCat").val();
			$.ajax({
				url: basePatch+"/administrador/categorias/insertSub",
				type: "post",
				async:false,
				data: {eventCategoria:eventCategoria,eventSubcategoria:eventSubcategoria},
				success: function(data) {
					if(data == "")
					{
					$("#criaSubCategorias #message").removeClass('alert-error')
					$("#criaSubCategorias #message").addClass("alert-success");
					$("#actionAddSubCat").fadeOut();
					$("#criaSubCategorias #message").html("- SubCategoria adicionada com sucesso.");
					
					}
				else
					{
					$("#criaSubCategorias #message").addClass("alert-error");
					$("#criaSubCategorias #message").html(data);
					}
					$("#criaSubCategorias #message").fadeIn();
				}
			});
			return false;
		});
		
		$("select[name=inputCategoria]").on("change", function(){
			var value = $(this).val();
			
			$.ajax({
				type	:	"post",
				url		:	basePatch+"/administrador/produto/subCategoriaByCategoria",
				data	:	{valor:value},
				beforeSend: function(){
					$('select[name=inputSubCategoria]').empty();
					$('select[name=inputSubCategoria]').append("<option>Caregando.....</option>");
				},
				success	:	function(data){
					$('select[name=inputSubCategoria]').empty();
					$('select[name=inputSubCategoria]').append(data);
				},
				error	:	function(){
					
				}
			});
		});		
		
		$(".input-medium").mask("9?99");
		$("#inputPeso").mask("9.999");
		$('#inputValor').priceFormat({
		    prefix: false,
		    centsSeparator: ',',
		    thousandsSeparator: '.'
		});
		
		$("#actionAddReferencia").on("click", function(){	
			var eventReferencia = $("#criaReferencias .tituloReferencia").val();
			$.ajax({
				url: basePatch+"/administrador/referencia/insert",
				type: "post",
				async:false,
				data: {eventReferencia:eventReferencia},
				success: function(data) {
					if(data == "")
						{
						$("#criaReferencias #message").removeClass('alert-error');
						$("#criaReferencias #message").addClass("alert-success");
						$("#actionAddCat").fadeOut();
						$("#criaReferencias #message").html("- Referencia adicionada com sucesso.");
						
						}
					else
						{
						$("#criaReferencias #message").addClass("alert-error");
						$("#criaReferencias #message").html(data);
						}
					$("#criaReferencias #message").fadeIn();
				}
			});
			return false;
		});
		
		$(".my-accordion-toggle").on('click', function(){
			var identif = $(this).attr('href');
			$(identif).slideToggle();
			return false;
		});
		
		$("#addItems").on("click", function(){
			var item = $("input[name=item]").val();
			$.ajax({
				url: basePatch+"/administrador/nutricional/adicionarItem",
				type: "POST",
				data: {saltda:item},
				success: function(data){
					if(data == "")
					{
						$("#mensagensItens").removeClass('alert-error');
						$("#mensagensItens").addClass('alert-success');
						$("#mensagensItens").html("Item adicionado com sucesso.");
						$("#addItems").fadeOut();
					}
					else
					{
						$("#mensagensItens").removeClass('alert-success');
						$("#mensagensItens").addClass('alert-error');
						$("#mensagensItens").html(data);
					}
					$("#mensagensItens").fadeIn();
				}
			});
		});
		
		$("#addTableNutricional").on("click", function(){			
			var iditem = $("select[name=idnutricionalNomes]").val();
			var idprod = $("select[name=idproduto]").val();
			var qtd = $("input[name=quantidade]").val();
			var valor = $("input[name=vd]").val();
			$.ajax({
				url: basePatch+"/administrador/nutricional/criarTabelaNutricional",
				type: "POST",
				data: {quantidade:qtd, vd:valor, idnutricionalNomes:iditem, idproduto:idprod},
				success: function(data){					
					if(data == "")
					{
						$("#mensagensTables").removeClass('alert-error');
						$("#mensagensTables").addClass('alert-success');
						$("#mensagensTables").html("Adicionado com sucesso.");
						$("#addTableNutricional").fadeOut();
					}
					else
					{
						$("#mensagensTables").removeClass('alert-success');
						$("#mensagensTables").addClass('alert-error');
						$("#mensagensTables").html(data);
					}
					$("#mensagensTables").fadeIn();
				}
			});
		});
				
		
		$("form#formCrop").on("click", function(){
			if (parseInt($('#w').val())) return true;
			alert('Por favor, escolha uma região para o recorte e pressione o botão de recorte.');
			return false;
		});
		$('#cropbox').Jcrop({
		    onChange: showCoords,	
	        onSelect: showCoords
	    });
		function showCoords(e) {
			$('#w').val(e.w);
		    $('#h').val(e.h);		    
		    $('#x').val(e.x);
		    $('#y').val(e.y);
		    $('#x2').val(e.x2);
		    $('#y2').val(e.y2);
		}
		
});