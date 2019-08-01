/**
 * Контейнер для вспомогательных функций
 *
 * @author Игорь Лазарев <lazarev@lightsoft.ru>
 */

var Helper = {};

/**
 * Находит блоки по селекторам. Если селектор взят в квадратные кавычки,
 * то блок для него не ищет.
 * @param {Object} selector
 * @returns {Object}
 */
Helper.findBlocks = function (selector) {
    var block = {};
    for (var key in selector) {
        if (Array.isArray(selector[key])) {
            selector[key] = selector[key][0];
            continue;
        }
        block[key] = $(selector[key]);
    }
    return block;
};

/**
 * Корректирует ширину для попапа (календарь, гости и т.п.)
 * @param {Number} width
 * @returns {Number}
 */
Helper.getPopupAutoWidth = function (width) {
    var ww = $(window).width();
    // адаптивное доп. пространство справа окна
    width += ww >= 800 ? 52 : ww >= 700 ? 32 : 18;
    return width < 212 ? 212 : width;
};

/**
 * Проверка по регулярному выражению
 *
 * @param {String} str Значение для проверки
 * @param {String} pattern Регулярное выражение
 * @returns {Boolean}
 */
Helper.checkRegex = function (str, pattern) {
    if (str == '') {
        return false;
    } else if (pattern == '') {
        return true;
    } else {
        var testing = new RegExp(pattern, "i");
        return testing.test(str);
    }
};

/**
 * Преобразует строки в даты-объекты типа moment
 * @param {Array} arr Массив, в котором нужно преобразовать даты
 * @param {Array} fields Массив с перечислением полей, которые нужно преобразовать
 * @returns {Boolean}
 */
Helper.strings2moments = function (arr, fields) {
    var count = arr.length;
    var fCount = fields.length;
    if (count < 0 || fCount < 0) {
        return false;
    }
    for (var i = 0; i < count; i++) {
        for (var j = 0; j < fCount; j++) {
            if (typeof arr[i][fields[j]] !== 'undefined') {
                arr[i][fields[j]] = moment(arr[i][fields[j]]);
            }
        }
    }
    return true;
};

/**
 * Формирует URL перехода на отель или курорт с параметрами заезда.
 * В объекте item должны быть свойства allocation[_id], country[_id], resort[_id],
 * place[_id], check_in (в виде объекта moment), duration, adults, children,
 * child_age1, child_age2
 *
 * @param {Object} item
 * @returns {String}
 */
Helper.getSearchHref = function (item) {
    var href = app.params['hostOld'];
    // урл к отелю
    if (typeof item.allocation != 'undefined' && item.allocation > 0) {
        href += 'hotel/' + item.allocation;
    } else if (typeof item['allocation_id'] != 'undefined' && item['allocation_id'] > 0) {
        href += 'hotel/' + item['allocation_id'];
        // урл к стране или курорту
    } else if ((typeof item.resort != 'undefined' || typeof item['resort_id'] != 'undefined')
        && (typeof item.country != 'undefined' || typeof item['country_id'] != 'undefined')) {
        if (typeof item.country != 'undefined' && item.country > 0) {
            href += 'hotels/search_hotels/' + item.country;
        } else if (typeof item['country_id'] != 'undefined' && item['country_id'] > 0) {
            href += 'hotels/search_hotels/' + item['country_id'];
        } else {
            return '';
        }
        if (typeof item.resort != 'undefined' && item.resort > 0) {
            href += '/' + item.resort;
        } else if (typeof item['resort_id'] != 'undefined' && item['resort_id'] > 0) {
            href += '/' + item['resort_id'];
        }
        if (typeof item.place != 'undefined' && item.place > 0) {
            href += '/' + item.place;
        } else if (typeof item['place_id'] != 'undefined' && item['place_id'] > 0) {
            href += '/' + item['place_id'];
        }
    } else {
        return '';
    }
    // Параметры заезда
    href += '/?';
    if (typeof item['check_in'] != 'undefined') {
        href += 'in=' + item['check_in'].format('YYYY-MM-DD');
    }
    if (typeof item.duration != 'undefined') {
        href += '&du=' + item.duration;
    }
    if (typeof item.adults != 'undefined') {
        href += '&ad=' + item.adults;
    }
    if (typeof item.children != 'undefined' && item.children > 0) {
        href += '&ch=' + item.children;
    }
    if (typeof item.child_age1 != 'undefined' && item.child_age1 > 0) {
        href += '&age1=' + item.child_age1;
    }
    if (typeof item.child_age2 != 'undefined' && item.child_age2 > 0) {
        href += '&age2=' + item.child_age2;
    }
    return href;
};

