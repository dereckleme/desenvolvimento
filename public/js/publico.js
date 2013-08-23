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
		})
		$(".qtMenos_PC, .qtMenos").on("click",function(){
			var valor = $(this).parents("#quantidade_produto_categoria, .qtd_produto").find('input').val();
			if($.isNumeric(valor) && valor > 1) $(this).parents("#quantidade_produto_categoria, .qtd_produto").find('input').val(parseInt(valor)-1);
			return false;
		})
		$(".MoreItens").on("click",function(){
			var referenceId = $(this).parents(".ListaDaCesta").find(".actionCode").val();
			var valor = $(this).parents("#quantidade_produto_categoria, .qtd_produto, #ProductsFromBasket").find('input').val();
			if($.isNumeric(valor)) 
				{
				var UpdateValor = parseInt(valor)+1;
				$(this).parents("#quantidade_produto_categoria, .qtd_produto, #ProductsFromBasket").find('input').val(UpdateValor);
				$.ajax({
					url: basePatch+"/carrinho/insert",
					type: "post",
					async:false,
					data: {actionAddCart:referenceId,actionQuant:UpdateValor},
					success: function(data) {location.reload();},
					error: function(){}
						});
				}
			return false;
		})
		$(".LessItens").on("click",function(){
			var referenceId = $(this).parents(".ListaDaCesta").find(".actionCode").val();
			var valor = $(this).parents("#quantidade_produto_categoria, .qtd_produto, #ProductsFromBasket").find('input').val();
			if($.isNumeric(valor) && valor > 1) 
				{
				var UpdateValor = parseInt(valor)-1;
				$(this).parents("#quantidade_produto_categoria, .qtd_produto, #ProductsFromBasket").find('input').val(UpdateValor);
				$.ajax({
					url: basePatch+"/carrinho/insert",
					type: "post",
					async:false,
					data: {actionAddCart:referenceId,actionQuant:UpdateValor},
					success: function(data) {location.reload();},
					error: function(){}
						});
				}
			return false;
		})
		
});		