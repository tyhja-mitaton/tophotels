"use strict";

/**
 * @param {boolean} useDebounce использовать обертку на текстовый саджест,
 * сглаживает поиск на большом числе данных
 * @constructor
 */
var ColumnListTable = function(useDebounce) {
    //
    var self = this;
    var useDebounceSuggest = useDebounce;

    // вывод
    var itemTable = $('#columnListTable');
    var personCount = $('#columnCount');

    // шаблоны
    var itemTemplate = $('#columnListTableRow').clone();

    // текущая позиция каретки / пагер
    var columnListPage = 0;
    var columnListPos = 0;
    var columnListPosEnd = 0;
    var pager = new LSPager($('#jsColumnPager'));

    // ограничение вывода
    var columnListLimit = 500;

    // количество персон
    var columnListSize = 0;

    // кеш персон
    var columnListCache = [];

    // результаты фильтрации
    var isFilterChanged = true;
    var inpPersonFilter = $('#columnNameFilter');
    var columnListCacheFilterSz = 0;
    var columnListCacheFiltered = [];

    // regex
    var regxNum = /\D/g;

    // фильтр
    this.filterReq = {
        name: null,
    };

    /**
     * Загрузка списка персон по менеджеру и заполнение кеша
     */
    this.load = function(callbackAfterLoad) {
        document.app.ColumnList.getAll(__project, function(data) {
            var json = JSON.parse(data);

            var item;
            for (var key in json) {
                //
                if (!json.hasOwnProperty(key)) {
                    continue;
                }

                //
                item = json[key];
                item.renderCache = null;
                item.columnTables = (item.table === null ? '' : item.table).replace(/[{}]/gi, '').split(',').length;

                if (item.description === null) {
                    item.description = '';
                }

                columnListCache.push(item);
            }
            columnListSize = columnListCache.length;

            callbackAfterLoad();
        });
    };

    /**
     * Фильтрация
     */
    this.filter = function () {
        if (!isFilterChanged) {
            return;
        }

        columnListCacheFilterSz = 0;
        columnListCacheFiltered = null;
        columnListCacheFiltered = [];

        // оптимизация для сброса фильтра
        if (self.filterReq.name === null && self.filterReq.char === null && self.filterReq.tpas === null) {
            columnListCacheFilterSz = columnListCache.length;
            columnListCacheFiltered = columnListCache;
            isFilterChanged = false;
            return;
        }

        //
        var suggestText = (self.filterReq.name === null) ? '' : self.filterReq.name.trim().toLocaleLowerCase();
        var suggestTextRuEn = reverseLocale.convertRuToEn((self.filterReq.name === null) ? '' : self.filterReq.name.trim().toLocaleLowerCase());
        var suggestTextEnRu = reverseLocale.convertEnToRu((self.filterReq.name === null) ? '' : self.filterReq.name.trim().toLocaleLowerCase());

        var itm;
        var cLen = columnListCache.length;
        for (var key = 0; key !== cLen; key++) {
            //
            itm = columnListCache[key];

            // фильтрация по саджесту
            switch (true) {
                case (itm.column_name.indexOf(suggestText) !== -1):
                case (itm.column_name.indexOf(suggestTextRuEn) !== -1):
                case (itm.column_name.indexOf(suggestTextEnRu) !== -1):
                case (itm.table.indexOf(suggestText) !== -1):
                case (itm.table.indexOf(suggestTextRuEn) !== -1):
                case (itm.table.indexOf(suggestTextEnRu) !== -1):
                case (itm.description.indexOf(suggestText) !== -1):
                case (itm.description.indexOf(suggestTextRuEn) !== -1):
                case (itm.description.indexOf(suggestTextEnRu) !== -1):
                    columnListCacheFiltered.push(itm);
                break;
            }
        }

        columnListCacheFilterSz = columnListCacheFiltered.length;
        isFilterChanged = false;
    };

    /**
     * Рендер
     * @param id
     * @param item
     */
    this.renderItem = function (id, item) {

        // используем кеш рендера
        // для сокращения манипуляций с шаблоном
        if (item.renderCache !== null) {
            item.renderCache.find('.data-id').text(id);
            item.renderCache.appendTo(itemTable);
            return;
        }

        var tpl = itemTemplate.clone();
        tpl.addClass('removable');
        tpl.attr('id', '');
        tpl.find('.data-id').html(id);
        tpl.find('.data-table-name').html(item.column_name);
        tpl.find('.data-table-table').html(
            '<div class="fz14 bold mb20">Число таблиц - '+ item.columnTables +'</div>' +
            item.table.replace(/[{}\"]|[,{]*NULL[,}]*/ig, '').replace(/,/ig, '<br>')
        );
        tpl.find('.data-table-db').html(__project);
        tpl.find('.data-table-comment').html(item.description.replace(/[{}\"]|[,{]*NULL[,}]*/ig, '').replace(/,/ig, '<br>'));

        tpl.css('display', 'table-row');

        // кешируем копию шаблона
        item.renderCache = tpl.clone();

        // пушим в DOM
        tpl.appendTo(itemTable);
    };

    /**
     * Рендер страницы результатов
     * @param page
     * @param isDoload
     */
    this.renderPage = function (page, isDoload) {
        if (columnListPage === page && !isFilterChanged) {
            return;
        }

        columnListPage = page;
        columnListPos = (page - 1) * columnListLimit;
        columnListPosEnd = columnListPos + columnListLimit;

        self.filter();
        if (columnListPosEnd > columnListCacheFilterSz) {
            columnListPosEnd = columnListCacheFilterSz;
        }

        // если догрузка не удаляем старые
        if (isDoload !== true) {
            itemTable.find('.removable').remove();
        }

        // рендер
        for (var n = columnListPos; n < columnListPosEnd; n++) {
            self.renderItem((n + 1), columnListCacheFiltered[n]);
        }

        //
        personCount.text(columnListCacheFilterSz);
        pager.reloadPager(page, columnListLimit, columnListCacheFilterSz);
    };

    // фильтр: поиск в текстовом поле
    var suggestKeyUpFunction = function() {
        var newName = $(this).val().trim();

        //
        if (newName === self.filterReq.name) {
            return;
        }

        //
        isFilterChanged = true;
        self.filterReq.name = newName;
        if (self.filterReq.name.length < 1) {
            self.filterReq.name = null;
        }

        self.renderPage(1, false);
    };

    // Использование debounce обертки
    // (функция будет вызвана как только пректратит вызываться invDebounce, например, по окончанию ввода)
    // На объемах до 3000 лучше оставить обычный поиск
    // Дебоунс прорверен на 46,5К - значительно сглаживает поиск
    if (!useDebounceSuggest) {
        inpPersonFilter.keyup(suggestKeyUpFunction);
    }
    else {
        inpPersonFilter.keyup(invDebounce(suggestKeyUpFunction, 250, false));
    }

    // клик на догрузку
    pager.bindDoloadClick(function (e) {
        e.preventDefault();
        self.renderPage(columnListPage + 1, true);
    });

    // клик на пагинатор
    pager.bindPageClick(function (e) {
        e.preventDefault();
        self.renderPage(parseInt($(this).attr('data-page')), false);
    });
};