/**
 * Метод заменяет параметры поиска в ссылках с классом js-search-link
 * @param searchParamsString
 */
Helper.replaceSearchParamsInLink = function (searchParamsString) {
    $('.js-search-link').each(function (index, el) {
        var href = $(el).attr('href');
        var newHref = '';
        if (typeof href !== 'undefined') {
            var peaces = href.split('?');
            newHref = peaces[0] + '?' + searchParamsString;
            if (typeof peaces[1] !== 'undefined') {
                var hash = peaces[1].split('#');
                if (typeof hash[1] !== 'undefined') {
                    newHref += '#' + hash[1];
                }
            }
        }
        $(el).attr('href', newHref);
    });
};

/**
 * Подбор множественной формы слова.
 * Приведено к методу Helper::t() на стороне сервера.
 *
 * @param {int} number число
 * @param {string} templates формы, например ['# ночь|# ночи|# ночей']
 * @returns {string} заголовок с правильной формой
 */
Helper.t = function (number, templates) {
    var cases = [2, 0, 1, 1, 1, 2], forms, form;
    forms = templates.split('|');
    form = forms[(number % 100 > 4 && number % 100 < 20) ? 2 : cases[(number % 10 < 5) ? number % 10 : 5]];
    return form.replace('#', number.toString());
};

/**
 * Парсер URL
 *
 * @param url
 * @returns {{source: *, protocol: string, host: string, port: (port|*|Function|string), query: *, params, file: (string|*), hash: string, path: string, relative: *, segments: Array}}
 */
