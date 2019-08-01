$(document).ready(function(){
var defaultNF = 7;
var defaultNT = 14;
var clickCounter = 0;
var nightsRows = $("<div class='form-durability__select-row'></div>");
    for(var i=1;i<=28;i++){
	nightsRows.append("<div class='form-durability__select-item js-duration-cell' data-d='"+i+"'><span>"+i+"</span></div>");
	if(i%7 == 0){
		$('.form-durability__durability').append(nightsRows);
		nightsRows = $("<div class='form-durability__select-row'></div>");
	}
    }
	setUpNightsRange(defaultNF, defaultNT);
	$('.form-durability__durability').on('click', function(event){
		clickCounter++;
		if(clickCounter == 2){$(this).closest('.formDirections').hide();clickCounter = 0;}
		
		defaultNF = Number($(event.target).parent().data('d'));
		
		$('.form-durability__durability').on('mouseover', function(event){
			if($(event.target).parent().data('d') !== undefined){
				//console.log($(event.target).parent().data('d'));
				defaultNT = Number($(event.target).parent().data('d'));
				if(defaultNT > defaultNF){
					setUpNightsRange(defaultNF, defaultNT);
				}
				if(defaultNT == defaultNF){
					$(".js-duration-cell").removeClass("end");
					$(".js-duration-cell").removeClass("selected");
					$( ".js-duration-cell:eq( " + (defaultNF-1) + " )" ).addClass("start");
					$("#sleepovers").html('<b>' + defaultNF + ' нч</b>');
					$("#cf_nights_id").val($("#sleepovers b").text());
				}
				if(defaultNT < defaultNF){
					$(".js-duration-cell").removeClass("end");
					$(".js-duration-cell").removeClass("selected");
					$(".js-duration-cell").removeClass("start");
					$( ".js-duration-cell:eq( " + (defaultNT-1) + " )" ).addClass("start");
					$("#sleepovers").html('<b>' + defaultNT + ' нч</b>');
					$("#cf_nights_id").val($("#sleepovers b").text());
				}
			}
		
		});
		
	});
	
});

function setUpNightsRange(nightsStart, nightsEnd){
	$(".js-duration-cell").removeClass("start");
	$(".js-duration-cell").removeClass("end");
	$(".js-duration-cell").removeClass("selected");
	
	for(var i = nightsStart-1;i<=nightsEnd-1;i++){
		$( ".js-duration-cell:eq( " + i + " )" ).addClass("selected");
	}
	$( ".js-duration-cell:eq( " + (nightsStart-1) + " )" ).addClass("start");
	$( ".js-duration-cell:eq( " + (nightsEnd-1) + " )" ).addClass("end");
	$("#sleepovers").html('<b>' + nightsStart + ' - ' + nightsEnd + ' нч</b>');
	$("#cf_nights_id").val($("#sleepovers b").text());
}
