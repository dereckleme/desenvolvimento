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
				
				alert(data);
			},
			error: function(){}
				});
			return false;
		})
		$(".actionOpenCarrinho").on("click", function(){	
				$("#box_compras").slideToggle("fast", function () {});
				return false;
		})
});		