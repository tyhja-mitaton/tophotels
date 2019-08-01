//ввод после ошибки - убираем подсветку для ошибки
$("#orderform-name").on("input", function(){
	if($("#orderform-name").parent().hasClass("has-error")){
		$("#orderform-name").parent().removeClass("has-error");
	}
});
$("#orderform-phone").on("input", function(){
	if($("#orderform-phone").parent().hasClass("has-error")){
		$("#orderform-phone").parent().removeClass("has-error");
	}
});

//фиксим метку при обновлении с ошибкой
$( document ).ready(function(){
	//и переписываем стили из bootstrap.css
	$("#agreementPanel, #siteRolePanel, #usage-rolePanel, #confidentialityPanel").css("background-color", "#e0e0e0");
	$(".help-block").css("color", "#000000");
	
	if($("#orderform-name").parent().hasClass("has-error") || $("#orderform-phone").parent().hasClass("has-error")){
		location.hash = "form";
	}
	//фикс метки если обновляем страницу при открытом пользовательском соглашении
	var curhash = location.hash;
	if(curhash == "#agreement" || curhash == "#confidentiality" ||
	curhash == "#siteRole" || curhash== "#usage-role"){
		//alert('wrong hash!');
		location.hash = "form";
	}
});
