$(document).ready(function () {
	var curChildNum;
	var pplInRoomParams = {a:2, ch1:{exst:false, age:0}, ch2:{exst:false, age:0}, ch3:{exst:false, age:0}};
    $('.formDirections__bottom-close, .formDirections__close-red, .js-close-formDirections, .formDirections__close-abs').on('click', function () {
        $(this).closest('.formDirections').hide();
		var countChld = 0;
		var ppl = pplInRoomParams.a + ' взрослых';
		if(pplInRoomParams.ch3.exst){countChld++;}
		if(pplInRoomParams.ch2.exst){countChld++;}
		if(pplInRoomParams.ch1.exst){ppl += '<span class="fz13 normal"> + '; countChld++;}
		if(countChld >0){ppl += (countChld + ' дет.');ppl += '</span>';}
		var child_age = (countChld > 0)?' (':'';
				if(pplInRoomParams.ch1.age != 0){child_age += (pplInRoomParams.ch1.age + ' ');}
				if(pplInRoomParams.ch2.age != 0){child_age += (pplInRoomParams.ch2.age + ' ');}
				if(pplInRoomParams.ch3.age != 0){child_age += (pplInRoomParams.ch3.age + ' ');}
		
		child_age += (countChld > 0)?'лет)':'';
		$("#pplinroom").html(ppl);
		$("#cf_room_id").val($("#pplinroom").text() + child_age);
    });

    $('.formDirections__SumoSelect ').on('click', 'li.opt', function () {
        $(this).closest('.formDirections').hide();
    });
    /*контрол готсей*/
    $('.formDirections__guest-btn .formDirections__guest-btn-icon').hover(function () {
            $(this).prevAll().addClass('hover-active');
            $(this).nextAll().removeClass('hover-active');
            $(this).addClass('hover-active');
        }
    );
    $('.formDirections__guest-btn').hover(function () {

        },
        function () {

            $('.formDirections__guest-btn-icon').removeClass('hover-active');

        }
    );

    $('.formDirections__guest-btn-icon').on('click', function () {
		if($(this).hasClass('formDirections__guest-btn-icon--sm')){
			
		}else{
			$(this).prevAll().addClass('selected');
        $(this).nextAll().removeClass('selected');
		$("#pplinroom").text(($(this).index()+1) + ' взрослых');
		$("span.formDirections__lb-uppercase:first").closest("span").text(($(this).index()+1) + ' взрослых');
		$("span.formDirections__lb-uppercase:eq(1)").closest("span").text(($(this).index()+1) + ' взрослых');
		$(".js-show-adults .formDirections__guest-btn-icon:eq("+ $(this).index() + ")").prevAll().addClass('selected');
		$(".js-show-adults .formDirections__guest-btn-icon:eq("+ $(this).index() + ")").nextAll().removeClass('selected');

        if ($(this).index() === 0 && $(this).is('.selected')) {
            $(this).removeClass('selected');
        } else {
            $(this).addClass('selected');
			$(".js-show-adults .formDirections__guest-btn-icon:eq("+ $(this).index() + ")").addClass('selected');
        }
		}
        pplInRoomParams.a = $(this).index()+1;
		

    });
    $('.js-added-show1 ').on('click', function () {
        $('.js-added-show2 ').removeClass('hidden');
    });
    $('.js-added-show2 ').on('click', function () {
        $('.js-added-show3 ').removeClass('hidden');
    });
    $('.js-add-more-adults ').on('click', function () {
        $('.js-hide-adults ').hide();
        $('.js-show-adults ').show();
    });
    $('.js-show-ages  ').on('click', function () {
        $(this).closest('.formDirections__bottom-item ').hide();
        $('.js-ages').show();
		curChildNum = $(this);
    });
    $('.formDirections__price-currency--sm').on('click', function () {
        $(this).closest('.formDirections').find('.formDirections__bottom-item ').show();
        $('.js-ages').hide(); 
		curChildNum.prev('i').addClass("selected");
		curChildNum.find('span.bth__inp').text($(this).index()+1);
		if(curChildNum.hasClass('js-added-show1')){pplInRoomParams.ch1.exst = true; pplInRoomParams.ch1.age = $(this).index()+1;}
		else if (curChildNum.hasClass('js-added-show2')){pplInRoomParams.ch2.exst = true; pplInRoomParams.ch2.age = $(this).index()+1;}
		else if (curChildNum.hasClass('js-added-show3')){pplInRoomParams.ch3.exst = true; pplInRoomParams.ch3.age = $(this).index()+1;}
    });



    /*контрол параетров*/
    $('.js-show-currencys').on('click', function () {
        $(this).closest('.formDirections').find('.js-hide-price-inputs').hide();
        $(this).closest('.formDirections').find('.js-act-currencys').show();
    });

    $('.js-act-currencys .formDirections__price-currency').on('click', function () {
        $(this).closest('.formDirections').find('.js-hide-price-inputs').show();
        $(this).closest('.formDirections__price-wrap').hide();

    });
    $('.formDirections__price-currency').on('click', function () {
        var valCurrency = $(this).find('.formDirections__price-currency-lb .formDirections__price-currency-sign').text();
        $(this).closest('.formDirections').find('.formDirections__price-input-bbl').text(valCurrency);

    });

    $('.formDirections .js-act-country').on('click', function () {
        $(this).closest('.formDirections').find('.js-search-country').show();
        $(this).closest('.formDirections').find('.js-search-city').hide();
        $(this).closest('.formDirections').find('.js-search-hotels').hide();
        $(this).closest('.formDirections').find('.js-search-stars').hide();
        $(this).closest('.formDirections').find('.js-search-rating').hide();
        $(this).closest('.formDirections').find('.js-search-kid').hide();
        $(this).closest('.formDirections').find('.js-search-other').hide();
        $(this).closest('.formDirections').find('.formDirections__top-tab').removeClass('active');
        $(this).addClass('active');
    });
    $('.formDirections  .js-act-city').on('click', function () {
        $(this).closest('.formDirections').find('.js-search-country').hide();
        $(this).closest('.formDirections').find('.js-search-city').show();
        $(this).closest('.formDirections').find('.js-search-hotels').hide();
        $(this).closest('.formDirections').find('.js-search-stars').hide();
        $(this).closest('.formDirections').find('.js-search-rating').hide();
        $(this).closest('.formDirections').find('.js-search-kid').hide();
        $(this).closest('.formDirections').find('.js-search-other').hide();
        $(this).closest('.formDirections').find('.formDirections__top-tab').removeClass('active');
        $(this).addClass('active');
    });
    $('.formDirections  .js-act-hotels').on('click', function () {
        $(this).closest('.formDirections').find('.js-search-country').hide();
        $(this).closest('.formDirections').find('.js-search-city').hide();
        $(this).closest('.formDirections').find('.js-search-hotels').show();
        $(this).closest('.formDirections').find('.js-search-stars').hide();
        $(this).closest('.formDirections').find('.js-search-rating').hide();
        $(this).closest('.formDirections').find('.js-search-kid').hide();
        $(this).closest('.formDirections').find('.js-search-other').hide();
        $(this).closest('.formDirections').find('.formDirections__top-tab').removeClass('active');
        $(this).addClass('active');
    });
    $('.formDirections  .js-act-stars').on('click', function () {
        $(this).closest('.formDirections').find('.js-search-country').hide();
        $(this).closest('.formDirections').find('.js-search-city').hide();
        $(this).closest('.formDirections').find('.js-search-hotels').hide();
        $(this).closest('.formDirections').find('.js-search-stars').show();
        $(this).closest('.formDirections').find('.js-search-rating').hide();
        $(this).closest('.formDirections').find('.js-search-kid').hide();
        $(this).closest('.formDirections').find('.js-search-other').hide();
        $(this).closest('.formDirections').find('.formDirections__top-tab').removeClass('active');
        $(this).addClass('active');
    });
    $('.formDirections  .js-act-rating').on('click', function () {
        $(this).closest('.formDirections').find('.js-search-country').hide();
        $(this).closest('.formDirections').find('.js-search-city').hide();
        $(this).closest('.formDirections').find('.js-search-hotels').hide();
        $(this).closest('.formDirections').find('.js-search-stars').hide();
        $(this).closest('.formDirections').find('.js-search-rating').show();
        $(this).closest('.formDirections').find('.js-search-kid').hide();
        $(this).closest('.formDirections').find('.js-search-other').hide();
        $(this).closest('.formDirections').find('.formDirections__top-tab').removeClass('active');
        $(this).addClass('active');
    });
    $('.formDirections  .js-act-kid').on('click', function () {
        $(this).closest('.formDirections').find('.js-search-country').hide();
        $(this).closest('.formDirections').find('.js-search-city').hide();
        $(this).closest('.formDirections').find('.js-search-hotels').hide();
        $(this).closest('.formDirections').find('.js-search-stars').hide();
        $(this).closest('.formDirections').find('.js-search-rating').hide();
        $(this).closest('.formDirections').find('.js-search-kid').show();
        $(this).closest('.formDirections').find('.js-search-other').hide();
        $(this).closest('.formDirections').find('.formDirections__top-tab').removeClass('active');
        $(this).addClass('active');
    });
    $('.formDirections  .js-act-other').on('click', function () {
        $(this).closest('.formDirections').find('.js-search-country').hide();
        $(this).closest('.formDirections').find('.js-search-city').hide();
        $(this).closest('.formDirections').find('.js-search-hotels').hide();
        $(this).closest('.formDirections').find('.js-search-stars').hide();
        $(this).closest('.formDirections').find('.js-search-rating').hide();
        $(this).closest('.formDirections').find('.js-search-kid').hide();
        $(this).closest('.formDirections').find('.js-search-other').show();
        $(this).closest('.formDirections').find('.formDirections__top-tab').removeClass('active');
        $(this).addClass('active');
    });


    $('.formDirections .formDirections__arr').on('click', function () {
        $(this).closest('.formDirections__city').find('.formDirections__drop-city').toggle();
        $(this).toggleClass('active')
    });


    $('.js-show-formDirections').on('click', function () {

        $('.form-date + div').addClass('hidden');
        $(this).closest('html').find('.formDirections').hide();
        $(this).next('.formDirections').slideDown();

    });


    $('.bth__inp-block .form-date').on('click', function () {
        $('.formDirections').hide();
        $('.bth__sumo-currency .SumoSelect').removeClass('open');

    });



    // Большие контролы

    var windowWidth = Math.max($(window).width(), window.innerWidth);
    if (windowWidth <= 509) {


        // При открытии закрыть табы
        $('.js-formDirections--big-mobile').on('click', function () {
            $('html, body').css('overflow', 'hidden')
        });
        $('.formDirections--big-mobile  .formDirections__top .formDirections__bottom-close, .js-close-formDirections').on('click', function () {
            $('html, body').css('overflow', 'auto')
        });


    }
    $('.bth__ta-resizable').focus(function () {
        $('.bth__ta-resizable-hint').addClass('active');
        $(this).addClass('focus');
    });
    $('.bth__ta-resizable').blur(function () {
        if (!$(this).text()) {

            $('.bth__ta-resizable-hint').removeClass('active');
            $(this).removeClass('focus');
        }
    });$('.formDirections_plus-circle').on('click', function () {
        $(this).toggleClass('active');
        $(this).closest('.formDirections__bottom-item').next().toggle()
    });
});
$(document).on('click', function (e) {
    var $target = $(e.target);
    if (!$target.is(".js-show-formDirections") && !$target.closest(".js-show-formDirections").length &&
        !$target.is(".formDirections") && !$target.closest(".formDirections").length) {
        $(".formDirections").hide();
    }
});

