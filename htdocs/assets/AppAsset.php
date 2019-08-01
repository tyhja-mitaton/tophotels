<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
		'css/vendor/gemini-calendar.css',
		'css/vendor/magnific-popup.css',
		'css/vendor/sumoselect.css',
		'css/vendor/th-sumoselect.css',
		'css/vendor/font-awesome-5.0/css/fontawesome-all.css',
		'css/_lsfw/tabs.css',
		'css/_lsfw/atom.css',
		'css/_lsfw/flags.css',
		'css/_lsfw/fonts.css',
		'css/_lsfw/lswf-icons.css',
		'css/_lsfw/reset-ls.css',
		//'css/indexer/main.css',
		//'css/indexer/nav.css',
		//'css/indexer/layouts/header.css',
		'css/lib-ui-tour-filter/lsfw-tour-filter.css',
		'css/lib-ui-tour-filter/lsfw-price-widget.css',
		'css/lib-ui-tour-filter/lsfw-form-direction.css',
		'css/lib-ui-tour-filter/lsfw-durability-widget.css',
		'css/lib-ui-tour-filter/lsfw-date-widget.css',
		'css/lib-ui-tour-filter/lsfw-adults-widget.css',
		'css/lib-ui-tour-filter/fonts.css',
		'css/lib-ui-tour-filter/flags.css',
		'css/lib-ui-tour-filter/reset-ls.css',
		'css/tophotels_site_html/main-cnt.css',
		'css/tophotels_site_html/main.css',
		'css/tophotels_site_html/agree-pp.css',
		'css/tophotels_site_html/tabs-bar-mobile.css',
		'css/tophotels_site_html/layouts/footer.css',
		'css/tophotels_site_html/layouts/header.css',
		'css/tophotels_site_html/layouts/header-mobile.css',
		'css/tophotels_site_html/layouts/left-menu.css',
		'css/tophotels_site_html/layouts/left-menu-mobile.css',
		'js/vendor/SumoSelectLS/css/sumoselect.css',
		'css/vendor/dependent-dropdown.min.css'
    ];
    public $js = [
	'js/jquery.311.min.js',
	'js/jquery.min.js',
	'js/jquery-ui.min.js',
	'js/vendor/gemini-calendar.js',
	'js/vendor/jquery-datepicker-range.js',
	'js/vendor/magnific-popup.min.js',
	'js/vendor/SumoSelectLS/js/jquery.sumoselect.min.js',
	'js/vendor/SumoSelectLS/js/jquery.sumoselect-ls.min.js',
	'js/tophotels_site_html/tk-form-v2/date-function.js',
	'js/tophotels_site_html/tk-form-v2/form-date.js',
	'js/tophotels_site_html/tk-form-v2/main.js',
	'js/tophotels_site_html/main.js',
	'js/tophotels_site_html/agree-pp.js',
	'js/tophotels_site_html/form-directions.js',
	'js/tophotels_site_html/form-pp-universal.js',
	'js/tophotels_site_html/header-mobile.js',
	'js/tophotels_site_html/help-selections.js',
	'js/tophotels_site_html/left-menu-mobile.js',
	'js/tophotels_site_html/legal-info-pp.js',
	'js/libs/array-function.js',
	'js/libs/date-function.js',
	'js/libs/debounce.js',
	'js/libs/form-select-pp.js',
	'js/libs/gpu.min.js',
	'js/libs/helper.js',
	'js/libs/LSPager.js',
	'js/libs/LSSuggest.js',
	'js/libs/number-function.js',
	'js/libs/reverseLocale.js',
	'js/libs/string-function.js',
	'js/indexer/tables-list.js',
	'js/indexer/models/ColumnList.js',
	'js/indexer/models/TableList.js',
	'js/indexer/pages/ColumnListTable.js',
	'js/indexer/pages/TableListTable.js',
	'js/crutches.js',
	'js/nightsGridGenerator.js',
	'js/vendor/dependent-dropdown.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
