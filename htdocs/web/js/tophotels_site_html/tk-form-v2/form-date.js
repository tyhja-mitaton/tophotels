"use strict";

if (typeof mytour === "undefined") {
    var mytour = {};
}

if (typeof mytour.searchTours === "undefined") {
    mytour.searchTours = {};
}

/**
 * РњРѕРґСѓР»СЊ РєР°Р»РµРЅРґР°СЂСЏ
 * @param params
 * @param searchReq
 */
mytour.searchTours.formDate = function(params, searchReq) {
    //
    var self = this;
    var req = searchReq; 

    //
    this.init = false;
    this.pickerBlockId = 'js-mt-filter-dtHelp1';
    this.popupBlock = 'mtIdxFormDatePPHelp1';
    this.dateFormat = 'weekDayShort d.m.y';
    this.pickerType = 'date-range'; // 'date'

    //
    this.popupLabel = $('div[data-id="js-form-popup-date"]');
    this.popupBlockId = 'mtIdxFormDatePPHelp1';
    this.popupBlock = $('#js-form-popup-date');

    this.textDateTitle = $('.field-countries-date_create .bth__inp-lbl');
    this.textLabel = $('.field-countries-date_create .bth__inp');
    this.textCounter = $('.available');
    this.datepicker = $('#mtIdxDateHelp1');
    this.monthBtn = '.js-calendar-month';
    this.diffSelect = $('select[name="calendarDiff"]');
    this.calendarPagePrev = '.gmi-picker-panel__body__main f-lt';
    this.calendarPageNext = '.gmi-picker-panel__body__main f-rt';
    this.monthBtnList = null;

    //
    this.dateToday = new Date();
    this.pickerBlock = null;
    this.pickerObj = null;

    // С„Р»Р°Рі С‚РѕРіРѕ С‡С‚Рѕ РјС‹ С‰Р°СЃ РІС‹Р±РёСЂР°РµРј РїСЂРѕРјРµР¶СѓС‚РѕРє РґР°С‚
    this.inSelectionState = false;
    this.simpleFilterDateLabelDate = 'field-countries-date_create .bth__inp';
    this.simpleFilterDateLabelDiff = '.fz13 normal';

    // Р—Р°РіСЂСѓР·РєР° РїР°СЂР°РјРµС‚СЂРѕРІ
    if (typeof params !== 'undefined') {
        for (var p in params) {
            if (params.hasOwnProperty(p)) {
                self[p] = params[p];
            }
        }
    }

    /** */
    this.reload  = function(request) {
        if (typeof request !== 'undefined') {
            req = request;
        }

        var df = Date.createFromIsoDate(req.df);
        var dt = Date.createFromIsoDate(req.dt);
        var diff = dt.dayDiff(df);

        if (diff < 1) {
            self.textDateTitle.text('Дата вылета');
            self.textLabel.html(df.format(self.dateFormat));
			$('#cf_takeoff_id').val(self.textLabel.text());
            $(self.simpleFilterDateLabelDate).text(df.format(self.dateFormat));
            $(self.simpleFilterDateLabelDiff).text('');
        }
        else {
            self.textDateTitle.text('Период дат вылетов');
            self.textLabel.html(
                df.format(self.dateFormat)
                + '&nbsp;&nbsp;<span class="fz13 normal">+ '
                + daysInflector(diff)//$tkvLocale.day(diff)
                + '</span>'
            );
			$('#cf_takeoff_id').val(self.textLabel.text());
            $(self.simpleFilterDateLabelDate).text(df.format(self.dateFormat));
            $(self.simpleFilterDateLabelDiff).text('+ ' + daysInflector(diff)); //$tkvLocale.day(diff)
        }

        (function(){
            var reqDfMon = Date.createFromIsoDate(req.df).getMonth();
            var reqDfMonNext = reqDfMon + 1;
            var diff = (reqDfMon - (new Date()).getMonth());

            if (diff < 0) {
                diff = 12 + diff;
            }

            $(self.monthBtn).removeClass('active');
            $(self.monthBtn + '[data-month="'+ reqDfMon +'"]').addClass('active');
            $(self.monthBtn + '[data-month="'+ reqDfMonNext +'"]').addClass('active');
            self.datepicker.datepicker('setPageId', diff);
        })();
    };

    /**
     * РЎРѕР·РґР°РЅРёРµ РєР°Р»РµРЅРґР°СЂСЏ
     */
    self.pickerObj = self.datepicker.datepicker({
        type: self.pickerType,
        format: 'yyyy-MM-dd',
        align: 'left',
        lang: 'ru-RU',
        weekStart: 1,
        defaultValue: req.df + ' - ' + req.dt,
        startDate: new Date(),
        endDate: (new Date()).addMonths(12),
        pickerBlockId: self.pickerBlockId,

        onChange: function (newValue) {
            var d = newValue.newDate.split(' - ');
            req.df = d[0];
            req.dt = d[1];

            self.popupBlock.removeClass('d-ib');
            self.popupLabel.removeClass('focus');
            self.reload();
        }
    });
    self.pickerObj.show();
    self.pickerBlock = $('#' + self.pickerBlockId);
    self.pickerBlock.appendTo(self.datepicker.parent()).find('.gmi-picker-panel').show();
    self.datepicker.appendTo(self.datepicker.parent());

    setTimeout(function() {
        self.reload();
        self.init = true;
    }, 150);

    //
    $(document).mouseup(function (e) {
        var target = $(e.target || e.srcElement);

        if (target.closest('#' + self.popupBlockId).length || target.closest('.js-lsfw-ppdb-close').length) {
            return;
        }

        self.popupBlock.removeClass('d-ib');
    });
};

//возвращает слово "день" в правильном падеже
function daysInflector(num){
	var numstr = '' + num;
	var _num = (num > 100)? Number(numstr.substr(-2)): num;
	if(_num < 10 || _num > 20){
		var subnum = numstr.substr(-1, 1);
		var numdays = '';
		(subnum == '2' || subnum == '3' || subnum == '4')? numdays = num + ' дня':(subnum == '1')? 
		numdays = num + ' день': numdays = num + ' дней'; 
		return numdays;
	}else{
		return num + ' дней';
	}
}