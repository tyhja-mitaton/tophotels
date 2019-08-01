"use strict";

/**
 * @param {boolean} useDebounce использовать обертку на текстовый саджест,
 * сглаживает поиск на большом числе данных
 * @constructor
 */
var TableListTable = function(useDebounce) {
    //
    var self = this;
    var useDebounceSuggest = useDebounce;

    // вывод
    var itemTable = $('#tableListTable');
    var personCount = $('#tableCount');

    // шаблоны
    var itemTemplate = $('#tableListTableRow').clone();

    // текущая позиция каретки / пагер
    var tableListPage = 0;
    var tableListPos = 0;
    var tableListPosEnd = 0;
    var pager = new LSPager($('#jsTablePager'));

    // ограничение вывода
    var tableListLimit = 500;

    // количество персон
    var tableListSize = 0;

    // кеш персон
    var tableListCache = [];

    // результаты фильтрации
    var isFilterChanged = true;
    var inpPersonFilter = $('#tableNameFilter');
    var tableListCacheFilterSz = 0;
    var tableListCacheFiltered = [];

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
        document.app.TableList.getAll(__project, function(data) {
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

                if (item.description === null) {
                    item.description = '';
                }

                tableListCache.push(item);
            }
            tableListSize = tableListCache.length;

            // Сортировка
            tableListCache.sort(function (a, b) {
                if (a.size_bytes > b.size_bytes) return -1;
                if (a.size_bytes < b.size_bytes) return +1;
                return 0;
            });

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

        tableListCacheFilterSz = 0;
        tableListCacheFiltered = null;
        tableListCacheFiltered = [];

        // оптимизация для сброса фильтра
        if (self.filterReq.name === null && self.filterReq.char === null && self.filterReq.tpas === null) {
            tableListCacheFilterSz = tableListCache.length;
            tableListCacheFiltered = tableListCache;
            isFilterChanged = false;
            return;
        }

        //
        var suggestText = (self.filterReq.name === null) ? '' : self.filterReq.name.trim().toLocaleLowerCase();
        var suggestTextRuEn = reverseLocale.convertRuToEn((self.filterReq.name === null) ? '' : self.filterReq.name.trim().toLocaleLowerCase());
        var suggestTextEnRu = reverseLocale.convertEnToRu((self.filterReq.name === null) ? '' : self.filterReq.name.trim().toLocaleLowerCase());
        var suggestNum = (self.filterReq.name === null) ? '' : self.filterReq.name.replace(regxNum, '');

        var itm;
        var cLen = tableListCache.length;
        for (var key = 0; key !== cLen; key++) {
            //
            itm = tableListCache[key];

            // фильтрация по саджесту
            switch (true) {
                case (itm.table_name.indexOf(suggestText) !== -1):
                case (itm.table_name.indexOf(suggestTextRuEn) !== -1):
                case (itm.table_name.indexOf(suggestTextEnRu) !== -1):
                case (itm.description.indexOf(suggestText) !== -1):
                case (itm.description.indexOf(suggestTextRuEn) !== -1):
                case (itm.description.indexOf(suggestTextEnRu) !== -1):
                    tableListCacheFiltered.push(itm);
                break;
            }
        }

        tableListCacheFilterSz = tableListCacheFiltered.length;
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
        tpl.find('.data-table-name').html(item.table_name);
        tpl.find('.data-table-scheme').html(item.table_schema);
        tpl.find('.data-table-size').html(item.size);
        tpl.find('.data-table-db').html(__project);
        tpl.find('.data-table-comment').html(item.description);

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
        if (tableListPage === page && !isFilterChanged) {
            return;
        }

        tableListPage = page;
        tableListPos = (page - 1) * tableListLimit;
        tableListPosEnd = tableListPos + tableListLimit;

        self.filter();
        if (tableListPosEnd > tableListCacheFilterSz) {
            tableListPosEnd = tableListCacheFilterSz;
        }

        // если догрузка не удаляем старые
        if (isDoload !== true) {
            itemTable.find('.removable').remove();
        }

        // рендер
        for (var n = tableListPos; n < tableListPosEnd; n++) {
            self.renderItem((n + 1), tableListCacheFiltered[n]);
        }

        //
        personCount.text(tableListCacheFilterSz);
        pager.reloadPager(page, tableListLimit, tableListCacheFilterSz);
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
        self.renderPage(tableListPage + 1, true);
    });

    // клик на пагинатор
    pager.bindPageClick(function (e) {
        e.preventDefault();
        self.renderPage(parseInt($(this).attr('data-page')), false);
    });
};
