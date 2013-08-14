$(function(){
		$(".actionCategoriaGerenciar").on("click",function(){
			$(".gerCategorias").slideToggle();
		});
		$(".actionSubcategoriaGerenciar").on("click",function(){
			$(".gerSubCategorias").slideToggle();
		});
		$('#criaCategorias,#criaSubCategorias,#addProdutos').on('hidden', function () {
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
		
		$("#addProduto").on("click", function(){			
			var categoria = $('#formProduto select[name=inputCategoria]').val();
			var subcategoria = $('#formProduto select[name=inputSubCategoria]').val();
			var titulo = $('#formProduto input[name=titulo]').val();
			var valor = $('#formProduto input[name=valor]').val();
			
			$.ajax({
				type	 :	"post",
				url		 :	basePatch+"/administrador/produto/adicionar",
				dataType :  "json",
				data	 :	{inputCategoria:categoria, inputSubCategoria:subcategoria, titulo:titulo, valor:valor},
				success	 :	function(data){					
					$("#message").removeClass("alert-error");
					$("#message").removeClass("alert-success");
					
					var html = "";
					if(data.titulo) {
						html += "<span> O campo <strong>Titulo</strong> "+data.titulo+"</span>"; 
						$("#message").addClass("alert-error");
					}
					if(data.success) {
						html += "<span>"+data.success+"</span>"; 
						$("#message").addClass("alert-success");
						$("#addProdutos #fecharModal").html("Fechar");
						$("#addProdutos #addProduto").remove();
					}
					
					$("#message").html(html);
					$("#message").css('display','block');
					
				},
				error	:	function(){
					alert("ERROR");			
				}
			});
			
		});
});