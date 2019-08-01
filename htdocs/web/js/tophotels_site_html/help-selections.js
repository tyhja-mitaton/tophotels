$(document).ready(function () {
	//очищаем инпуты
	$("#cf_wishes_id").val('');
	$("#cf_price_id").val('');
	$("#cf_hotel_id").val('');
	$("#cf_department").val('без перелёта');
	$("#cf_country").val('не важно');
	$("#cf_city").val('не важно');
	$("#cf_hotel_id2").val('');
	$("#cf_department2").val('без перелёта');
	$("#cf_country2").val('не важно');
	$("#cf_city2").val('не важно');
	$("#cf_hotel_id3").val('');
	$("#cf_department3").val('без перелёта');
	$("#cf_country3").val('не важно');
	$("#cf_city3").val('не важно');
	$("#cf_department_h").val('без перелёта');
	$("#cf_food_id_h").val('любое');
	$("#cf_hotels_id").val('');
	$("#cf_hotels2_id").val('');
	$("#cf_hotels3_id").val('');
	if($("#type2").prop('checked')){$("#type1").prop('checked', true);}
//Табы
    $('#step1').click(function () {
        line($(this));
        _hashState('#step1');
        $('#step1Panel').show();
        $('#formPanel').hide();
        $('#step2Panel').hide();
        $('.step2Panel').hide();
        $('#formStep2Panel').hide();
        $('.orders-consultants').show();
        $('.rega-field').hide();
        $('.orders-back-hotels').hide();
        $('#form-fullPanel').hide();
        $('#step3Panel').hide();
        $('#step0Panel').hide();
    });
    $('#form').click(function () {
        line($(this));
        _hashState('#form');
        $('#step1Panel').hide();
        $('#formPanel').show();
        $('#step2Panel').hide();
        $('.step2Panel').hide();
        $('#formStep2Panel').hide();

        $('.orders-consultants').hide();
        $('.orders-back-hotels').hide();
        $('#form-fullPanel').hide();
        $('#step3Panel').hide();
        $('#step0Panel').hide();
    });
    $('#formStep2').click(function () {
        line($(this));
        _hashState('#formStep2');
        $('#step1Panel').hide();
        $('#formPanel').hide();
        $('#step2Panel').hide();
        $('.step2Panel').hide();
        $('#formStep2Panel').show();
        $('.orders-back-hotels').show();
        $('.orders-consultants').hide();
        $('#form-fullPanel').hide();
        $('#step3Panel').hide();
        $('#step0Panel').hide();
    });
    $('#step2').click(function () {
        line($(this));
        _hashState('#step2');
        $('#step1Panel').hide();

        $('#formPanel').hide();
        $('.orders-back-hotels').hide();
        $('#formStep2Panel').hide();
        $('#step2Panel').show();
        $('.step2Panel').show();

        $('.orders-consultants').hide();
        $('#form-fullPanel').hide();
        $('#step3Panel').hide();
        $('#step0Panel').hide();

    });
    $('#form-full').click(function () {
        line($(this));
        _hashState('#form-full');
        $('#step1Panel').hide();

        $('#formPanel').hide();
        $('.orders-back-hotels').hide();
        $('#formStep2Panel').hide();
        $('#step2Panel').hide();
        $('.step2Panel').hide();
        $('.orders-consultants').show();
        $('#form-fullPanel').show();
        $('#step3Panel').hide();
        $('#step0Panel').hide();
    });
    $('#step3').click(function () {
        line($(this));
        _hashState('#step3');
        $('#step1Panel').hide();

        $('#formPanel').hide();
        $('.orders-back-hotels').hide();
        $('#formStep2Panel').hide();
        $('#step2Panel').hide();
        $('.step2Panel').hide();
        $('.orders-consultants').show();
        $('#form-fullPanel').hide();
        $('#step3Panel').show();
        $('#step0Panel').hide();
    });
    $('#step0').click(function () {
        line($(this));
        _hashState('#step0');
        $('#step1Panel').hide();

        $('#formPanel').hide();
        $('.orders-back-hotels').hide();
        $('#formStep2Panel').hide();
        $('#step2Panel').hide();
        $('.step2Panel').hide();
        $('.orders-consultants').show();
        $('#form-fullPanel').hide();
        $('#step3Panel').hide();
        $('#step0Panel').show();
    });
    var line = function (obj) {
        var w = obj.width();
        var p = obj.position().left;
        var el = $('.line ');
        $('.tab').removeClass('active');
        obj.addClass('active');
        el.clearQueue().animate({
            left: p,
            width: w
        }, 300);
    };

    var _hashState = function (_hash) {
        if (history.pushState) {
            history.pushState(null, null, _hash);
        }
        else {
            location.hash = _hash;
        }
    };


    if (!window.location.hash)
        $('.tab.active').first().click();
    else
        $(window.location.hash).click();

    $(window).bind('hashchange', function () {
        $(window.location.hash).click();
    });
    $('.js-type2').on('click', function () {
        $('.js-types-search-tours-blocks').hide();
        $('.js-types-search-hotel-blocks').show();
    });
    $('.js-type1').on('click', function () {
        $('.js-types-search-tours-blocks').show();
        $('.js-types-search-hotel-blocks').hide();
    });


//Добавляем и удаляем контролы
    $('.js-add-field').on('click', function () {
        $('.js-show-added-field').show();
		$('.js-add-field').on('click', additionalField);
    });
    $('.js-del-field').on('click', function () {
        $('.js-show-added-field').hide();
		$('.js-add-field').off('click', additionalField);
    });
	
	$('.js-del2-field').on('click', function () {
        $('.js-show-added2-field').hide();
    });

    $('.js-add-hotel ').on('click', function () {
        $('.js-show-add-hotel').show();
		$('.js-add-hotel ').on('click', additionalHotel);
    });

    $('.js-del-hotel ').on('click', function () {
        $('.js-show-add-hotel').hide();
		$('.js-add-hotel ').off('click', additionalHotel);
    });
	 $('.js-del2-hotel ').on('click', function () {
        $('.js-show-add2-hotel').hide();
    });
function additionalField(){$('.js-show-added2-field').show();}
function additionalHotel(){$('.js-show-add2-hotel').show();}

//Направление города
    var sumoDirectionCity= $('select[id="sumo-direction-city"]');
    sumoDirectionCity.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoDirectionCity.parent().addClass('open');
    sumoDirectionCity.next().next().css('top', '0').css('position', 'relative');

//Города для доп. направлений
	var sumoDirectionCity2= $('select[id="sumo-direction-city2"]');
    sumoDirectionCity2.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoDirectionCity2.parent().addClass('open');
    sumoDirectionCity2.next().next().css('top', '0').css('position', 'relative');
	
	var sumoDirectionCity3= $('select[id="sumo-direction-city3"]');
    sumoDirectionCity3.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoDirectionCity3.parent().addClass('open');
    sumoDirectionCity3.next().next().css('top', '0').css('position', 'relative');
	
	var sumoTouristCity= $('select[id="sumo-list-city"]');
    sumoTouristCity.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoTouristCity.parent().addClass('open');
    sumoTouristCity.next().next().css('top', '0').css('position', 'relative');

//Направление
    var sumoDirection= $('select[id="sumo-direction"]');
    sumoDirection.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoDirection.parent().addClass('open');
    sumoDirection.next().next().css('top', '0').css('position', 'relative');
	
//Доп. направления
	var sumoDirection2= $('select[id="sumo-direction2"]');
    sumoDirection2.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoDirection2.parent().addClass('open');
    sumoDirection2.next().next().css('top', '0').css('position', 'relative');
	
	var sumoDirection3= $('select[id="sumo-direction3"]');
    sumoDirection3.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoDirection3.parent().addClass('open');
    sumoDirection3.next().next().css('top', '0').css('position', 'relative');


//Список городов вылета
    var sumoListCity = $('select[id="sumo-list-city"]');
    sumoListCity.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoListCity.parent().addClass('open');
    sumoListCity.next().next().css('top', '0').css('position', 'relative');


//Город вылета
    var sumoDepartment = $('select[id="sumo-department"]');
    sumoDepartment.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoDepartment.parent().addClass('open');
    sumoDepartment.next().next().css('top', '0').css('position', 'relative');
//Доп. города вылета
	var sumoDepartment2 = $('select[id="sumo-department2"]');
    sumoDepartment2.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoDepartment2.parent().addClass('open');
    sumoDepartment2.next().next().css('top', '0').css('position', 'relative');
	
	var sumoDepartment3 = $('select[id="sumo-department3"]');
    sumoDepartment3.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoDepartment3.parent().addClass('open');
    sumoDepartment3.next().next().css('top', '0').css('position', 'relative');
	//для раздела конкретный отель, город
	var sumoDepartmenth = $('select[id="sumo-departmenth"]');
    sumoDepartmenth.SumoSelect({
        search: true,
        forceCustomRendering: true
    });
    sumoDepartmenth.parent().addClass('open');
    sumoDepartmenth.next().next().css('top', '0').css('position', 'relative');
	

    var formDateHelp1 = new mytour.searchTours.formDate({
        pickerBlockId: 'js-mt-filter-dtHelp1',
        popupBlockId: 'mtIdxFormDatePPHelp1',
        popupBlock: $('#mtIdxFormDatePPHelp1'),
        datepicker: $('#mtIdxDateHelp1')
    }, mytour.searchTours.main.request); 


    var formDateHelp2 = new mytour.searchTours.formDate({
        pickerBlockId: 'js-mt-filter-dtHelp2',
        popupBlockId: 'mtIdxFormDatePPHelp2',
        popupBlock: $('#mtIdxFormDatePPHelp2'),
        datepicker: $('#mtIdxDateHelp2')
    }, mytour.searchTours.main.request);

	//подставляем выбранную страну в поле, скрываем в городах предложение выбрать страну
	$("#sumo-direction").on("change", function(){
	var chosenCountry = $("#sumo-direction option:selected").text();
	var cnt_value = $("#sumo-direction option:selected").val();
	$(".tour-selection__flag:first").removeClass (function (index, className) {
    return (className.match (/(^|\s)lsfw-flag-\S+/g) || []).join(' ');});
	$(".tour-selection__flag:first").addClass("lsfw-flag-" + cnt_value);
	$(".tour-selection__country-cut:first").text(chosenCountry);
	$("#cf_country").val(chosenCountry);
	$(".tour-selection-field--180").find(".formDirections__SumoSelect-search").removeClass("hidden");
	$(".no-country-selected:first").addClass("hidden");
	});
	//поставляем в поле дополнительные страны
	$("#sumo-direction2").on("change", function(){
	var chosenCountry = $("#sumo-direction2 option:selected").text();
	var cnt_value = $("#sumo-direction2 option:selected").val();
	$(".tour-selection__flag:eq(1)").removeClass (function (index, className) {
    return (className.match (/(^|\s)lsfw-flag-\S+/g) || []).join(' ');});
	$(".tour-selection__flag:eq(1)").addClass("lsfw-flag-" + cnt_value);
	$(".tour-selection__country-cut:eq(1)").text(chosenCountry);
	$("#cf_country2").val(chosenCountry);
	$(".js-show-added-field .tour-selection-field--180").find(".formDirections__SumoSelect-search").removeClass("hidden");
	$(".js-show-added-field .no-country-selected").addClass("hidden");
	});
	
	$("#sumo-direction3").on("change", function(){
	var chosenCountry = $("#sumo-direction3 option:selected").text();
	var cnt_value = $("#sumo-direction3 option:selected").val();
	$(".tour-selection__flag:eq(2)").removeClass (function (index, className) {
    return (className.match (/(^|\s)lsfw-flag-\S+/g) || []).join(' ');});
	$(".tour-selection__flag:eq(2)").addClass("lsfw-flag-" + cnt_value);
	$(".tour-selection__country-cut:eq(2)").text(chosenCountry);
	$("#cf_country3").val(chosenCountry);
	$(".js-show-added2-field .tour-selection-field--180").find(".formDirections__SumoSelect-search").removeClass("hidden");
	$(".js-show-added2-field .no-country-selected").addClass("hidden");
	});
	

	$(".bth__inp-range").on("input", function(){
		var price = $(this).val();
		if($(this).prop("name") == 'priceBudgetRangeMin'){
			$("#opt-price2").val(price);
		}
		if($(this).prop("name") == 'priceBudgetRangeMax'){
			$("#max-price2").val(price);
		}
		
	});
	
	$(".formDirections__price-wrap .js-close-formDirections").on("click", function(){
		var budget = $("#opt-price2").val();
		var currency = $(".formDirections__price:first .js-show-currencys").text();
		if(Number($("#max-price2").val()) > 0 && Number($("#max-price2").val()) > Number($("#opt-price2").val())){
			budget += (' - ' + $("#max-price2").val());
		}
		budget += (' ' + currency);
		$(".tour-selection-field--price").find(".bth__inp-lbl ").addClass("active");
		$(".tour-selection-field--price").find(".bth__inp  ").text(budget);
		$("#cf_price_id").val(budget);
	});
	
	$(".tour-selection-field--price").find("i.formDirections__bottom-close").on("click", function(){
		var budget = $("#opt-price2").val();
		var currency = $(".formDirections__price:first .js-show-currencys").text();
		if(Number($("#max-price2").val()) > 0 && Number($("#max-price2").val()) > Number($("#opt-price2").val())){
			budget += (' - ' + $("#max-price2").val());
		}
		budget += (' ' + currency);
		$(".tour-selection-field--price").find(".bth__inp-lbl ").addClass("active");
		$(".tour-selection-field--price").find(".bth__inp  ").text(budget);
		$("#cf_price_id").val(budget);
	});
	
	    //ul список не обновляется вместе с select, так что генерируем здесь. Тут же меняем заголовок списка
		$('#sumo-direction-city').on('depdrop:afterChange', function(event, id, value, jqXHR, textStatus) {
		$(".tour-selection-field--180 .js-show-formDirections:eq(1) .bth__inp").text('не важно');
		var ajaxResults = $('#sumo-direction-city').depdrop('getAjaxResults');
		var resorts_ul = $(".optWrapper:eq(1) ul.options");
		var selected_country = $(".tour-selection__country b.tour-selection__country-cut:first").text();
		$(".formDirections__wrap .formDirections__top-line:eq(1) .formDirections__top-tab").text(selected_country);
		resorts_ul.html('');
		for(var i=0;i < ajaxResults.output.length;i++){
			resorts_ul.append('<li class="opt"><label>' + ajaxResults.output[i].name + '</label></li>');
		}
		//стандартный on change почему-то не срабатывает, вероятно из-за depprop так что заполняем поле по клику
		$(".optWrapper:eq(1) ul.options li.opt").on('click', function(){
			var chosenResort = $(this).text();
			$(".tour-selection-field--180 .js-show-formDirections:eq(1) .bth__inp").text(chosenResort);
			$("#cf_city").val(chosenResort);
			});
    });
	
	//генерируем ul список для доп. направлений
		$('#sumo-direction-city2').on('depdrop:afterChange', function(event, id, value, jqXHR, textStatus) {
		$(".js-show-added-field .tour-selection-field--180 .js-show-formDirections:first .bth__inp").text('не важно');
		var ajaxResults = $('#sumo-direction-city2').depdrop('getAjaxResults');
		var resorts_ul = $(".js-show-added-field .optWrapper:eq(1) ul.options");
		var selected_country = $(".tour-selection__country b.tour-selection__country-cut:eq(1)").text();
		$(".js-show-added-field .formDirections__wrap .formDirections__top-line:eq(1) .formDirections__top-tab").text(selected_country);
		resorts_ul.html('');
		for(var i=0;i < ajaxResults.output.length;i++){
			resorts_ul.append('<li class="opt"><label>' + ajaxResults.output[i].name + '</label></li>');
		}
		//стандартный on change почему-то не срабатывает, вероятно из-за depprop так что заполняем поле по клику
		$(".js-show-added-field .optWrapper:eq(1) ul.options li.opt").on('click', function(){
			var chosenResort = $(this).text();
			$(".js-show-added-field .tour-selection-field--180 .js-show-formDirections:first .bth__inp").text(chosenResort);
			$("#cf_city2").val(chosenResort);
			});
    });
	
		$('#sumo-direction-city3').on('depdrop:afterChange', function(event, id, value, jqXHR, textStatus) {
		$(".js-show-added2-field .tour-selection-field--180 .js-show-formDirections:first .bth__inp").text('не важно');
		var ajaxResults = $('#sumo-direction-city3').depdrop('getAjaxResults');
		var resorts_ul = $(".js-show-added2-field .optWrapper:eq(1) ul.options");
		var selected_country = $(".tour-selection__country b.tour-selection__country-cut:eq(2)").text();
		$(".js-show-added2-field .formDirections__wrap .formDirections__top-line:eq(1) .formDirections__top-tab").text(selected_country);
		resorts_ul.html('');
		for(var i=0;i < ajaxResults.output.length;i++){
			resorts_ul.append('<li class="opt"><label>' + ajaxResults.output[i].name + '</label></li>');
		}
		//стандартный on change почему-то не срабатывает, вероятно из-за depprop так что заполняем поле по клику
		$(".js-show-added2-field .optWrapper:eq(1) ul.options li.opt").on('click', function(){
			var chosenResort = $(this).text();
			$(".js-show-added2-field .tour-selection-field--180 .js-show-formDirections:first .bth__inp").text(chosenResort);
			$("#cf_city3").val(chosenResort);
			});
    });
	//заполняем выбранным городом вылета
		$('.tour-selection-field--200:first .sumo_depcities .optWrapper li.opt').on('click', function(){
			var chosenDeparture = $(this).text();
			$(".tour-selection-field--200:first .js-show-formDirections:first .bth__inp").text(chosenDeparture);
			$("#cf_department").val(chosenDeparture);
		});
	//города вылета для доп.направлений
		$('.js-show-added-field .sumo_depcities .optWrapper li.opt').on('click', function(){
			var chosenDeparture = $(this).text();
			$(".js-show-added-field .tour-selection-field--200 .js-show-formDirections:first .bth__inp").text(chosenDeparture);
			$("#cf_department2").val(chosenDeparture);
		});
		$('.js-show-added2-field .sumo_depcities .optWrapper li.opt').on('click', function(){
			var chosenDeparture = $(this).text();
			$(".js-show-added2-field .tour-selection-field--200 .js-show-formDirections:first .bth__inp").text(chosenDeparture);
			$("#cf_department3").val(chosenDeparture);
		});
		//конкертный отель, город вылета
		$('.js-types-search-hotel-blocks .sumo_depcities .optWrapper li.opt').on('click', function(){
			var chosenDeparture = $(this).text();
			$(".js-types-search-hotel-blocks .tour-selection-field--250 .js-show-formDirections:first .bth__inp").text(chosenDeparture);
			$("#cf_department_h").val(chosenDeparture);
		});
		
		//параметры отеля
		$('.formDirections--char:first .js-close-formDirections').on('click', function(){
			var n = $( ".formDirections__wrap-flex-right:first .formDirections__bottom-blocks .cbx-block.cbx-block--16 .cbx:checked" ).length;
			var r = $( ".formDirections__wrap-flex-right:first .formDirections__bottom-blocks .rbt-block .rbt:checked" ).length;
			n += r;
			//var chkd = $('.tour-selection-wrap .cbx-block.cbx-block--16 .cbx:checked').attr('id');
			$(".tour-selection-field--180 .js-show-formDirections:eq(2) .bth__inp-lbl ").addClass('active');
			$(".tour-selection-field--180 .js-show-formDirections:eq(2) .bth__inp").text(n + '/43');
			
			var allData = [];
			if($("#333stars-ckd").prop('checked')){allData.push($("#333stars-ckd").next().text());}
			if($("#333stars-5").prop('checked')){allData.push('*****');}
			if($("#333stars-4").prop('checked')){allData.push('****');}
			if($("#333stars-3").prop('checked')){allData.push('***');}
			if($("#333stars-2").prop('checked')){allData.push('**');}
			if($("#333stars-1").prop('checked')){allData.push('*');}
			if($("#333stars-hv1").prop('checked')){allData.push($("#333stars-hv1").next().text());}
			if($("#333stars-hv2").prop('checked')){allData.push($("#333stars-hv2").next().text());}
			if($("#no-stars").prop('checked')){allData.push($("#no-stars").next().text());}
			if($("#333rating1").prop('checked')){allData.push($("#333rating1").next().text());}
			if($("#333rating2").prop('checked')){allData.push($("#333rating2").next().text());}
			if($("#333rating3").prop('checked')){allData.push($("#333rating3").next().text());}
			if($("#333rating4").prop('checked')){allData.push($("#333rating4").next().text());}
			if($("#333rating5").prop('checked')){allData.push($("#333rating5").next().text());}
			if($("#333rating6").prop('checked')){allData.push($("#333rating6").next().text());}
			if($("#333rating7").prop('checked')){allData.push($("#333rating7").next().text());}
			if($("#333rating8").prop('checked')){allData.push($("#333rating7").next().text());}
			if($("#333eat2-typeckd").prop('checked')){allData.push($("#333eat2-typeckd").next().text());}
			if($("#333eat2-type1").prop('checked')){allData.push($("#333eat2-type1").next().text());}
			if($("#333eat2-type2").prop('checked')){allData.push($("#333eat2-type2").next().text());}
			if($("#333eat2-type3").prop('checked')){allData.push($("#333eat2-type3").next().text());}
			if($("#333eat2-type4").prop('checked')){allData.push($("#333eat2-type4").next().text());}
			if($("#333eat2-type5").prop('checked')){allData.push($("#333eat2-type5").next().text());}
			if($("#catalog-positionckd").prop('checked')){allData.push($("#catalog-positionckd").next().text());}
			if($("#catalog-position1").prop('checked')){allData.push($("#catalog-position1").next().text());}
			if($("#catalog-position2").prop('checked')){allData.push($("#catalog-position2").next().text());}
			if($("#catalog-position3").prop('checked')){allData.push($("#catalog-position3").next().text());}
			if($("#catalog-position4").prop('checked')){allData.push($("#catalog-position4").next().text());}
			if($("#catalog-position5").prop('checked')){allData.push($("#catalog-position5").next().text());}
			if($("#catalog-position6").prop('checked')){allData.push($("#catalog-position6").next().text());}
			if($("#catalog-position7").prop('checked')){allData.push($("#catalog-position7").next().text());}
			if($("#catalog-position8").prop('checked')){allData.push($("#catalog-position8").next().text());}
			if($("#catalog-position9").prop('checked')){allData.push($("#catalog-position9").next().text());}
			if($("#catalog-position10").prop('checked')){allData.push($("#catalog-position10").next().text());}
			if($("#catalog-position11").prop('checked')){allData.push($("#catalog-position11").next().text());}
			if($("#catalog-position12").prop('checked')){allData.push($("#catalog-position12").next().text());}
			if($("#catalog-position13").prop('checked')){allData.push($("#catalog-position13").next().text());}
			if($("#333kid1").prop('checked')){allData.push($("#333kid1").next().text());}
			if($("#333kid2").prop('checked')){allData.push($("#333kid2").next().text());}
			if($("#333kid3").prop('checked')){allData.push($("#333kid3").next().text());}
			if($("#333kid4").prop('checked')){allData.push($("#333kid4").next().text());}
			if($("#333other1").prop('checked')){allData.push($("#333other1").next().text());}
			if($("#333other2").prop('checked')){allData.push($("#333other2").next().text());}
			
			var alldataStr = allData.join(', ');
			$("#cf_hotel_id").val(alldataStr);
		});
		//доп.
		$('.js-show-added-field .formDirections--char .js-close-formDirections').on('click', function(){
			var n = $( ".js-show-added-field .formDirections__bottom-blocks .cbx-block.cbx-block--16 .cbx:checked" ).length;
			var r = $( ".js-show-added-field .formDirections__bottom-blocks .rbt-block .rbt:checked" ).length;
			n += r;
			$(".js-show-added-field .tour-selection-field--180:eq(1) .js-show-formDirections .bth__inp-lbl ").addClass('active');
			$(".js-show-added-field .tour-selection-field--180:eq(1) .js-show-formDirections .bth__inp").text(n + '/43');
			
			var allData = [];
			if($("#333stars-bckd").prop('checked')){allData.push($("#333stars-bckd").next().text());}
			if($("#333stars-b5").prop('checked')){allData.push('*****');}
			if($("#333stars-b4").prop('checked')){allData.push('****');}
			if($("#333stars-b3").prop('checked')){allData.push('***');}
			if($("#333stars-b2").prop('checked')){allData.push('**');}
			if($("#333stars-b1").prop('checked')){allData.push('*');}
			if($("#333stars-bhv1").prop('checked')){allData.push($("#333stars-bhv1").next().text());}
			if($("#333stars-bhv2").prop('checked')){allData.push($("#333stars-bhv2").next().text());}
			if($("#no-starsb").prop('checked')){allData.push($("#no-starsb").next().text());}
			if($("#333rating1b").prop('checked')){allData.push($("#333rating1b").next().text());}
			if($("#333rating2b").prop('checked')){allData.push($("#333rating2b").next().text());}
			if($("#333rating3b").prop('checked')){allData.push($("#333rating3b").next().text());}
			if($("#333rating4b").prop('checked')){allData.push($("#333rating4b").next().text());}
			if($("#333rating5b").prop('checked')){allData.push($("#333rating5b").next().text());}
			if($("#333rating6b").prop('checked')){allData.push($("#333rating6b").next().text());}
			if($("#333rating7b").prop('checked')){allData.push($("#333rating7b").next().text());}
			if($("#333rating8b").prop('checked')){allData.push($("#333rating8b").next().text());}
			if($("#333eat2-typeckdb").prop('checked')){allData.push($("#333eat2-typeckdb").next().text());}
			if($("#333eat2-type1b").prop('checked')){allData.push($("#333eat2-type1b").next().text());}
			if($("#333eat2-type2b").prop('checked')){allData.push($("#333eat2-type2b").next().text());}
			if($("#333eat2-type3b").prop('checked')){allData.push($("#333eat2-type3b").next().text());}
			if($("#333eat2-type4b").prop('checked')){allData.push($("#333eat2-type4b").next().text());}
			if($("#333eat2-type5b").prop('checked')){allData.push($("#333eat2-type5b").next().text());}
			if($("#catalog-positionckd2").prop('checked')){allData.push($("#catalog-positionckd2").next().text());}
			if($("#catalog-position21").prop('checked')){allData.push($("#catalog-position21").next().text());}
			if($("#catalog-position22").prop('checked')){allData.push($("#catalog-position22").next().text());}
			if($("#catalog-position23").prop('checked')){allData.push($("#catalog-position23").next().text());}
			if($("#catalog-position24").prop('checked')){allData.push($("#catalog-position24").next().text());}
			if($("#catalog-position25").prop('checked')){allData.push($("#catalog-position25").next().text());}
			if($("#catalog-position26").prop('checked')){allData.push($("#catalog-position26").next().text());}
			if($("#catalog-position27").prop('checked')){allData.push($("#catalog-position27").next().text());}
			if($("#catalog-position28").prop('checked')){allData.push($("#catalog-position28").next().text());}
			if($("#catalog-position29").prop('checked')){allData.push($("#catalog-position29").next().text());}
			if($("#catalog-position210").prop('checked')){allData.push($("#catalog-position210").next().text());}
			if($("#catalog-position211").prop('checked')){allData.push($("#catalog-position211").next().text());}
			if($("#catalog-position212").prop('checked')){allData.push($("#catalog-position212").next().text());}
			if($("#catalog-position213").prop('checked')){allData.push($("#catalog-position213").next().text());}
			if($("#333kid1b").prop('checked')){allData.push($("#333kid1b").next().text());}
			if($("#333kid2b").prop('checked')){allData.push($("#333kid2b").next().text());}
			if($("#333kid3b").prop('checked')){allData.push($("#333kid3b").next().text());}
			if($("#333kid4b").prop('checked')){allData.push($("#333kid4b").next().text());}
			if($("#333other1b").prop('checked')){allData.push($("#333other1b").next().text());}
			if($("#333other2b").prop('checked')){allData.push($("#333other2b").next().text());}
			
			var alldataStr = allData.join(', ');
			$("#cf_hotel_id2").val(alldataStr);
		});
		$('.js-show-added2-field .formDirections--char .js-close-formDirections').on('click', function(){
			var n = $( ".js-show-added2-field .formDirections__bottom-blocks .cbx-block.cbx-block--16 .cbx:checked" ).length;
			var r = $( ".js-show-added2-field .formDirections__bottom-blocks .rbt-block .rbt:checked" ).length;
			n += r;
			$(".js-show-added2-field .tour-selection-field--180:eq(1) .js-show-formDirections .bth__inp-lbl ").addClass('active');
			$(".js-show-added2-field .tour-selection-field--180:eq(1) .js-show-formDirections .bth__inp").text(n + '/43');
			
			var allData = [];
			if($("#333stars-cckd").prop('checked')){allData.push($("#333stars-bckd").next().text());}
			if($("#333stars-c5").prop('checked')){allData.push('*****');}
			if($("#333stars-c4").prop('checked')){allData.push('****');}
			if($("#333stars-c3").prop('checked')){allData.push('***');}
			if($("#333stars-c2").prop('checked')){allData.push('**');}
			if($("#333stars-c1").prop('checked')){allData.push('*');}
			if($("#333stars-chv1").prop('checked')){allData.push($("#333stars-chv1").next().text());}
			if($("#333stars-chv2").prop('checked')){allData.push($("#333stars-chv2").next().text());}
			if($("#no-starsc").prop('checked')){allData.push($("#no-starsc").next().text());}
			if($("#333rating1c").prop('checked')){allData.push($("#333rating1c").next().text());}
			if($("#333rating2c").prop('checked')){allData.push($("#333rating2c").next().text());}
			if($("#333rating3c").prop('checked')){allData.push($("#333rating3c").next().text());}
			if($("#333rating4c").prop('checked')){allData.push($("#333rating4c").next().text());}
			if($("#333rating5c").prop('checked')){allData.push($("#333rating5c").next().text());}
			if($("#333rating6c").prop('checked')){allData.push($("#333rating6c").next().text());}
			if($("#333rating7c").prop('checked')){allData.push($("#333rating7c").next().text());}
			if($("#333rating8c").prop('checked')){allData.push($("#333rating8c").next().text());}
			if($("#333eat2-typeckdc").prop('checked')){allData.push($("#333eat2-typeckdc").next().text());}
			if($("#333eat2-type1c").prop('checked')){allData.push($("#333eat2-type1c").next().text());}
			if($("#333eat2-type2c").prop('checked')){allData.push($("#333eat2-type2c").next().text());}
			if($("#333eat2-type3c").prop('checked')){allData.push($("#333eat2-type3c").next().text());}
			if($("#333eat2-type4c").prop('checked')){allData.push($("#333eat2-type4c").next().text());}
			if($("#333eat2-type5c").prop('checked')){allData.push($("#333eat2-type5c").next().text());}
			if($("#catalog-positionckd3").prop('checked')){allData.push($("#catalog-positionckd3").next().text());}
			if($("#catalog-position31").prop('checked')){allData.push($("#catalog-position31").next().text());}
			if($("#catalog-position32").prop('checked')){allData.push($("#catalog-position32").next().text());}
			if($("#catalog-position33").prop('checked')){allData.push($("#catalog-position33").next().text());}
			if($("#catalog-position34").prop('checked')){allData.push($("#catalog-position34").next().text());}
			if($("#catalog-position35").prop('checked')){allData.push($("#catalog-position35").next().text());}
			if($("#catalog-position36").prop('checked')){allData.push($("#catalog-position36").next().text());}
			if($("#catalog-position37").prop('checked')){allData.push($("#catalog-position37").next().text());}
			if($("#catalog-position38").prop('checked')){allData.push($("#catalog-position38").next().text());}
			if($("#catalog-position39").prop('checked')){allData.push($("#catalog-position39").next().text());}
			if($("#catalog-position310").prop('checked')){allData.push($("#catalog-position310").next().text());}
			if($("#catalog-position311").prop('checked')){allData.push($("#catalog-position311").next().text());}
			if($("#catalog-position312").prop('checked')){allData.push($("#catalog-position312").next().text());}
			if($("#catalog-position313").prop('checked')){allData.push($("#catalog-position313").next().text());}
			if($("#333kid1c").prop('checked')){allData.push($("#333kid1c").next().text());}
			if($("#333kid2c").prop('checked')){allData.push($("#333kid2c").next().text());}
			if($("#333kid3c").prop('checked')){allData.push($("#333kid3c").next().text());}
			if($("#333kid4c").prop('checked')){allData.push($("#333kid4c").next().text());}
			if($("#333other1c").prop('checked')){allData.push($("#333other1c").next().text());}
			if($("#333other2c").prop('checked')){allData.push($("#333other2c").next().text());}
			
			var alldataStr = allData.join(', ');
			$("#cf_hotel_id3").val(alldataStr);
		});
		
		//питание
		$('.js-types-search-hotel-blocks .js-close-formDirections').on('click', function(){
			
			var food = $('.js-types-search-hotel-blocks .cbx-block.cbx-block--16 .cbx:checked').next().find('.cbx-cnt').text();
			var food_short = '';
			if(food.indexOf('AI') !== -1){food_short += 'AI ';}
			if(food.indexOf('FB') !== -1){food_short += 'FB ';}
			if(food.indexOf('HB') !== -1){food_short += 'HB ';}
			if(food.indexOf('BB') !== -1){food_short += 'BB ';}
			if(food.indexOf('RO') !== -1){food_short += 'RO ';}
			if(food_short == ''){food_short = 'любое';}
			$(".js-types-search-hotel-blocks .js-show-formDirections:eq(1) .bth__inp").text(food_short);
			$("#cf_food_id_h").val(food_short);
		});
		
		//выбор отеля
		$('.js-types-search-hotel-blocks .tour-selection-wrap-flex:eq(1) .formDirections__bottom-item').on('click', pickHotel);
		
		function pickHotel(){
			$('.js-types-search-hotel-blocks .tour-selection-wrap-flex:eq(1) .tour-selection-field--740 .bth__inp-lbl').addClass('active');
			var hotel = $(this).find('.formDirections__cut').text();
			var resort = $(this).find('.formDirections__count').text();
			$('.js-types-search-hotel-blocks .tour-selection-wrap-flex:eq(1) .tour-selection-field--740 .bth__inp').html(
			'<b><span class="tour-selection__hotel-cut uppercase">' + hotel + 
			'</span></b><span class="normal fz13 ml10">' + resort + '</span>');
			$("#cf_hotels_id").val(hotel + ', ' + resort);
			$(this).closest('.formDirections').hide();
		}
		//доп. отели
		$('.js-types-search-hotel-blocks .js-show-add-hotel .formDirections__bottom-item').on('click', pickHotel2);
		function pickHotel2(){
			$('.js-types-search-hotel-blocks .js-show-add-hotel .tour-selection-field--740 .bth__inp-lbl').addClass('active');
			var hotel = $(this).find('.formDirections__cut').text();
			var resort = $(this).find('.formDirections__count').text();
			$('.js-types-search-hotel-blocks .js-show-add-hotel .tour-selection-field--740 .bth__inp').html(
			'<b><span class="tour-selection__hotel-cut uppercase">' + hotel + 
			'</span></b><span class="normal fz13 ml10">' + resort + '</span>');
			$("#cf_hotels2_id").val(hotel + ', ' + resort);
			$(this).closest('.formDirections').hide();
		}
		$('.js-types-search-hotel-blocks .js-show-add2-hotel .formDirections__bottom-item').on('click', pickHotel3);
		function pickHotel3(){
			$('.js-types-search-hotel-blocks .js-show-add2-hotel .tour-selection-field--740 .bth__inp-lbl').addClass('active');
			var hotel = $(this).find('.formDirections__cut').text();
			var resort = $(this).find('.formDirections__count').text();
			$('.js-types-search-hotel-blocks .js-show-add2-hotel .tour-selection-field--740 .bth__inp').html(
			'<b><span class="tour-selection__hotel-cut uppercase">' + hotel + 
			'</span></b><span class="normal fz13 ml10">' + resort + '</span>');
			$("#cf_hotels3_id").val(hotel + ', ' + resort);
			$(this).closest('.formDirections').hide();
		}
		
		//сформировать заявку, шаг 1
		$('.tour-selection-wrap div.bth__btn--fill').click(function() {
			$('#cmplxf').submit(function(e){
			console.log('sending'); console.log(jQuery().jquery);
			var form = $(this);
			
			$.ajax({
				type: "POST",
				url: 'index.php?r=site%2fupload-step1',
				data: form.serialize()
				}).done(function(msg){$('#step1Panel').html($(msg).find('#step1Panel').html());
				getHandlersAfterAjax();
					}).fail(function(jqXHR, textStatus, responseXML) {console.log('error', textStatus, responseXML, jqXHR.getAllResponseHeaders());});
				e.preventDefault();
				});
				$('#cmplxf').submit();
		});
		
		$('#ad_wishes').on('keyup', function(){
			$("#cf_wishes_id").val($(this).text());
		});
		//получаем список отелей по поисковому запросу
		$('.js-types-search-hotel-blocks .tour-selection-wrap-in:eq(1) input.bth__inp, ' +
		'.js-types-search-hotel-blocks .js-show-add-hotel input.bth__inp, ' +
		'.js-types-search-hotel-blocks .js-show-add2-hotel input.bth__inp').on('keyup', function(e){
			var s_str = $(this).val();
			if(s_str.length >= 3){
				$.ajax({
					type: "POST",
					url: 'index.php?r=site%2fget-hotels',
					data: {s: s_str}
				}).done(function(msg){
					var hotels_list = '';
					var json_msg = JSON.parse(msg);
					var resort_id;
					var res_name;
					if(json_msg.output.length > 0){
						for(var i=0;i < json_msg.output.length;i++){
						resort_id = json_msg.output[i].resort;
						res_name = $.grep(json_msg.resorts, function(n,i){return n.id == resort_id;});
						hotels_list += '<div class="formDirections__bottom-item"><div class="formDirections__city">';
						hotels_list += '<div class=" lsfw-flag lsfw-flag--30w lsfw-flag-' + res_name[0].country 
						+ '"><div class="hint"></div></div>';
						hotels_list += '<span class="formDirections__cut">' + json_msg.output[i].name + '</span>';
						hotels_list += '</div><span class="formDirections__count">' + res_name[0].name + '</span></div>';
						}
					}else{hotels_list += '<p class="no-match" style="display: block;">Нет совпадений для "' + s_str+ '"</p>';}
					
					$(".js-types-search-hotel-blocks .tour-selection-wrap-in .formDirections__bottom-blocks-cut").html(
					hotels_list);
					$('.js-types-search-hotel-blocks .tour-selection-wrap-flex:eq(1) .formDirections__bottom-item').on('click', pickHotel);
					$('.js-types-search-hotel-blocks .js-show-add-hotel .formDirections__bottom-item').on('click', pickHotel2);
					$('.js-types-search-hotel-blocks .js-show-add2-hotel .formDirections__bottom-item').on('click', pickHotel3);
				}).fail(function(jqXHR, textStatus) {console.log('error', textStatus);});
			}
		});
		
		//вешаем обратно отвалившиеся после запроса обработчки
		function getHandlersAfterAjax(){
			$('.js-show-formDirections').on('click', function () {
			$('.form-date + div').addClass('hidden');
			$(this).closest('html').find('.formDirections').hide();
			$(this).next('.formDirections').slideDown();
			});
			
			$('.js-label').on('focus', function () {
			$(this).next('.bth__inp-lbl').addClass('active');
			$(this).closest('.js-show-saggest').next().show();
			});

			$('.js-label').on('blur', function () {
			if ($(this).val().trim() === '') {
			$(this).next('.bth__inp-lbl').removeClass('active');
            $(this).closest('.js-show-saggest').next().hide();
			}
			});
			
			$('.js-label').on('change', function () {
			$('.js-label').each(function () {
				if ($(this).val().length) {
                $(this).next('.bth__inp-lbl').addClass('active');
					}
				});
			});

			
			$("#contact-form2").submit(function(e){
			e.preventDefault();
			var form = $(this); console.log('sending2');
			$.ajax({
				type: "POST",
				url: 'index.php?r=site%2forder-step2',
				data: form.serialize()
				}).done(function(msg){$('#step1Panel').html($(msg).find('#step1Panel').html());
					}).fail(function(jqXHR, textStatus, responseXML) {console.log(textStatus, responseXML, jqXHR.getAllResponseHeaders()); validationFailed();});
			});
			
			var sumoTouristCity= $('select[id="sumo-list-city"]');
			sumoTouristCity.SumoSelect({
						search: true,
						forceCustomRendering: true
					});
			sumoTouristCity.parent().addClass('open');
			sumoTouristCity.next().next().css('top', '0').css('position', 'relative');
			
			$(".tour-selection-field--270 .formDirections__SumoSelect-search ul.options li.opt").on('click', function(){
			var chosenDeparture = $(this).text();
			$(".tour-selection-field--270 .js-show-formDirections .bth__inp").text(chosenDeparture);
			$("#f_tourist_city_id").val(chosenDeparture);
			$(".tour-selection-field--270 .js-show-formDirections .bth__inp-lbl").addClass("active");
			$(this).closest('.formDirections').hide();
			if($("#f_tourist_city_id").parent().hasClass("has-error")){
				$("#f_tourist_city_id").parent().removeClass("has-error");
			}
				});
				
			$(".formDirections__bottom-close").on('click', function(){
				$(this).closest('.formDirections').hide();
			});
			$(".field-orderformplus-name .hint .help-block").css('color', '#000');
			$(".field-orderformplus-phone .hint .help-block").css('color', '#000');
			$('.p-agreement-pp').magnificPopup({
				type: 'inline',
				preloader: false,
				focus: '#username',
				modal: true
			});
			$('.p-agreement-pp').on('click', function () {
				$('html').css('overflow', 'hidden');
			});
			$('.p-agreement-pp.agree').on('click', function () {
				$('#agreement').click()
			});
			$('.p-agreement-pp.site-role').on('click', function () {
				$('#siteRole').click();
			});
		}
		//дефолтная валидация почему-то не работает как надо, делаем свою...
		function validationFailed(){ console.log('validation failed');
			var name_text = $("#orderformplus-name").val();
			var phone_text = $("#orderformplus-phone").val();
			var re = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$/;
			var city_text = $("#f_tourist_city_id").val();
			if(name_text.trim() == ''){
				$("#orderformplus-name").parent().addClass("has-error");
				$("#orderformplus-name").prop("aria-invalid", true);
			}
			if(phone_text.trim().search(re) == -1){
				$("#orderformplus-phone").parent().addClass("has-error");
				$("#orderformplus-phone").prop("aria-invalid", true);
			}
			if(city_text.trim() == ''){
				$("#f_tourist_city_id").parent().addClass("has-error");
				$("#f_tourist_city_id").prop("aria-invalid", true);
			}
			$("#orderformplus-name").on("input", function(){
				if($("#orderformplus-name").parent().hasClass("has-error")){
					$("#orderformplus-name").parent().removeClass("has-error");
				}
			});
			$("#orderformplus-phone").on("input", function(){
				if($("#orderformplus-phone").parent().hasClass("has-error")){
					$("#orderformplus-phone").parent().removeClass("has-error");
				}
			});
		}

})
;

