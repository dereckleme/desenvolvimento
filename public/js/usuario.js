$(document).ready(function(){	
	$(".tentarNovamente").on("click",function(){
		$("#form_erro").fadeOut();
		return false;
	})
	$(".status_criar_conta").on("click",function(){
		$("#form_login").fadeOut("slow",function(){
			$("#form_cadastro").fadeIn();
		});
		return false;
	})
	$(".status_entrar").on("click",function(){
		$("#form_cadastro").fadeOut("slow",function(){
			$("#form_login").fadeIn();
		});
		return false;
	})
	
	
	/*
	 * clear form
	 */
	$(".formAction input[type=text],#form_login input[type=text], #form_cadastro input[type=text]").on("click",function(){
		$(this).val("");
	})
	$(".formAction input[type=password],#form_login input[type=password], #form_cadastro input[type=password]").on("click",function(){
		$(this).val("");
	})
	
	
	/*
	 * 
	 * PopUp User
	 */
	$('.eventOpenPopUp').on("click",function(){
		if($("#Login_Cadastro").css("display") != "none")
			{
				$("#Login_Cadastro").animate({left:"+=15"}, 50,function(){
					$(this).animate({left:"-=30"}, 50,function(){
						$(this).animate({left:"+=15"}, 50,function(){});
					});
				});
			}
		else
			{
		$("#Login_Cadastro").toggle("fast");
			}
		return false;
	})
	$('.status_fechar').on("click",function(){
		$("#form_erro").fadeOut();
		$("#Login_Cadastro").fadeOut("fast");
		return false;
	})
	
	/*
	 * Action cadastra-se;
	 */
	$('.Eventcadastrar').on("click",function(){
		var eventLogin = $(".formActionCadastro .login").val();
		var eventEmail = $(".formActionCadastro .email").val();
		var eventPassword = $(".formActionCadastro .Password").val();
		var eventPasswordConfirm = $(".formActionCadastro .PasswordConfirm").val();
		$.ajax({
			url: basePatch+"/actionUser/Usuario/novoUser",
			type: "post",
			async:false,
			data: {eventLogin:eventLogin,eventEmail:eventEmail,eventPassword:eventPassword,eventPasswordConfirm:eventPasswordConfirm},
			success: function(data) {
					if(data == "1")
						{
							$.ajax({
							url: basePatch+"/actionUser/Login/index",
							type: "post",
							async:false,
							data: {eventLogin:eventLogin,eventPassword:eventPassword},
							success: function(data) {
										if(data == "01")
										{
											$("#Login_Cadastro").fadeOut("fast",function(){
												location.reload();
											});
										}
										else
										{
											$("#Login_Cadastro").animate({left:"+=15"}, 50,function(){
												$(this).animate({left:"-=30"}, 50,function(){
													$(this).animate({left:"+=15"}, 50,function(){
														$(".tipo_erro").html(data);
														$("#form_erro").fadeIn();
													});
												});
											});
											
										}
							},
							error: function(){}
						});
						}
					else
						{
							$("#Login_Cadastro").animate({left:"+=15"}, 50,function(){
								$(this).animate({left:"-=30"}, 50,function(){
									$(this).animate({left:"+=15"}, 50,function(){
										$(".tipo_erro").html(data);
										$("#form_erro").fadeIn();
									});
								});
							});
						}
			},
			error: function(){}
		});
			return false;
	})
	$('.EventcadastrarLoginFinaliza').on("click",function(){
		var eventLogin = $("#BoxLogin .formAction .actionLogin").val();
		var eventEmail = $("#BoxLogin .formAction .actionEmail").val();
		var eventPassword = $("#BoxLogin .formAction .actionPassoword").val();
		var eventPasswordConfirm = $("#BoxLogin .formAction .actionPassowordConfirm").val();
		$.ajax({
			url: basePatch+"/actionUser/Usuario/novoUser",
			type: "post",
			async:false,
			data: {eventLogin:eventLogin,eventEmail:eventEmail,eventPassword:eventPassword,eventPasswordConfirm:eventPasswordConfirm},
			success: function(data) {
					if(data == "1")
						{
						$.ajax({
							url: basePatch+"/actionUser/Login/index",
							type: "post",
							async:false,
							data: {eventLogin:eventLogin,eventPassword:eventPassword},
							success: function(data) {
										if(data == "01")
										{
											location.reload();
										}
										else
										{
											$(".return").html(data);
										}
							},
							error: function(){}
						})
						}
					else
						{
							
							$(".return").html(data);
						}
			},
			error: function(){}
		});
			return false;
	})
	/*
	 * Action Login
	 */
	$('.Eventlogin').on("click",function(){
		var eventLogin = $(".formActionLogin .login").val();
		var eventPassword = $(".formActionLogin .Password").val();
		$.ajax({
			url: basePatch+"/actionUser/Login/index",
			type: "post",
			async:false,
			data: {eventLogin:eventLogin,eventPassword:eventPassword},
			success: function(data) {
						if(data == "01")
						{
							$("#Login_Cadastro").fadeOut("fast",function(){
								location.reload();
							});
						}
						else
						{
							$("#Login_Cadastro").animate({left:"+=15"}, 50,function(){
								$(this).animate({left:"-=30"}, 50,function(){
									$(this).animate({left:"+=15"}, 50,function(){
										$(".tipo_erro").html(data);
										$("#form_erro").fadeIn();
									});
								});
							});
							
						}
			},
			error: function(){}
		});
			return false;
	})
	$('.EventcadastrarEndereco').on("click",function(){
		var actionNome = $("#BoxEndereco .BoxNome").val();
		$.ajax({
			url: basePatch+"/actionUser/Usuario/atualiza",
			type: "post",
			async:false,
			data: {actionNome:actionNome},
			success: function(data) {
				if(data==1)
					{
						$(".msgCadastrase").html("Seu cadastro foi atualizado com sucesso.");
					}
				else
					{
					$(".msgCadastrase").html("Seu cadastro não foi atualizado.");
					}
			},
			error: function(){}
		});	
		return false;
	})
	$(".BoxCEP").mask("99999-999",{completed:function(){
		$.ajax({
			url: basePatch+"/correios/restCep",
			type: "post",
			beforeSend: function(){
				$(".ajaxMsg").html("Carregando...");
			     $(".ajaxMsg").show();
			   },
			   complete: function(){
				   $(".ajaxMsg").hide();
				   },   
			async:false,
			data: {cep:this.val()},
			success: function(data) {
				obj = JSON.parse(data);
				if(obj.cep === undefined)
				{
					
				}
				else
					{
						$(".BoxEndereco").val(obj.rua);
						$(".BoxBairro").val(obj.bairro);
					}
			},
			error: function(){alert("Não conseguimos se comunicar com o gateway dos correios, preencha seus dados manualmente.");}
		});	
	}});
	
})