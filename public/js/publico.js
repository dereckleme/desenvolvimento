$(function(){
		//Ações para inserção carrinho de compras
		$(".actionAddCarrinho").on("click", function(){	
			var actionIdProduto = $(this).attr("rev");	
			$.ajax({
				url: basePatch+"/carrinho/insert",
				type: "post",
				async:false,
				data: {actionAddCart:actionIdProduto},
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
		})
		$(".actionOpenCarrinho,.actionCloseCarrinho").on("click", function(){	
				$("#box_compras").slideToggle("fast", function () {});
				return false;
		})
		
		
});		