Helper.parseUrl = function (url) {
    var a = document.createElement('a');
    a.href = url;
    var parts = a.pathname.split('/');
    parts.shift();
    return {
        source: url,
        protocol: a.protocol.replace(':', ''),
        host: a.hostname,
        port: a.port,
        query: a.search,
        params: (function () {
            var ret = {},
                seg = a.search.replace(/^\?/, '').split('&'),
                len = seg.length, i = 0, s;
            for (; i < len; i++) {
                if (!seg[i]) {
                    continue;
                }
                s = seg[i].split('=');
                ret[s[0]] = s[1];
            }
            return ret;
        })(),
        file: (a.pathname.match(/\/([^\/?#]+)$/i) || [, ''])[1],
        hash: a.hash.replace('#', ''),
        path: a.pathname.replace(/^([^\/])/, '/$1'),
        relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [, ''])[1],
        segments: a.pathname.replace(/^\//, '').split('/')
    };
};

/**
 * обновляет/заменяет значение uri параметра
 * @param uri
 * @param key
 * @param value
 * @returns {*}
 */
Helper.updateQueryStringParameter = function (uri, key, value) {
    // remove the hash part before operating on the uri
    var i = uri.indexOf('#');
    var hash = i === -1 ? '' : uri.substr(i);
    uri = i === -1 ? uri : uri.substr(0, i);

    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";

    if (!value) {
        // remove key-value pair if value is empty
        uri = uri.replace(new RegExp("([?&]?)" + key + "=[^&]*", "i"), '');
        if (uri.slice(-1) === '?') {
            uri = uri.slice(0, -1);
        }
        // replace first occurrence of & by ? if no ? is present
        if (uri.indexOf('?') === -1) uri = uri.replace(/&/, '?');
    } else if (uri.match(re)) {
        uri = uri.replace(re, '$1' + key + "=" + value + '$2');
    } else {
        uri = uri + separator + key + "=" + value;
    }
    return uri + hash;
};

/**
 * Выдает стойкость пароля
 * Ненадежный от 0 до 50
 * Надежный от 50 до 100
 *
 * @param {string} password
 * @return {int} (от 0 до 100)
 */
Helper.passwordStrength = function (password) {
    var strength = 0;
    var passwordLength = password.length;
    var numbers, symbols, lowercaseCharacters, uppercaseCharacters, matchs;

    if (passwordLength < 4) {
        return strength;
    } else {
        strength = passwordLength * 4;
    }

    for (var i = 2; i <= 4; i++) {
        var temp = Php.str_split(password, i);
        strength -= (Math.ceil(passwordLength / i) - (Php.array_unique(temp)).length);
    }

    matchs = password.match(/\d/g);

    if (matchs !== null) {
        numbers = matchs.length;
        if (numbers >= 3) {
            strength += 5;
        }
    } else {
        numbers = 0;
    }

    matchs = password.match(/[\[|!@#$%&*\/=?,;.:\-_+~^Ё\\\]]/g);

    if (matchs !== null) {
        symbols = matchs.length;
        if (symbols >= 2) {
            strength += 5;
        }
    } else {
        symbols = 0;
    }

    matchs = password.match(/[a-z]/g);

    if (matchs !== null) {
        lowercaseCharacters = matchs.length;
    } else {
        lowercaseCharacters = 0;
    }

    matchs = password.match(/[A-Z]/g);

    if (matchs !== null) {
        uppercaseCharacters = matchs.length;
    } else {
        uppercaseCharacters = 0;
    }

    if ((lowercaseCharacters > 0) && (uppercaseCharacters > 0)) {
        strength += 10;
    }

    var characters = lowercaseCharacters + uppercaseCharacters;

    if ((numbers > 0) && (symbols > 0)) {
        strength += 15;
    }

    if ((numbers > 0) && (characters > 0)) {
        strength += 15;
    }

    if ((symbols > 0) && (characters > 0)) {
        strength += 15;
    }

    if ((numbers === 0) && (symbols === 0)) {
        strength -= 10;
    }

    if ((symbols === 0) && (characters === 0)) {
        strength -= 10;
    }

    if (strength < 0) {
        strength = 0;
    }

    if (strength > 100) {
        strength = 100;
    }

    return strength;
};

/**
 * Удаляет спец символы []\|/?{},.<>;:'"
 * @param {String} text
 * @returns {String}
 */
Helper.deleteSpecialChar = function (text) {
    return text
        .replace(/\[/g, "")
        .replace(/\]/g, "")
        .replace(/\\/g, "")
        .replace(/\|/g, "")
        .replace(/\//g, "\\/")
        .replace(/\?/g, "")
        .replace(/\{/g, "")
        .replace(/\}/g, "")
        .replace(/\,/g, "\\,")
        .replace(/\./g, "\\.")
        .replace(/\</g, "")
        .replace(/\>/g, "")
        .replace(/\;/g, "")
        .replace(/\:/g, "")
        .replace(/\'/g, "")
        .replace(/\"/g, '')
        .replace(/&amp/g, '&amp;')
        .replace(/\(|\\\(/g, '\\(')
        .replace(/\)|\\\)/g, '\\)');
};

/*
 * Форматироване числа в строку заданного формата
 * @param number
 * @param decimals
 * @param dec_point
 * @param thousands_sep
 * @returns {string}
 */
Helper.numberFormat = function (number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ' ' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
        s,
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
            .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
};

/**
 * Выводит текстовое представление кол-ва детей (принимает только 0, 1 или 2)
 * @param {Number} count
 * @returns {String}
 */
Helper.formatChildren = function (count) {
    count = parseInt(count) || 0;
    switch (count) {
        case 1:
            return '1 ребенок';
        case 2:
            return '2 детей';
    }
    return 'без детей';
};

/**
 * Генерирует уникальный ключ (не менее 4 символов)
 * @param {Number} length Длина ключа
 * @returns {String}
 */
Helper.makeId = function (length) {
    length = parseInt(length) || 0;
    if (length < 4) {
        length = 4;
    }
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < length; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }

    return text;
};

/**
 * Возвращает 32-х битный хеш-код строки.
 * @param {string} string
 * @returns {number}
 */
Helper.getHashCode = function (string) {
    var hash = 0, i, chr, len;
    if (typeof string !== "undefined" && string.length > 0) {
        for (i = 0, len = string.length; i < len; i++) {
            chr = string.charCodeAt(i);
            hash = ((hash << 5) - hash) + chr;
            hash |= 0; // Convert to 32bit integer
        }
    }
    return hash;
};

/**
 * Translate first letter to uppercase
 * @param str
 * @returns {string}
 */
Helper.ucfirst = function (str) {
    return str.substr(0, 1).toUpperCase() + str.substr(1);
};

/**
 * Раскодирует двойную кавычку в строке
 * @param {String} s
 * @returns {String}
 */
Helper.unquotString = function (s) {
    return s.replace(/&quоt;/g, '"');
};

/**
 * Проверяет строку на принадлежность к латинскому алфавиту
 * @param {String} s
 * @returns {Boolean}
 */
Helper.isLatin = function (s) {
    return /[a-z]/i.test(s);
};

/**
 * Возвразает размер объекта/ассоциативного массива
 * @param {Object} obj
 * @returns {Number}
 */
Helper.objectSize = function (obj) {
    var count = 0;
    for (var item in obj) {
        if (obj.hasOwnProperty(item)) {
            count++;
        }
    }
    return count;
};

Helper.htmlEncode = function (value) {
    //create a in-memory div, set it's inner text(which jQuery automatically encodes)
    //then grab the encoded contents back out.  The div never exists on the page.
    return $('<div/>').text(value).html();
};

Helper.htmlDecode = function (value) {
    return $('<div/>').html(value).text();
};

/**
 * Нативное добавление прослушивания событий
 */
Helper.addEvent = function (obj, evt, fn) {
    if (obj.addEventListener) {
        obj.addEventListener(evt, fn, false);
    }
    else if (obj.attachEvent) {
        obj.attachEvent("on" + evt, fn);
    }
};

/**
 * Превращаем строку с ценой в number
 * @param {string}  string  Строка цены ('От 5 072 Р в сутки').
 * @returns {number}    Цена (5072)
 */
Helper.numberFormatToNumber = function (string) {
    return parseFloat((string + '').replace(/[\saA-zZаА-яЯ]+/ig, ''));
};

/**
 * Возвращает имя класса для рейтинга
 * @param {Number} rating
 * @returns {String}
 */
Helper.getRatingClass = function (rating) {
    rating = parseFloat(Number(rating).toPrecision(2)) || 0.0;
    var ratingClass = '';
    if (rating >= 4.0) {
        ratingClass = 'high';
    } else if (rating >= 3.0) {
        ratingClass = 'mid';
    } else if (rating > 0) {
        ratingClass = 'low';
    }
    return ratingClass;
};

/**
 * Конвертирует массив '$key=>$value' в строку data атрибутов для html тегов.
 * Пример: data-key1="value1" data-key2="value2"
 * @param {Object} array  Массив '$key=>$value'
 * @param {String} prefix Префикс дата атрибута
 * @param {String} quotes Указывает какие ковычки будут использованы для значения параметра. По умолчанию '"'.
 * @returns {String|Boolean}
 */
Helper.getArrayToDataAttributes = function (array, prefix, quotes) {
    if (typeof array != 'object') {
        return false;
    }

    var htmlAttributes = '';
    $.each(array, function (key, value) {
        var prefKey = prefix + (key + ''.toLowerCase());
        htmlAttributes += 'data-' + prefKey + '=' + quotes + value + quotes + ' ';
    });
    return htmlAttributes;
};

/**
 * Собирает ассоциативный массив блоков по ключу дата-атрибута
 * @param {jQuery} $block
 * @param {String} dataKey
 * @returns {Object}
 */
Helper.collectByKey = function ($block, dataKey) {
    var obj = {};
    $block.each(function () {
        var $this = $(this);
        var key = $.trim($this.data(dataKey));
        if (key) {
            obj[key] = $this;
        }
    });
    return obj;
};

/**
 * Возвращает случайный элемент массива.
 * @param {Array} items
 * @returns {*}
 */
Helper.rand = function (items) {
    return items[Math.floor(Math.random() * items.length)];
};

/**
 * Кодирует объект в параметры URL
 * @param {Object} obj
 * @param {String} prefix
 * @returns {String}
 */
Helper.serialize = function (obj, prefix) {
    var str = [];
    for (var p in obj) {
        if (obj.hasOwnProperty(p)) {
            var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
            str.push(typeof v == "object" ?
                Helper.serialize(v, k) :
            encodeURIComponent(k) + "=" + encodeURIComponent(v));
        }
    }
    return str.join("&");
};

/**
 * Оставляет уникальные значения в массиве
 * @param {Array} array
 * @returns {Array}
 */
Helper.unique = function (array) {
    var a = array.concat();
    for (var i = 0; i < a.length; ++i) {
        for (var j = i + 1; j < a.length; ++j) {
            if (a[i] === a[j])
                a.splice(j--, 1);
        }
    }
    return a;
};

/**
 * Безопасное преобразование даты в нативную дату, без учета
 * временной зоны
 *
 * Функцию рекомендуется использовать из-за багов в некоторых браузерах
 * при работе с чистой датой (без времени и временной зоны).
 *
 * @param {*} dt
 * @param {String} fmt
 * @returns {Date}
 */
Helper.getSafeDate = function (dt, fmt) {
    if (typeof dt === 'undefined') {
        dt = [];
    }
    if (typeof fmt === 'undefined') {
        fmt = 'YYYY-MM-DD';
    }
    return moment.utc(moment(dt).format(fmt)).toDate();
};

/**
 * Возвращает последнее число указанного месяца.
 * @param {string|number} date дата '2017-04-28' или UNIX-формат
 * @returns {number} последнее число месяца
 */
Helper.getLastDayOfMonth = function (date) {
    var source = new Date(date), // для получения года/месяца
        // нулевой день это последний день предыдущего месяца
        tmp = new Date(source.getFullYear(), source.getMonth() - 1, 0);
    return tmp.getDate();
};

/**
 * Форматирует дату в строку вида 'YYYY-MM-DD' (php формат).
 * @param {Date} date
 * @returns {string}
 */
Helper.formatDateToYmd = function (date) {
    return '{0}-{1}-{2}'.format(date.getFullYear(), (date.getMonth() + 1).toString().padLeft('0', 2), date.getDate().toString().padLeft('0', 2));
};

/**
 * Прокручивает страницу к указанному якорю.
 * Учитывает дополнительный отступ, использует jQuery animate().
 *
 * @param {jQuery|string} anchor название якоря вида "#myAnchor".
 * @param {number} [additionalOffset] дополнительный отступ default 0.
 */
Helper.scrollToAnchor = function (anchor, additionalOffset) {
    var offsetTop, $elem;
    additionalOffset = additionalOffset ? additionalOffset : 0;
    offsetTop = anchor === "#" ? additionalOffset : -1;
    if (anchor && anchor !== "#") {
        if (typeof anchor == "string") { // указана строка?
            $elem = $(anchor);
        } else { // объект уже передан
            $elem = anchor;
        }
        if ($elem.length) { // якорь найден?
            offsetTop = $elem.offset().top + additionalOffset;
        }
    }
    if (offsetTop > -1) { // есть куда прокручивать?
        $('html, body').stop().animate(
            {scrollTop: offsetTop},
            1000
        );
    }
};

/**
 * Добавляет параметр безопасности CSRF к GET/POST-данным.
 * Используется при отправке данных для Yii2.
 * @param {Object} data
 * @returns {Object}
 */
Helper.appendCsrf = function (data) {
    var csrfParam = $("meta[name='csrf-param']").attr('content');
    data[csrfParam] = $("meta[name='csrf-token']").attr('content');
    return data;
};

/**
 * Возвращает URL с указанными параметрами для GET-запроса.
 * @param {string} url адрес
 * @param {Array|Object} params массив или объект с параметрами
 * @return {string}
 */
Helper.buildUrl = function (url, params) {
    return url + '?' + $.param(params);
};

Helper.bookingRoom1 = function (adults, children) {
    var items = [];
    for (var i = 0; i < adults; i++){
        items.push('A');
    }
    for (i = 0; i < children; i++){
        items.push('7');
    }
    return items.join(',');
};

/************************************************
 * Добавляем функциональность в JS
 ***********************************************/
if (!String.prototype.format) {
    /**
     * Форматирует строку, добавляя параметры.
     * Метод добавляется в прототип и работает с ЛЮБОЙ строкой.
     * Источник http://stackoverflow.com/questions/610406/javascript-equivalent-to-printf-string-format
     * Параметров может быть сколько угодно. Пример:
     * var str = "{0} {1}".format("Hello", "world!");
     * // "Hello world!"
     *
     * @returns {*}
     */
    String.prototype.format = function() {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function(match, number) {
            return typeof args[number] != 'undefined'
                ? args[number]
                : match;
        });
    };
}

if (!String.prototype.padLeft) {
    /**
     * Дополняет строку до указанной длины символами слева.
     * @param {string} char символ для дополнения
     * @param {number} length требуемая длина строки
     * @returns {string} дополненная строка
     */
    String.prototype.padLeft = function(char, length) {
        var pad = new Array(Math.max(0, (length + 1) - this.length)).join(char);
        return pad + this;
    };
}

if (!Date.prototype.toYmd) {
    /**
     * Возвращает строковое представление даты.
     * @returns {string} строка вида '2017-04-30'
     */
    Date.prototype.toYmd = function () {
        return '{0}-{1}-{2}'.format(
            this.getFullYear(),
            (this.getMonth() + 1).toString().padLeft('0', 2),
            (this.getDate()).toString().padLeft('0', 2)
        );
    };
}
if (!Date.prototype.formatRus) {
    /**
     * Возвращает строковое представление даты.
     * @returns {string} строка вида '2017.04.30'
     */
    Date.prototype.formatRus = function() {
        var day = (this.getDate() < 10 ? '0' : '') + this.getDate();
        var month = (this.getMonth() < 9 ? '0' : '') + (this.getMonth() + 1);
        var year = this.getFullYear();
        return day + '.' + month + '.' + year;
    };
}

if (!Array.prototype.remove) {
    Array.prototype.remove = function() {
        var what, a = arguments, L = a.length, ax;
        while (L && this.length) {
            what = a[--L];
            while ((ax = this.indexOf(what)) !== -1) {
                this.splice(ax, 1);
            }
        }
        return this;
    };
}