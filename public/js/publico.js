$(function(){
		//Ações para inserção carrinho de compras
		$(".actionAddCarrinho").on("click", function(){	
			var actionIdProduto = $(this).attr("rev");	
			var actionQuant = $(this).parents("#comprar_detalhe, .box_vejaTambem, .lista_categoria_produtos").find('input').val();
			
			$.ajax({
				url: basePatch+"/carrinho/insert",
				type: "post",
				async:false,
				data: {actionAddCart:actionIdProduto,actionQuant:actionQuant},
				success: function(data) {
					$.ajax({
						url: basePatch+"/carrinho/list",
						type: "post",
						async:false,
						success: function(data) {
							
								$("#box_compras").html(data);
								var quantidadeItens = $("#DescricaoPrecoQuatidade li").size();
									$("#Box_Visor_Qtd .Visor_Qtd").html(quantidadeItens);
									if($("#Box_Visor_Qtd").css("display") == "none")
										{
											$("#Box_Visor_Qtd").fadeIn();
										}
									$(".valor_total").slideUp("fast",function(){
										$.ajax({
											url: basePatch+"/carrinho/detalheCarrinho",
											type: "post",
											async:false,
											success: function(data) {
													$(".valor_total").html(data);
													$(".valor_total").slideDown("fast");
												}
											})
									})
								},
						error: function(){}
							});
				},
				error: function(){}
					});	
			return false;
		});
		$(".actionOpenCarrinho").on("click", function(){	
				var quantidadeItens = $("#DescricaoPrecoQuatidade li").size();
				if(quantidadeItens >= 1)
				{
					$("#box_compras").slideToggle("fast", function () {});
				}
				else
				{
					alert("- Não existe produtos em sua cesta.");
				}
				return false;
		});
		$("#box_compras").on("click",".actionCloseCarrinho", function(){	
				$("#box_compras").slideToggle("fast", function () {});
			return false;
		});
		$(".qtMais_PC, .qtMais").on("click",function(){
				var valor = $(this).parents("#quantidade_produto_categoria, .qtd_produto").find('input').val();
				if($.isNumeric(valor)) $(this).parents("#quantidade_produto_categoria, .qtd_produto").find('input').val(parseInt(valor)+1);
			return false;
		});
		$(".qtMenos_PC, .qtMenos").on("click",function(){
			var valor = $(this).parents("#quantidade_produto_categoria, .qtd_produto").find('input').val();
			if($.isNumeric(valor) && valor > 1) $(this).parents("#quantidade_produto_categoria, .qtd_produto").find('input').val(parseInt(valor)-1);
			return false;
		});
		
		/*
		MudarQtdBotao = function(e){
			var reff = $(this).data('campos').campoQtd,
				idReff = $('#'+reff),
				values = parseInt($(idReff).val()),
				newValue = 1,
				soma = $(this).parent().hasClass('qtMais');
				
			newValue = (soma) ? values + 1 : ((values-1) > 0) ? values-1 : 1;					
			idReff.val(newValue);
			return false;
		};		
		$('li.qtd_mudar a').unbind().each(function(){
			var idQtdInput = $(this).parents('div.qtd_produto').eq(0).find('input.box_qtd').attr('id');				
			$(this).data('campos', {campoQtd: idQtdInput});
		}).click(MudarQtdBotao);
		
		
		MudarQtdBotaoPC = function(e){
			var reff = $(this).data('campos').campoQtd,
				idReff = $('#'+reff),
				values = parseInt($(idReff).val()),
				newValue = 1,
				soma = $(this).parent().hasClass('qtMais_PC');
				
			newValue = (soma) ? values + 1 : ((values-1) > 0) ? values-1 : 1;					
			idReff.val(newValue);
			return false;
		};		
		$('li.qtd_mudar_PC a').unbind().each(function(){
			var idQtdInput = $(this).parents('div.prdQtd').find('input.box_qtd_PC').attr('id');				
			$(this).data('campos', {campoQtd: idQtdInput});
		}).click(MudarQtdBotaoPC);
		*/
});		