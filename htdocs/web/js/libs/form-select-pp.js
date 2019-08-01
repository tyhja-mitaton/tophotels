"use strict";

if (typeof lsfw === 'undefined') {
    var lsfw = {};
}

if (typeof lsfw.forms === 'undefined') {
    lsfw.forms = {};
}


/**
 * Модуль для создания попапов с сумо нового вида
 * @param popup
 * @param select
 * @param options
 * @constructor
 */
lsfw.forms.selectPopup = function(popup, select, options) {
    //
    var self = this;
    var $popup = null;
    var $popupForm = null;
    var $select = null;
    var isOpen = false;

    //
    var cbOnChange = function(){};

    /**
     *
     */
    this.reload = function() {
        $popup = $(popup);
        $popupForm = $popup.find('.js-form-pp-wsumo');
        $select = $(select);

        $select.SumoSelect(options);
        $select.parent().addClass('open');
        $select.next().next().css('top', '0')
            .css('position', 'relative')
            .css('border-left', 'none')
            .css('border-right', 'none')
            .css('border-bottom', 'none')
            .css('box-shadow', 'none')
        ;

        if (options.search !== true) {
            $select.next().hide();
        }
        else {
            $select.next().find('label').remove();
        }

        $popup.find('.js-form-act-wsumo').click(function () {
            switch (isOpen) {
                case true: $popupForm.fadeOut(400); break;
                case false: $popupForm.fadeIn(250); break;
            }
            isOpen = !isOpen;
        });
    };

    /**
     *
     * @param v
     */
    this.val = function (v) {
        if (v === undefined || v === null) {
            return $select.val();
        }

        return $select.val(v);
    };

    /**
     *
     * @returns {*}
     */
    this.getPopup = function () {
        return $popupForm;
    };

    /**
     *
     * @returns {*}
     */
    this.getSelect = function () {
        return $select;
    };

    /**
     *
     */
    this.show = function () {
        if (!isOpen) {
            $popupForm.fadeIn(250);
        }
        isOpen = true;
    };

    /**
     *
     */
    this.hide = function () {
        if (isOpen) {
            $popupForm.fadeOut(250);
        }
        isOpen = false;
    };

    /**
     *
     */
    this.toggle = function () {
        switch (isOpen) {
            case true: self.show(); break;
            case false: self.hide(); break;
        }
    };

    /**
     *
     */
    this.change = function(fn) {
        cbOnChange = fn;
        $select.change(cbOnChange);
    };

    //
    this.reload();

    //
    $(document).mouseup(function (e) {
        var target = $(e.target || e.srcElement);
        if (target.closest('.js-form-act-wsumo').length || target.closest('.js-form-pp-wsumo').length) {
            return;
        }

        self.hide();
    });
};