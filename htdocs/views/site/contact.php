<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\OrderForm */
/* @var $model2 app\models\OrderFormPlus */
/* @var $countries_model app\models\Countries */
/* @var $resorts_model app\models\Resorts */
/* @var $hotels_model app\models\Hotels */
/* @var $complex_form yii\bootstrap\ActiveForm */
/* @var $cmplxf_model app\models\OrderComplexForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\depdrop\DepDrop;
use app\models\SendMailWithDelay;
use app\models\WriteJob;

$this->title = 'Заявка';
?>
<div class="tour-selection-box">
    
	<div class="tabs-block">
	<div class="tabs-bar   tabs-bar--responsive js-768-tabs">
	<div id="step1" class="tab">Подобрать тур</div>
	<div id="form" class="tab active">Нестандартный запрос</div>
	<!--<div id="step2" class="tab">Параметры тура</div>
	<div id="step3" class="tab">Шаг 2</div>
	<div id="formStep2" class="tab">Рега</div>-->
	<div class="line"></div>
	</div>
	<div id="step1Panel" class="panel">
	<?php if (Yii::$app->session->hasFlash('orderForm2Submitted')): ?>
	<div class="tour-selection-wrap">
		<div class="bth__cnt fz18 bold">
            Спасибо, Ваша заявка отправлена и будет обработана в ближайшее время.
        </div>
	</div>
	<?php //Yii::$app->queue->delay(2 * 60)->push(new SendMailWithDelay()); ?>
	<?php elseif (Yii::$app->session->hasFlash('orderFormStep2')): ?>
	<div class="tour-selection-wrap">
	<?php $form2 = ActiveForm::begin(['id' => 'contact-form2', 'layout'=>'horizontal', 'action'=>'index.php?r=site%2forder-step2', 'enableAjaxValidation' => true,
	'fieldConfig' => ['horizontalCssClasses' => ['label' => 'bth__inp-lbl', 'offset' => 'bth__inp-block', 
	'wrapper' => 'js-add-error', 'hint' => 'bth__cnt'], 'options' => ['class' => 'bth__inp-block long']]]); ?>
	<div class="tour-selection-wrap-in mt0 tour-selection-wrap-flex">
		<div class="tour-selection-field tour-selection-field--270">
		<?= $form2->field($model2, 'name', 
					['template' => '{input}{label}<div class="hint-block hint-block--abs"><i class="fa fa-question-circle question-error" aria-hidden="true"></i><div class="hint">{hint}</div></div>', 
					'options' => ['class' => 'bth__inp-block'], 'labelOptions' => 
					[ 'class' => 'bth__inp-lbl', 'style' => 'font-weight:normal;' ]])->textInput(
					['autofocus' => true, 'placeholder' => "", 'class' => 'bth__inp js-label'])
					->label('Ваше имя')->hint('Введите ваше имя') ?>
		</div>
		<div class="tour-selection-field tour-selection-field--270">
		<?= $form2->field($model2, 'phone',
		['template' => '{input}{label}<div class="hint-block hint-block--abs"><i class="fa fa-question-circle question-error" aria-hidden="true"></i><div class="hint">{hint}</div></div>', 
					 'options' => ['class' => 'bth__inp-block'], 'labelOptions' => 
					 [ 'class' => 'bth__inp-lbl', 'style' => 'font-weight:normal;' ]])->input('phone', 
					 ['placeholder' => "", 'class' => 'bth__inp js-label'])->label('Телефон')->hint('Введите корректный номер телефона') ?>
		</div>
		<div class="tour-selection-field tour-selection-field--270">
		<?= $form2->field($model2, 'email',['template' => '{input}{label}{hint}', 
					'horizontalCssClasses' => ['wrapper' => ''], 'options' => ['class' => 'bth__inp-block'], 
					'labelOptions' => [ 'class' => 'bth__inp-lbl', 'style' => 'font-weight:normal;' ]])
					->input('email', ['placeholder' => "", 'class' => 'bth__inp js-label'])->label('Email (не обязательно)'); ?>
		</div>
		
	</div>
	<div class="bth__cnt uppercase mt20 ">Уточните удобные координаты для выбора турагенства</div>
	<div class="tour-selection-wrap-in   tour-selection-wrap-flex ">
	<div class="tour-selection-field tour-selection-field--270 ">
		<div class="bth__inp-block js-show-formDirections required">
		<?= $form2->field($model2, 'body', ['template' => '{input}', 
		'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'f_tourist_city_id', 'name'=>'f_tourist_city', 'value'=>'']) ?>
			<span class="bth__inp-lbl">Ваш город</span><span class="bth__inp  uppercase "></span>
			<div class="hint-block hint-block--abs">
				<i class="fa fa-question-circle question-error" aria-hidden="true"></i>
				<div class="hint"><p class="bth__cnt">Введите ваш город</p></div>
			</div>
		</div>
				<div class="formDirections w100p">
				<div class="formDirections__wrap w100p">
					<div class="formDirections__top  formDirections__top-line">
						<i class="formDirections__bottom-close"></i>
						<div class="formDirections__top-tab super-grey ">Город</div>
					</div>
				<div class="SumoSelect formDirections__SumoSelect formDirections__SumoSelect-search">
				<?php $departCities_t = [0=>'Алматы', 1=>'Астана', 2=>'Белгород', 3=>'Брянск', 4=>'Владикавказ',
				5=>'Волгоград', 6=>'Воронеж', 7=>'Гомель', 8=>'Гродно', 9=>'Екатеринбург', 10=>'Иркутск',
				11=>'Калининград', 12=>'Киев', 13=>'Краснодар', 14=>'Красноярск', 15=>'Магадан', 16=>'Махачкала',
				17=>'Минеральные воды', -2=>'Москва', 19=>'Мурманск', 20=>'Набережные Челны', 21=>'Нижний Новгород', 22=>'Новосибирск',
				23=>'Омск', 24=>'Оренбург', 25=>'Пенза', 26=>'Ростов-на-Дону', 27=>'Саратов',
				-1=>'Санкт-Петербург', 29=>'Симферополь', 30=>'Смоленск', 31=>'Сочи', 32=>'Томск', 33=>'Ульяновск',
				34=>'Харьков', 35=>'Челябинск', 36=>'Шымкент', 37=>'Якутск', 38=>'Ярославль',];
				ksort($departCities_t);?>
				<?= \yii\bootstrap\Html::dropDownList('tourist_pcities', '', $departCities_t, ['tabindex'=>'-1', 'class'=>'SumoUnder', 'id'=>'sumo-list-city'])?>
				</div>
				</div>
				</div>
		</div>
	</div>
	<div class="tour-selection-wrap-in ">
		<?= Html::submitButton('Отправить заявку*<div class=" bth__loader-spin">
                            <i class="fas fa-circle"></i>
                            <i class="fas fa-circle"></i>
                            <i class="fas fa-circle"></i>
                        </div>', ['class' => 'bth__btn bth__btn--fill bth__loader', 'name' => 'contact-button']) ?>
				<div class="tour-selection-wrap__abs-txt  bth__cnt bth__cnt--sm">
                        *Нажимая на кнопку "отправить", я принимаю
                        <a href="#p-agreement-pp" class="p-agreement-pp agree">
                            Соглашение об обработке личных данных</a> и
                        <a href="#p-agreement-pp" class="p-agreement-pp site-role">Правила сайта</a>
				</div>
	</div>
	<?php ActiveForm::end(); ?>	
	</div>
	<?php else: ?>
	<div class="bth__cnt uppercase">Пожалуйста, укажите параметры вашей поездки</div>
	<div class="tour-selection-wrap">
	<?php $complex_form = ActiveForm::begin(['id'=>'cmplxf', 'action'=>'index.php?r=site%2fupload-step1',
	'enableAjaxValidation' => true, 'validationUrl' => 'index.php?r=site%2fstep1-validate']);?>
	<div class="tour-selection-wrap-in tour-selection-wrap-flex">
	<div class="tour-selection-field tour-selection-field--250">
	<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_takeoff_id', 'name'=>'cf_takeoff_date']) ?>
	<?= $complex_form->field($countries_model,'date_create', ['template' => '{label}<span class="bth__inp"><span class="fz13 normal"></span></span>', 'labelOptions' => [ 'class' => 'bth__inp-lbl active', 'style' => 'font-weight:normal;' ], 'options' => ['class' => 'js-lsfw-ppdb bth__inp-block']])->widget(DatePicker::className(), ['clientOptions' => ['defaultDate' => '']])->label('') ?>
	<div id="mtIdxFormDatePPHelp1" class="formDirections formDirections--date">
	<div class="formDirections__wrap">
	<div class="formDirections__top formDirections__top--white">
	<i class="js-lsfw-ppdb-close formDirections__bottom-close"></i>
	<div class="formDirections__top-tab super-grey ">Период дат вылета</div>
	</div>
	<div class="formDirections__bottom">
	<!--<div id="js-mt-filter-dtHelp1" style="z-index: 2008; transform-origin: 0px 0px 0px; top: 0px; left: 0px;">
	<div = class="form-popup__mdl"></div>
	<div = class="form-popup__dates"></div>
	</div>-->
	<div class="hidden " id="mtIdxDateHelp1" style="display: block;" placeholder="Please pick a day"></div>
	</div>
	</div>
	</div>
	</div>
	<div class="tour-selection-field tour-selection-field--180">
	<div class="bth__inp-block js-show-formDirections">
	<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_nights_id', 'name'=>'cf_nights', 'value'=>'7 - 14 нч']) ?>
	<span class="bth__inp-lbl active">Пребывание</span>
	<span id = "sleepovers" class="bth__inp  "></span>
	</div>
	<div class="formDirections formDirections--durability">
	<div class="formDirections__wrap">
	<div class="formDirections__top formDirections__top--white">
	<i class="formDirections__bottom-close"></i>
	<div class="formDirections__top-tab super-grey js-act-country uppercase">
	<span class="hide-1023">Количество ночей</span>
	<span class="show-1023">Ночей</span>
	</div>
	</div>
	<div class="formDirections__bottom js-search-country">
	<div class="formDirections__bottom-blocks">
	<div class="formDirections__bottom-item-durability">
	<div class="form-durability__select ">
	<div class="form-durability__durability">
	<!------Сетка "количество ночей" генерируется в nightsGridGenerator.js------>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class="tour-selection-field tour-selection-field--250">
	<div class="bth__inp-block js-show-formDirections">
	<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_room_id', 'name'=>'cf_room', 'value'=>'2 взрослых']) ?>
	<span class="bth__inp-lbl active">Человек в номере</span><span class="bth__inp " id="pplinroom">2 взрослых</span></div>
	<div class="formDirections formDirections--guest">
	<div class="formDirections__wrap">
	<div class="formDirections__top formDirections__top--white">
	<i class="formDirections__bottom-close"></i>
	<div class="formDirections__top-tab super-grey">Человек в номере</div>
	</div>
	<div class="formDirections__bottom-item no-border">
	<div>
	<div class="js-hide-adults formDirections__guest-wrap">
		<span class="formDirections__lb-uppercase bold">2 взрослых</span>
		<div class="formDirections__guest-btn">
			<i class="formDirections__guest-btn-icon selected"></i>
			<i class="formDirections__guest-btn-icon selected"></i>
			<i class="formDirections__guest-btn-icon"></i>
			<i class="formDirections__guest-btn-icon"></i>
		</div>
		<span class="js-add-more-adults formDirections__guest-plus"><i class="fas fa-plus"></i></span>
	</div>
	<div class="js-show-adults formDirections__guest-wrap" style="display: none;">
		<span class="formDirections__lb-uppercase bold">2 взрослых</span>
		<div class="formDirections__guest-btn">
			<i class="formDirections__guest-btn-icon selected"></i>
			<i class="formDirections__guest-btn-icon selected"></i>
			<i class="formDirections__guest-btn-icon"></i>
			<i class="formDirections__guest-btn-icon"></i>
			<i class="formDirections__guest-btn-icon"></i>
			<i class="formDirections__guest-btn-icon"></i>
			<i class="formDirections__guest-btn-icon"></i>
			<i class="formDirections__guest-btn-icon"></i>
			<i class="formDirections__guest-btn-icon"></i>
			<i class="formDirections__guest-btn-icon"></i>
			<i class="formDirections__guest-btn-icon"></i>
			<i class="formDirections__guest-btn-icon"></i>
		</div>
	</div>
	<div class="formDirections__guest-wrap">
		<span class="formDirections__lb-uppercase bold">добавить детей</span>
		<div class="formDirections__guest-btn">
			<i class="js-added-show1 formDirections__guest-btn-icon formDirections__guest-btn-icon--sm"></i>
			<div class="js-added-show1 js-show-ages formDirections__inp-block"><span class="bth__inp normal">лет</span></div>
			<i class="js-added-show2 hidden formDirections__guest-btn-icon formDirections__guest-btn-icon--sm"></i>
			<div class="js-added-show2 hidden js-show-ages formDirections__inp-block"><span class="bth__inp normal">лет</span></div>
			<i class="js-added-show3 hidden formDirections__guest-btn-icon formDirections__guest-btn-icon--sm"></i>
			<div class="js-added-show3 hidden js-show-ages formDirections__inp-block"><span class="bth__inp normal">лет</span></div>
		</div>
	</div>
	<div class="ml0 mb0 formDirections__static-btn formDirections__static-btn--sm js-close-formDirections">Применить</div>
	</div>
	</div>
	<div class="js-ages formDirections__bottom-item no-border" style="display: none">
	<div>
	<span class="formDirections__lb-uppercase bold">Возраст ребенка</span>
	<div class="formDirections__price-currencys formDirections__price-currencys--justify">
	<?php $js = <<< JS
	for(var i=1;i<=17;i++){
		$('.formDirections__price-currencys--justify').append(
		"<div class='formDirections__price-currency formDirections__price-currency--sm'><input id='child-age"+i
		+"' class='hidden' name='child-age' type='radio'></input><label class='formDirections__price-currency-lb' for='child-age"+i
		+"'>"+i+"</label></div>");
	}
JS;
$this->registerJs($js, yii\web\View::POS_END);	?>	
	</div>
	</div>
	</div>
	</div>
	</div>
	</div>
	<div class="tour-selection-field tour-selection-field--price">
	<div class="bth__inp-block js-show-formDirections">
	<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_price_id', 'name'=>'cf_price_limit']) ?>
	<span class="bth__inp-lbl ">Цена не более</span><span class="bth__inp  "></span></div>
	<div class="formDirections formDirections--price formDirections--left ">
	<div class="formDirections__wrap">
		<div class="formDirections__top formDirections__top--white">
			<i class="formDirections__bottom-close"></i>
			<div class="formDirections__top-tab super-grey">Стоимость тура</div>
		</div>
		<div class="formDirections__price-wrap js-act-currencys" style="display: none;">
		<div class="formDirections__price-inputs">
		<span class="formDirections__price-lb bold">Выберите валюту</span>
		<div class="formDirections__price-currencys">
<?php $currenciesjs = <<< JS
for(var i=1;i<=6;i++){
	$(".formDirections__price-inputs .formDirections__price-currencys").append("<div class='formDirections__price-currency'><input id='currency"+i
	+"-2' name='currency-2' type='radio' class='hidden' checked=''><label class='formDirections__price-currency-lb' for='currency"+i
	+"-2'></label></div>");
}

$("#currency1-2").next("label").append("<span class='formDirections__price-currency-sign'>₽</span><span class='fz13'>Рубль</span>");
$("#currency2-2").next("label").append("<span class='formDirections__price-currency-sign'>€</span><span class='fz13'>Евро</span>");
$("#currency3-2").next("label").append("<span class='formDirections__price-currency-sign'>$</span><span class='fz13'>Доллар</span>");
$("#currency4-2").next("label").append("<span class='formDirections__price-currency-sign'>₸</span><span class='fz13'>Тенге</span>");
$("#currency5-2").next("label").append("<span class='formDirections__price-currency-sign'>Б</span><span class='fz13'>Бел. рубль</span>");
$("#currency6-2").next("label").append("<span class='formDirections__price-currency-sign'>₴</span><span class='fz13'>Гривна</span>");
JS;
$this->registerJs($currenciesjs, yii\web\View::POS_END); ?>
		</div>
		</div>
		</div>
		<div class="formDirections__price-wrap js-hide-price-inputs">
		<div class="formDirections__price-inputs">
			<div>
				<label for="opt-price2" class="formDirections__price-lb bold">Комфортный бюджет</label>
				<div class="formDirections__price">
					<input class="bth__inp" id="opt-price2" type="text" value="0">
					<div class="formDirections__price-input-bbl js-show-currencys">  €   </div>
				</div>
				<div class="bth__inp-range-block"><input class="bth__inp-range" step="1000" type="range" value="0" min="0" max="100000" name="priceBudgetRangeMin"></div>
			</div>
			<div>
				<label for="max-price2" class="formDirections__price-lb bold">Максимальный бюджет</label>
				<div class="formDirections__price">
					<input class="bth__inp" id="max-price2" type="text" value="0">
					<div class="formDirections__price-input-bbl js-show-currencys">  €   </div>
				</div>
				<div class="bth__inp-range-block"><input class="bth__inp-range" step="1000" type="range" value="0" min="0" max="1000000" name="priceBudgetRangeMax"></div>
			</div>
		</div>
		<div class="formDirections__static-btn formDirections__static-btn--sm js-close-formDirections">Применить</div>
		</div>
	</div>
	</div>
	</div>
	</div>
	<div class="tour-selection-wrap-in">
	<?= \yii\bootstrap\Html::radioList('types', '1', ['1' => 'Турпакет', '0' => 'Конкретный отель'], ['unselect'=>null, 'disabled'=>true, 'item' => 
	function ($index, $label, $name, $checked, $value){
		//$is_checked = ($index == 0)?'checked':$checked;
		$options = [];
		$iid = $index+1;
		$ret = '<div class="rbt-block mt0 mb0 ">';
		//$ret .= '<input id="type1" class="rbt" type="radio" name="' . $name . '" value="' . $value . '" '.$is_checked.'>';
		$ret .= \yii\bootstrap\Html::radio($name, $checked, array_merge($options, [
                'value' => $value,
                'label' => null,
				'class' => 'rbt',
				'id' => 'type'.$iid,
            ]));
		$ret .= '<label class=" js-type'.$iid.' label-rbt" for="type'.$iid.'">';
		$ret .= '<span class="rbt-cnt uppercase">'.\yii\bootstrap\Html::encode($label).'</span></label></div>';
		
		return $ret;
	}, 'tag'=>false]) ?>	
	</div>
	<div class=" js-types-search-tours-blocks">
	<div class="tour-selection-wrap-in tour-selection-wrap-flex">
		<div class="tour-selection-field tour-selection-field--250 ">
		<div class="bth__inp-block">
		<?= $complex_form->field($cmplxf_model, 'direction', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_country', 'name'=>'cf_direction_country', 'value'=>'не важно']) ?>
		<span class="bth__inp-lbl bth__inp-lbl--center active">Страна поездки</span>
		<div class="bth__inp tour-selection__country  js-show-formDirections">
			<div class="tour-selection__flag lsfw-flag"></div>
			<b class="tour-selection__country-cut">Не важно</b>
		</div>
		<div class="formDirections w100p">
			<div class="formDirections__wrap w100p">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey ">Страна поездки</div>
			</div>
			<div class="SumoSelect formDirections__SumoSelect formDirections__SumoSelect-search">
				
	<?= $complex_form->field($cmplxf_model, 'direction', ['template' => '{input}', 
	'options'=>['tag'=>false]])->dropDownList(ArrayHelper::map($countries_model->find()->orderBy("name ASC")->all(), 'id', 'name'), ['tabindex'=>'-1', 'class'=>'SumoUnder', 'id'=>'sumo-direction'])->label(false) ?>
				
			</div>
			</div>
		</div>
		</div>
		</div>
		<div class="tour-selection-field tour-selection-field--180 ">
		<div class="bth__inp-block js-show-formDirections">
		<?= $complex_form->field($cmplxf_model, 'direction', ['template' => '{input}', 
		'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_city', 'name'=>'cf_direction_city', 'value'=>'не важно']) ?>
		<span class="bth__inp-lbl active">Город</span><span class="bth__inp  uppercase ">Не важно</span></div>
		<div class="formDirections w100p">
		<div class="formDirections__wrap w100p">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey ">Страна поездки</div>
			</div>
			<div class="SumoSelect formDirections__SumoSelect formDirections__SumoSelect-search hidden">	
				
				<?= $complex_form->field($cmplxf_model, 'direction', ['template' => '{input}', 
	'options'=>['tag'=>false]])->widget(DepDrop::classname(), [
			'options'=>['tabindex'=>'-1', 'class'=>'SumoUnder', 'id'=>'sumo-direction-city'],
				'pluginOptions'=>[
				'depends'=>['sumo-direction'],
				'placeholder'=>'No country...',
				'url'=>'index.php?r=site%2fres' // yii\helpers\Url::to(['/site/resorts'])
				]
		]);?>
			</div>
			<div class="no-country-selected">Укажите страну</div>
		</div>
		</div>
		</div>
		<div class="tour-selection-field tour-selection-field--200 ">
		<div class="bth__inp-block js-show-formDirections">
		<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
		'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_department', 'name'=>'cf_depart_city', 'value'=>'без перелёта']) ?>
		<span class="bth__inp-lbl active">Город вылета</span><span class="bth__inp  uppercase ">без перелёта</span></div>
		<div class="formDirections w100p">
		<div class="formDirections__wrap w100p">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey ">Город вылета</div>
			</div>
			<div class="SumoSelect formDirections__SumoSelect formDirections__SumoSelect-search">
				
				<?php $departCities = [0=>'Алматы', 1=>'Астана', 2=>'Белгород', 3=>'Брянск', 4=>'Владикавказ',
				5=>'Волгоград', 6=>'Воронеж', 7=>'Гомель', 8=>'Гродно', 9=>'Екатеринбург', 10=>'Иркутск',
				11=>'Калининград', 12=>'Киев', 13=>'Краснодар', 14=>'Красноярск', 15=>'Магадан', 16=>'Махачкала',
				17=>'Минеральные воды', -2=>'Москва', 19=>'Мурманск', 20=>'Набережные Челны', 21=>'Нижний Новгород', 22=>'Новосибирск',
				23=>'Омск', 24=>'Оренбург', 25=>'Пенза', 26=>'Ростов-на-Дону', 27=>'Саратов',
				-1=>'Санкт-Петербург', 29=>'Симферополь', 30=>'Смоленск', 31=>'Сочи', 32=>'Томск', 33=>'Ульяновск',
				34=>'Харьков', 35=>'Челябинск', 36=>'Шымкент', 37=>'Якутск', 38=>'Ярославль',];
				ksort($departCities);?>
				<?= \yii\bootstrap\Html::dropDownList('depcities', 'без перелета', $departCities, ['tabindex'=>'-1', 'class'=>'SumoUnder', 'id'=>'sumo-department'])?>
				
			</div>
		</div>
		</div>
		</div>
		<div class="tour-selection-field tour-selection-field--180 ">
		<div class="bth__inp-block js-show-formDirections js-formDirections--big-mobile">
		<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_hotel_id', 'name'=>'cf_hotel_params']) ?>
		<span class="bth__inp-lbl ">Параметры отеля</span><span class="bth__inp"></span></div>
		<div class="formDirections   formDirections--big-mobile formDirections--char">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey">Параметры отеля</div>
			</div>
			<div class="formDirections__wrap formDirections__row">
				<div class="formDirections__wrap-flex">
					<div class="formDirections__top  formDirections__top-line">
						<div class="formDirections__top-tab js-act-stars active">Категория</div>
						<div class="formDirections__top-tab js-act-rating">Рейтинг</div>
						<div class="formDirections__top-tab js-act-hotels">Питание</div>
						<div class="formDirections__top-tab js-act-country">Расположение</div>
						<div class="formDirections__top-tab js-act-kid">Для детей</div>
						<div class="formDirections__top-tab js-act-other">Прочее</div>
					</div>
					<div class="formDirections__wrap-flex-right">
						<div class="formDirections__bottom js-search-country" style="display: none;">
							<div class="formDirections__bottom-blocks">
								<div class="form-dropdown-stars__item">
									<div class="cbx-block   cbx-block--16 ">
								<?= \yii\bootstrap\Html::checkbox('hoteldata', true, ['class'=>'cbx', 'id'=>'catalog-positionckd']) ?>
								<label class="label-cbx" for="catalog-positionckd"><span class="cbx-cnt">Любой тип</span></label>
									</div>
								</div>
								<div class="formDirections__cbx-ttl">Пляжный</div>
								<?php $genChbxs = function($index, $label, $name, $checked, $value){
									$iid = $value + 1;
									$ret = '<div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>'catalog-position'.$iid]);
									$ret .= '<label class="label-cbx" for="catalog-position'.$iid.'">';
									$ret .= '<span class="cbx-cnt">'.$label.'</span></label></div>';
									return $ret;
								}; 
								$genChbxs2 = function($index, $label, $name, $checked, $value){
									$iid = ($index == 0)?'ckd':$index;
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>'333eat2-type'.$iid]);
									$ret .= '<label class="label-cbx" for="333eat2-type'.$iid.'">';
									$ret .= '<span class="cbx-cnt">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genChbxs3 = function($index, $label, $name, $checked, $value){
									$iid = ($index < 8)? '333stars-'.$value:'no-stars';
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>$iid]);
									$ret .= '<label class="label-cbx" for="'.$iid.'">';
									$ret .= $label.'</label></div></div>';
									return $ret;
								};
								$genRadio = function($index, $label, $name, $checked, $value){
									$iid = ($index == 0)?'ckd':$index;
									$ret = '<div class="form-dropdown-stars__item "><div class="rbt-block  ">';
									$ret .= \yii\bootstrap\Html::radio($name, ($index == 0)?true:false, ['class'=>'rbt', 'id'=>'333rating'.$iid]);
									$ret .= '<label class="label-rbt" for="333rating'.$iid.'">';
									$ret .= '<span class="rbt-cnt  uppercase">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genChbxs4 = function($index, $label, $name, $checked, $value){
									$iid = $index + 1;
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>'333kid'.$iid]);
									$ret .= '<label class="label-cbx" for="333kid'.$iid.'">';
									$ret .= '<span class="cbx-cnt">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genChbxs5 = function($index, $label, $name, $checked, $value){
									$iid = $index + 1;
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>'333other'.$iid]);
									$ret .= '<label class="label-cbx" for="333other'.$iid.'">';
									$ret .= '<span class="cbx-cnt">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genChbxs6 = function($index, $label, $name, $checked, $value){
									$iid = ($index == 0)?'ckd':$index;
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>'8eat2-type'.$iid]);
									$ret .= '<label class="label-cbx" for="8eat2-type'.$iid.'">';
									$ret .= '<span class="cbx-cnt">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genChbxs2b = function($index, $label, $name, $checked, $value){
									$iid = ($index == 0)?'ckdb':$index.'b';
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>'333eat2-type'.$iid]);
									$ret .= '<label class="label-cbx" for="333eat2-type'.$iid.'">';
									$ret .= '<span class="cbx-cnt">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genChbxs3b = function($index, $label, $name, $checked, $value){
									$iid = ($index < 8)? '333stars-b'.$value:'no-starsb';
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>$iid]);
									$ret .= '<label class="label-cbx" for="'.$iid.'">';
									$ret .= $label.'</label></div></div>';
									return $ret;
								};
								$genChbxs4b = function($index, $label, $name, $checked, $value){
									$iid = $index + 1;$iid .= 'b';
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>'333kid'.$iid]);
									$ret .= '<label class="label-cbx" for="333kid'.$iid.'">';
									$ret .= '<span class="cbx-cnt">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genChbxs5b = function($index, $label, $name, $checked, $value){
									$iid = $index + 1;$iid .= 'b';
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>'333other'.$iid]);
									$ret .= '<label class="label-cbx" for="333other'.$iid.'">';
									$ret .= '<span class="cbx-cnt">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genRadiob = function($index, $label, $name, $checked, $value){
									$iid = ($index == 0)?'ckdb':$index.'b';
									$ret = '<div class="form-dropdown-stars__item "><div class="rbt-block  ">';
									$ret .= \yii\bootstrap\Html::radio($name, ($index == 0)?true:false, ['class'=>'rbt', 'id'=>'333rating'.$iid]);
									$ret .= '<label class="label-rbt" for="333rating'.$iid.'">';
									$ret .= '<span class="rbt-cnt  uppercase">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genChbxs2c = function($index, $label, $name, $checked, $value){
									$iid = ($index == 0)?'ckdb':$index.'c';
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>'333eat2-type'.$iid]);
									$ret .= '<label class="label-cbx" for="333eat2-type'.$iid.'">';
									$ret .= '<span class="cbx-cnt">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genChbxs3c = function($index, $label, $name, $checked, $value){
									$iid = ($index < 8)? '333stars-c'.$value:'no-starsc';
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>$iid]);
									$ret .= '<label class="label-cbx" for="'.$iid.'">';
									$ret .= $label.'</label></div></div>';
									return $ret;
								};
								$genChbxs4c = function($index, $label, $name, $checked, $value){
									$iid = $index + 1;$iid .= 'c';
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>'333kid'.$iid]);
									$ret .= '<label class="label-cbx" for="333kid'.$iid.'">';
									$ret .= '<span class="cbx-cnt">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genChbxs5c = function($index, $label, $name, $checked, $value){
									$iid = $index + 1;$iid .= 'c';
									$ret = '<div class="form-dropdown-stars__item "><div class="cbx-block   cbx-block--16 ">';
									$ret .= \yii\bootstrap\Html::checkbox($name, false, ['class'=>'cbx', 'id'=>'333other'.$iid]);
									$ret .= '<label class="label-cbx" for="333other'.$iid.'">';
									$ret .= '<span class="cbx-cnt">'.$label.'</span></label></div></div>';
									return $ret;
								};
								$genRadioc = function($index, $label, $name, $checked, $value){
									$iid = ($index == 0)?'ckdc':$index.'c';
									$ret = '<div class="form-dropdown-stars__item "><div class="rbt-block  ">';
									$ret .= \yii\bootstrap\Html::radio($name, ($index == 0)?true:false, ['class'=>'rbt', 'id'=>'333rating'.$iid]);
									$ret .= '<label class="label-rbt" for="333rating'.$iid.'">';
									$ret .= '<span class="rbt-cnt  uppercase">'.$label.'</span></label></div></div>';
									return $ret;
								};?>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[0=>'1-я линия от моря', 1=>'2-я линия от моря', 2=>'3-я линия от моря', 3=>'через дорогу',], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
								<div class="formDirections__cbx-ttl">Горнолыжный</div>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[4=>'Близко', 5=>'Далеко', 6=>'Рядом'], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
								<div class="formDirections__cbx-ttl">Загородный</div>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[7=>'Близко', 8=>'Далеко', 9=>'Рядом'], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
								<div class="formDirections__cbx-ttl">Городской</div>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[10=>'Близко к центру', 11=>'Окраина', 12=>'Центр'], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
							</div>
						</div>
						<div class="formDirections__bottom js-search-hotels" style="display: none;">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[0=>'Любое питание', 1=>'AI все включено', 2=>'FB завтрак + обед + ужин', 3=>'HB завтрак + ужин', 4=>'BB завтрак', 5=>'RO без питания'], 
								['tag'=>false, 'item'=> $genChbxs2]) ?>
							</div>
						</div>
						<div class="formDirections__bottom js-search-stars" style="">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								['ckd'=>'<span class="cbx-cnt">Любая категория</span>', 5=>'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>', 4=>'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>', 3=>'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>', 2=>'<i class="fa fa-star"></i><i class="fa fa-star"></i>', 1=>'<i class="fa fa-star"></i>', 'hv1'=>'<span class="cbx-cnt">HV1</span>', 'hv2'=>'<span class="cbx-cnt">HV2</span>', ''=>'<span class="cbx-cnt">Без категории</span>'], 
								['tag'=>false, 'item'=> $genChbxs3]) ?>
							</div>
						</div>
						<div class="formDirections__bottom-blocks js-search-rating" style="display: none;">
						<?= \yii\bootstrap\Html::radioList('333rating', null, 
								[0=>'Любой рейтинг', 1=>'Не важно', 2=>'Не ниже 4,75', 3=>'Не ниже 4,5', 4=>'Не ниже 4,25', 5=>'Не ниже 4,0', 6=>'Не ниже 3,75', 7=>'Не ниже 3,5', 8=>'Не ниже 3,25'], 
								['tag'=>false, 'item'=> $genRadio]) ?>
						</div>
						<div class="formDirections__bottom js-search-kid" style="display: none;">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[0=>'Детский горшок', 1=>'Детский блюда', 2=>'Пленальный столик', 3=>'Анимация'], 
								['tag'=>false, 'item'=> $genChbxs4]) ?>
							</div>
						</div>
						<div class="formDirections__bottom js-search-other" style="display: none;">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[0=>'Веселая анимация', 1=>'Тусовки рядом с отелем'], 
								['tag'=>false, 'item'=> $genChbxs5]) ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="formDirections__btn-orange js-close-formDirections">Применить</div>
		</div>
		</div>
		<span class=" tour-selection-plus  hide-1023 js-add-field"><i class="fas fa-plus"></i></span>
	</div>
		<div class="tour-selection-wrap-in tour-selection-wrap-flex js-show-added-field" style="display: none">
			<div class="tour-selection-field tour-selection-field--250 ">
		<div class="bth__inp-block">
		<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_country2', 'name'=>'cf_direction_country2']) ?>
		<span class="bth__inp-lbl bth__inp-lbl--center active">Страна поездки</span>
		<div class="bth__inp tour-selection__country  js-show-formDirections">
			<div class="tour-selection__flag lsfw-flag"></div>
			<b class="tour-selection__country-cut">Не важно</b>
		</div>
		<div class="formDirections w100p">
			<div class="formDirections__wrap w100p">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey ">Страна поездки</div>
			</div>
			<div class="SumoSelect formDirections__SumoSelect formDirections__SumoSelect-search">
				
	<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->dropDownList(ArrayHelper::map($countries_model->find()->orderBy("name ASC")->all(), 'id', 'name'), ['tabindex'=>'-1', 'class'=>'SumoUnder', 'id'=>'sumo-direction2'])->label(false) ?>
				
			</div>
			</div>
		</div>
		</div>
		</div>
	<div class="tour-selection-field tour-selection-field--180 ">
		<div class="bth__inp-block js-show-formDirections">
		<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_city2', 'name'=>'cf_direction_city2']) ?>
		<span class="bth__inp-lbl active">Город</span><span class="bth__inp  uppercase ">не важно</span></div>
		<div class="formDirections w100p">
		<div class="formDirections__wrap w100p">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey ">Страна поездки</div>
			</div>
			<div class="SumoSelect formDirections__SumoSelect formDirections__SumoSelect-search hidden">
				
				<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
					'options'=>['tag'=>false]])->widget(DepDrop::classname(), [
				'options'=>['tabindex'=>'-1', 'class'=>'SumoUnder', 'id'=>'sumo-direction-city2'],
				'pluginOptions'=>[
				'depends'=>['sumo-direction2'],
				'placeholder'=>'Не важно',
				'url'=>'index.php?r=site%2fres'
						]
				]) ?>
				
			</div>
			<div class="no-country-selected">Укажите страну</div>
		</div>
		</div>
		</div>
	<div class="tour-selection-field tour-selection-field--200 ">
		<div class="bth__inp-block js-show-formDirections">
		<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_department2', 'name'=>'cf_depart_city2']) ?>
		<span class="bth__inp-lbl active">Город вылета</span><span class="bth__inp  uppercase ">Без перелёта</span></div>
		<div class="formDirections w100p">
		<div class="formDirections__wrap w100p">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey ">Город вылета</div>
			</div>
			<div class="SumoSelect formDirections__SumoSelect formDirections__SumoSelect-search">
				
				
				<?= \yii\bootstrap\Html::dropDownList('depcities', 'без перелета', $departCities, ['tabindex'=>'-1', 'class'=>'SumoUnder', 'id'=>'sumo-department2'])?>
				
			</div>
		</div>
		</div>
		</div>
		<div class="tour-selection-field tour-selection-field--180 ">
		<div class="bth__inp-block js-show-formDirections js-formDirections--big-mobile">
		<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_hotel_id2', 'name'=>'cf_hotel_params2']) ?>
		<span class="bth__inp-lbl ">Параметры отеля</span><span class="bth__inp"></span></div>
		<div class="formDirections   formDirections--big-mobile formDirections--char">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey">Параметры отеля</div>
			</div>
			<div class="formDirections__wrap formDirections__row">
				<div class="formDirections__wrap-flex">
					<div class="formDirections__top  formDirections__top-line">
						<div class="formDirections__top-tab js-act-stars active">Категория</div>
						<div class="formDirections__top-tab js-act-rating">Рейтинг</div>
						<div class="formDirections__top-tab js-act-hotels">Питание</div>
						<div class="formDirections__top-tab js-act-country">Расположение</div>
						<div class="formDirections__top-tab js-act-kid">Для детей</div>
						<div class="formDirections__top-tab js-act-other">Прочее</div>
					</div>
					<div class="formDirections__wrap-flex-right">
						<div class="formDirections__bottom js-search-country" style="display: none;">
							<div class="formDirections__bottom-blocks">
								<div class="form-dropdown-stars__item">
									<div class="cbx-block   cbx-block--16 ">
								<?= \yii\bootstrap\Html::checkbox('hoteldata', true, ['class'=>'cbx', 'id'=>'catalog-positionckd2']) ?>
								<label class="label-cbx" for="catalog-positionckd2"><span class="cbx-cnt">Любой тип</span></label>
									</div>
								</div>
								<div class="formDirections__cbx-ttl">Пляжный</div>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[20=>'1-я линия от моря', 21=>'2-я линия от моря', 22=>'3-я линия от моря', 23=>'через дорогу',], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
								<div class="formDirections__cbx-ttl">Горнолыжный</div>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[24=>'Близко', 25=>'Далеко', 26=>'Рядом'], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
								<div class="formDirections__cbx-ttl">Загородный</div>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[27=>'Близко', 28=>'Далеко', 29=>'Рядом'], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
								<div class="formDirections__cbx-ttl">Городской</div>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[210=>'Близко к центру', 211=>'Окраина', 212=>'Центр'], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
							</div>
						</div>
						<div class="formDirections__bottom js-search-hotels" style="display: none;">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[0=>'Любое питание', 1=>'AI все включено', 2=>'FB завтрак + обед + ужин', 3=>'HB завтрак + ужин', 4=>'BB завтрак', 5=>'RO без питания'], 
								['tag'=>false, 'item'=> $genChbxs2b]) ?>
							</div>
						</div>
						<div class="formDirections__bottom js-search-stars" style="">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								['ckd'=>'<span class="cbx-cnt">Любая категория</span>', 5=>'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>', 4=>'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>', 3=>'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>', 2=>'<i class="fa fa-star"></i><i class="fa fa-star"></i>', 1=>'<i class="fa fa-star"></i>', 'hv1'=>'<span class="cbx-cnt">HV1</span>', 'hv2'=>'<span class="cbx-cnt">HV2</span>', ''=>'<span class="cbx-cnt">Без категории</span>'], 
								['tag'=>false, 'item'=> $genChbxs3b]) ?>
							</div>
						</div>
						<div class="formDirections__bottom-blocks js-search-rating" style="display: none;">
						<?= \yii\bootstrap\Html::radioList('333rating', null, 
								[0=>'Любой рейтинг', 1=>'Не важно', 2=>'Не ниже 4,75', 3=>'Не ниже 4,5', 4=>'Не ниже 4,25', 5=>'Не ниже 4,0', 6=>'Не ниже 3,75', 7=>'Не ниже 3,5', 8=>'Не ниже 3,25'], 
								['tag'=>false, 'item'=> $genRadiob]) ?>
						</div>
						<div class="formDirections__bottom js-search-kid" style="display: none;">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[0=>'Детский горшок', 1=>'Детский блюда', 2=>'Пленальный столик', 3=>'Анимация'], 
								['tag'=>false, 'item'=> $genChbxs4b]) ?>
							</div>
						</div>
						<div class="formDirections__bottom js-search-other" style="display: none;">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[0=>'Веселая анимация', 1=>'Тусовки рядом с отелем'], 
								['tag'=>false, 'item'=> $genChbxs5b]) ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="formDirections__btn-orange js-close-formDirections">Применить</div>
		</div>
		</div>
		<span class=" tour-selection-plus js-del-field"><i class="fas fa-minus"></i></span>
		</div>
		
		<div class="tour-selection-wrap-in tour-selection-wrap-flex js-show-added2-field" style="display: none">
			<div class="tour-selection-field tour-selection-field--250 ">
		<div class="bth__inp-block">
		<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_country3', 'name'=>'cf_direction_country3']) ?>
		<span class="bth__inp-lbl bth__inp-lbl--center active">Страна поездки</span>
		<div class="bth__inp tour-selection__country  js-show-formDirections">
			<div class="tour-selection__flag lsfw-flag"></div>
			<b class="tour-selection__country-cut">Не важно</b>
		</div>
		<div class="formDirections w100p">
			<div class="formDirections__wrap w100p">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey ">Страна поездки</div>
			</div>
			<div class="SumoSelect formDirections__SumoSelect formDirections__SumoSelect-search">
				
	<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->dropDownList(ArrayHelper::map($countries_model->find()->orderBy("name ASC")->all(), 'id', 'name'), ['tabindex'=>'-1', 'class'=>'SumoUnder', 'id'=>'sumo-direction3'])->label(false) ?>
				
			</div>
			</div>
		</div>
		</div>
		</div>
	<div class="tour-selection-field tour-selection-field--180 ">
		<div class="bth__inp-block js-show-formDirections">
		<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_city3', 'name'=>'cf_direction_city3']) ?>
		<span class="bth__inp-lbl active">Город</span><span class="bth__inp  uppercase ">не важно</span></div>
		<div class="formDirections w100p">
		<div class="formDirections__wrap w100p">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey ">Страна поездки</div>
			</div>
			<div class="SumoSelect formDirections__SumoSelect formDirections__SumoSelect-search hidden">
				
				<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
					'options'=>['tag'=>false]])->widget(DepDrop::classname(), [
				'options'=>['tabindex'=>'-1', 'class'=>'SumoUnder', 'id'=>'sumo-direction-city3'],
				'pluginOptions'=>[
				'depends'=>['sumo-direction3'],
				'placeholder'=>'Не важно',
				'url'=>'index.php?r=site%2fres'
						]
				]) ?>
				
			</div>
			<div class="no-country-selected">Укажите страну</div>
		</div>
		</div>
		</div>
	<div class="tour-selection-field tour-selection-field--200 ">
		<div class="bth__inp-block js-show-formDirections">
		<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_department3', 'name'=>'cf_depart_city3']) ?>
		<span class="bth__inp-lbl active">Город вылета</span><span class="bth__inp  uppercase ">Без перелёта</span></div>
		<div class="formDirections w100p">
		<div class="formDirections__wrap w100p">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey ">Город вылета</div>
			</div>
			<div class="SumoSelect formDirections__SumoSelect formDirections__SumoSelect-search">
				
				
				<?= \yii\bootstrap\Html::dropDownList('depcities', 'без перелета', $departCities, ['tabindex'=>'-1', 'class'=>'SumoUnder', 'id'=>'sumo-department3'])?>
				
			</div>
		</div>
		</div>
		</div>
		<div class="tour-selection-field tour-selection-field--180 ">
		<div class="bth__inp-block js-show-formDirections js-formDirections--big-mobile">
		<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_hotel_id3', 'name'=>'cf_hotel_params3']) ?>
		<span class="bth__inp-lbl ">Параметры отеля</span><span class="bth__inp"></span></div>
		<div class="formDirections   formDirections--big-mobile formDirections--char">
			<div class="formDirections__top  formDirections__top-line">
				<i class="formDirections__bottom-close"></i>
				<div class="formDirections__top-tab super-grey">Параметры отеля</div>
			</div>
			<div class="formDirections__wrap formDirections__row">
				<div class="formDirections__wrap-flex">
					<div class="formDirections__top  formDirections__top-line">
						<div class="formDirections__top-tab js-act-stars active">Категория</div>
						<div class="formDirections__top-tab js-act-rating">Рейтинг</div>
						<div class="formDirections__top-tab js-act-hotels">Питание</div>
						<div class="formDirections__top-tab js-act-country">Расположение</div>
						<div class="formDirections__top-tab js-act-kid">Для детей</div>
						<div class="formDirections__top-tab js-act-other">Прочее</div>
					</div>
					<div class="formDirections__wrap-flex-right">
						<div class="formDirections__bottom js-search-country" style="display: none;">
							<div class="formDirections__bottom-blocks">
								<div class="form-dropdown-stars__item">
									<div class="cbx-block   cbx-block--16 ">
								<?= \yii\bootstrap\Html::checkbox('hoteldata', true, ['class'=>'cbx', 'id'=>'catalog-positionckd3']) ?>
								<label class="label-cbx" for="catalog-positionckd3"><span class="cbx-cnt">Любой тип</span></label>
									</div>
								</div>
								<div class="formDirections__cbx-ttl">Пляжный</div>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[30=>'1-я линия от моря', 31=>'2-я линия от моря', 32=>'3-я линия от моря', 33=>'через дорогу',], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
								<div class="formDirections__cbx-ttl">Горнолыжный</div>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[34=>'Близко', 35=>'Далеко', 36=>'Рядом'], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
								<div class="formDirections__cbx-ttl">Загородный</div>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[37=>'Близко', 38=>'Далеко', 39=>'Рядом'], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
								<div class="formDirections__cbx-ttl">Городской</div>
								<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[310=>'Близко к центру', 311=>'Окраина', 312=>'Центр'], 
								['class'=>' formDirections__left-30 ', 'item'=> $genChbxs]) ?>
							</div>
						</div>
						<div class="formDirections__bottom js-search-hotels" style="display: none;">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[0=>'Любое питание', 1=>'AI все включено', 2=>'FB завтрак + обед + ужин', 3=>'HB завтрак + ужин', 4=>'BB завтрак', 5=>'RO без питания'], 
								['tag'=>false, 'item'=> $genChbxs2c]) ?>
							</div>
						</div>
						<div class="formDirections__bottom js-search-stars" style="">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								['ckd'=>'<span class="cbx-cnt">Любая категория</span>', 5=>'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>', 4=>'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>', 3=>'<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>', 2=>'<i class="fa fa-star"></i><i class="fa fa-star"></i>', 1=>'<i class="fa fa-star"></i>', 'hv1'=>'<span class="cbx-cnt">HV1</span>', 'hv2'=>'<span class="cbx-cnt">HV2</span>', ''=>'<span class="cbx-cnt">Без категории</span>'], 
								['tag'=>false, 'item'=> $genChbxs3c]) ?>
							</div>
						</div>
						<div class="formDirections__bottom-blocks js-search-rating" style="display: none;">
						<?= \yii\bootstrap\Html::radioList('333rating', null, 
								[0=>'Любой рейтинг', 1=>'Не важно', 2=>'Не ниже 4,75', 3=>'Не ниже 4,5', 4=>'Не ниже 4,25', 5=>'Не ниже 4,0', 6=>'Не ниже 3,75', 7=>'Не ниже 3,5', 8=>'Не ниже 3,25'], 
								['tag'=>false, 'item'=> $genRadioc]) ?>
						</div>
						<div class="formDirections__bottom js-search-kid" style="display: none;">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[0=>'Детский горшок', 1=>'Детский блюда', 2=>'Пленальный столик', 3=>'Анимация'], 
								['tag'=>false, 'item'=> $genChbxs4c]) ?>
							</div>
						</div>
						<div class="formDirections__bottom js-search-other" style="display: none;">
							<div class="formDirections__bottom-blocks">
							<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
								[0=>'Веселая анимация', 1=>'Тусовки рядом с отелем'], 
								['tag'=>false, 'item'=> $genChbxs5c]) ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="formDirections__btn-orange js-close-formDirections">Применить</div>
		</div>
		</div>
		<span class=" tour-selection-plus js-del2-field"><i class="fas fa-minus"></i></span>
		</div>
	</div>
	<div class=" js-types-search-hotel-blocks" style="display: none">
	<div class="tour-selection-wrap-in tour-selection-wrap-flex">
		<div class="tour-selection-field tour-selection-field--250">
			<div class="bth__inp-block js-show-formDirections">
	<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_department_h', 'name'=>'cf_depart_city_h']) ?>
				<span class="bth__inp-lbl active">Город вылета</span>
				<span class="bth__inp uppercase">без перелёта</span>
			</div>
			<div class="formDirections w100p">
				<div class="formDirections__wrap w100p">
					<div class="formDirections__top  formDirections__top-line">
						<i class="formDirections__bottom-close"></i>
						<div class="formDirections__top-tab super-grey ">Город вылета</div>
					</div>
					<div class="SumoSelect formDirections__SumoSelect formDirections__SumoSelect-search">
					<?= \yii\bootstrap\Html::dropDownList('depcities', 'без перелета', $departCities, 
						['tabindex'=>'-1', 'class'=>'SumoUnder', 'id'=>'sumo-departmenth'])?>
					</div>
				</div>
			</div>
		</div>
		<div class="tour-selection-field tour-selection-field--250">
			<div class="bth__inp-block js-show-formDirections">
			<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_food_id_h', 'name'=>'cf_food_h']) ?>
				<span class="bth__inp-lbl active">Питание</span><span class="bth__inp uppercase">любое</span>
			</div>
			<div class="formDirections">
				<div class="formDirections__top  formDirections__top-line">
					<i class="formDirections__bottom-close"></i>
					<div class="formDirections__top-tab super-grey">Питание</div>
				</div>
				<div class="formDirections__wrap">
					<div class="formDirections__bottom ">
						<div class="formDirections__bottom-blocks">
		<?= \yii\bootstrap\Html::checkboxList('hoteldata', null, 
		[1=>'AI все включено', 2=>'FB завтрак + обед + ужин', 3=>'HB завтрак + ужин', 4=>'BB завтрак', 5=>'RO без питания'], 
		['tag'=>false, 'item'=> $genChbxs6]) ?>
		<div class="formDirections__static-btn js-close-formDirections">Применить</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tour-selection-wrap-in tour-selection-wrap-flex">
		<div class="tour-selection-field tour-selection-field--740">
			<div class="bth__inp-block js-show-formDirections js-formDirections--big-mobile">
			<?= $complex_form->field($cmplxf_model, 'direction', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_hotels_id', 'name'=>'cf_hotels']) ?>
				<span class="bth__inp-lbl ">Добавить отель</span><span class="bth__inp"></span>
			</div>
			<div class="formDirections formDirections--big-mobile w100p">
				<div class="formDirections__wrap w100p">
					<div class="formDirections__top formDirections__top--white">
						<i class="formDirections__bottom-close"></i>
						<div class="formDirections__top-tab super-grey">Добавить отель</div>
					</div>
					<div class="formDirections__bottom">
						<div class="formDirections__search"><input class="bth__inp" type="text" placeholder="Поиск отеля"></div>
						<div class="formDirections__wrap  formDirections__bottom-blocks-cut">
						<p class="no-match" style="display: block;">Введите название отеля</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<span class="tour-selection-plus hide-1023 js-add-hotel"><i class="fas fa-plus"></i></span>
	</div>
	<div class="tour-selection-wrap-in tour-selection-wrap-flex js-show-add-hotel " style="display: none">
		<div class="tour-selection-field tour-selection-field--740">
			<div class="bth__inp-block js-show-formDirections js-formDirections--big-mobile">
			<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_hotels2_id', 'name'=>'cf_hotels2']) ?>
				<span class="bth__inp-lbl ">Добавить отель</span><span class="bth__inp"></span>
			</div>
			<div class="formDirections formDirections--big-mobile w100p">
				<div class="formDirections__wrap w100p">
					<div class="formDirections__top formDirections__top--white">
						<i class="formDirections__bottom-close"></i>
						<div class="formDirections__top-tab super-grey">Добавить отель</div>
					</div>
					<div class="formDirections__bottom">
						<div class="formDirections__search"><input class="bth__inp" type="text" placeholder="Поиск отеля"></div>
						<div class="formDirections__wrap  formDirections__bottom-blocks-cut">
						<p class="no-match" style="display: block;">Введите название отеля</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<span class=" tour-selection-plus  js-del-hotel"><i class="fas fa-minus"></i></span>
	</div>
	
	<div class="tour-selection-wrap-in tour-selection-wrap-flex js-show-add2-hotel " style="display: none">
		<div class="tour-selection-field tour-selection-field--740">
			<div class="bth__inp-block js-show-formDirections js-formDirections--big-mobile">
			<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_hotels3_id', 'name'=>'cf_hotels3']) ?>
				<span class="bth__inp-lbl ">Добавить отель</span><span class="bth__inp"></span>
			</div>
			<div class="formDirections formDirections--big-mobile w100p">
				<div class="formDirections__wrap w100p">
					<div class="formDirections__top formDirections__top--white">
						<i class="formDirections__bottom-close"></i>
						<div class="formDirections__top-tab super-grey">Добавить отель</div>
					</div>
					<div class="formDirections__bottom">
						<div class="formDirections__search"><input class="bth__inp" type="text" placeholder="Поиск отеля"></div>
						<div class="formDirections__wrap  formDirections__bottom-blocks-cut">
						<p class="no-match" style="display: block;">Введите название отеля</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<span class=" tour-selection-plus  js-del2-hotel"><i class="fas fa-minus"></i></span>
	</div>
	</div>
	<div class="tour-selection-wrap-in">
		<div class="bth__ta-resizable-wrap">
		<?= $complex_form->field($cmplxf_model, 'body', ['template' => '{input}', 
	'options'=>['tag'=>false]])->textInput(['type'=>'hidden', 'id'=>'cf_wishes_id', 'name'=>'cf_wish']) ?>
			<div id="ad_wishes" class="bth__ta-resizable" contenteditable=""></div>
			<span class="bth__ta-resizable-hint">Дополнительные пожелания</span>
		</div>
	</div>
	<div class="tour-selection-wrap-in">
		<div class=" bth__btn  bth__btn--fill bth__loader">Сформировать заявку
			<div class=" bth__loader-spin">
                <i class="fas fa-circle"></i>
                <i class="fas fa-circle"></i>
                <i class="fas fa-circle"></i>
            </div>
		</div>
	</div>
	<?php ActiveForm::end(); ?>
	</div>
	<?php endif; ?>
	</div>
	<div id="formPanel" class="panel">
    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="bth__cnt fz18 bold">
            Спасибо, Ваша заявка отправлена и будет обработана в ближайшее время.
        </div>

        <!--<p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>-->

    <?php else: ?>

        <div class="bth__cnt uppercase">
            Пожалуйста, укажите параметры вашей поездки
        </div>

        <div class="tour-selection-wrap">
            <!--<div class="tour-selection-wrap-in">-->

                <?php $form = ActiveForm::begin(['id' => 'contact-form', 'layout'=>'horizontal', 
				'fieldConfig' => ['horizontalCssClasses' => ['label' => 'bth__inp-lbl', 
				'offset' => 'bth__inp-block', 'wrapper' => 'js-add-error', 'hint' => 'bth__cnt'], 
				'options' => ['class' => 'bth__inp-block long']]]); ?>

                    <div class="tour-selection-wrap-in">
					<?= $form->field($model, 'body', ['template' => '{input}{label}{error}', 
					'labelOptions' => [ 'class' => 'bth__inp-lbl' ]])->textarea(['rows' => 6, 
					'placeholder' => "", 'class' => 'bth__inp bold js-stop-label focus'])
					->label('<span class="block  mb5" style="font-weight:normal;">-укажите страну, курорт или отель</span><span class="block  mb5" style="font-weight:normal;">-количество человек</span><span class="block  mb5" style="font-weight:normal;">-ваши предпочтения по отелю</span><span class="block  mb5" style="font-weight:normal;">-ваш бюджет</span><span class="block" style="font-weight:normal;">-другие пожелания</span>') ?>
					</div>
					<div class="tour-selection-wrap-in tour-selection-wrap-flex">
					<div class="tour-selection-field tour-selection-field--30p">
					<?= $form->field($model, 'name', 
					['template' => '{input}{label}<div class="hint-block hint-block--abs"><i class="fa fa-question-circle question-error" aria-hidden="true"></i><div class="hint">{hint}</div></div>', 
					'options' => ['class' => 'bth__inp-block'], 'labelOptions' => 
					[ 'class' => 'bth__inp-lbl', 'style' => 'font-weight:normal;' ]])->textInput(
					['autofocus' => true, 'placeholder' => "", 'class' => 'bth__inp js-label'])
					->label('Ваше имя')->hint('Введите ваше имя') ?>
					</div>
					<div class="tour-selection-field tour-selection-field--30p">
					 <?= $form->field($model, 'phone', ['template' => 
					 '{input}{label}<div class="hint-block hint-block--abs"><i class="fa fa-question-circle question-error" aria-hidden="true"></i><div class="hint">{hint}</div></div>', 
					 'options' => ['class' => 'bth__inp-block'], 'labelOptions' => [ 'class' => 
					 'bth__inp-lbl', 'style' => 'font-weight:normal;' ]])->input('phone', 
					 ['placeholder' => "", 'class' => 'bth__inp js-label'])->label('Телефон')->hint('Введите ваш телефон'); ?>
					 </div>
					 <div class="tour-selection-field tour-selection-field--30p">
                    <?= $form->field($model, 'email',['template' => '{input}{label}{hint}', 
					'horizontalCssClasses' => ['wrapper' => ''], 'options' => ['class' => 'bth__inp-block'], 
					'labelOptions' => [ 'class' => 'bth__inp-lbl', 'style' => 'font-weight:normal;' ]])
					->input('email', ['placeholder' => "", 'class' => 'bth__inp js-label'])->label('Email (не обязательно)'); ?>
					</div>
					 </div>

                    
					<div class="tour-selection-wrap-in">
                    
                        <?= Html::submitButton('Отправить заявку*<div class=" bth__loader-spin">
                            <i class="fas fa-circle"></i>
                            <i class="fas fa-circle"></i>
                            <i class="fas fa-circle"></i>
                        </div>', ['class' => 'bth__btn bth__btn--fill bth__loader', 'name' => 'contact-button']) ?>
						
                    
					</div>
                <div class="tour-selection-wrap__abs-txt  bth__cnt bth__cnt--sm">
                        *Нажимая на кнопку "отправить", я принимаю
                        <a href="#p-agreement-pp" class="p-agreement-pp agree">
                            Соглашение об обработке личных данных</a> и
                        <a href="#p-agreement-pp" class="p-agreement-pp site-role">Правила сайта</a>
				</div>
				<?php ActiveForm::end(); ?>	

            <!--</div>-->
        </div>

    <?php endif; ?>
	</div>
	</div>
</div>

<div class="container">
        <div id="leftbar" class="leftbar">
            
<div id="leftbar" class="leftbar">


    <div class="left-menu-1023">
        <div class="left-menu-1023__top fixed-active">
            <div class="relative"> Навигация проекта
                <i class="left-menu-1023__top-close"></i>
            </div>
        </div>
        <div class="left-menu-1023__item js-observe-scroll">
            <div class="side-nav">
                <ul class="side-nav-ul">
                    <li class="side-nav-li pt10">
                        <div class="side-nav-li-a side-nav-li-a--del-arr ">Главная</div>
                    </li>
                    <li class="side-nav-li">
                        <a href="#my-profile" class="side-nav-li-a  side-nav-li-a--del-arr js-left-menu-1023-anchor ">Мой
                            профиль</a>
                    </li>
                    <li class="side-nav-li">
                        <a href="#catalog" class="side-nav-li-a side-nav-li-a--del-arr js-left-menu-1023-anchor  ">Каталог
                            отелей</a>
                    </li>
                    <li class="side-nav-li">
                        <a href="#club-tx" class="side-nav-li-a  side-nav-li-a--del-arr  js-left-menu-1023-anchor">Клуб
                            ТопХотелс</a>
                    </li>
                    <li class="side-nav-li">
                        <a href="#help-selection" class="side-nav-li-a  side-nav-li-a--del-arr js-left-menu-1023-anchor ">Помощь в
                            подборе</a>
                    </li>
                    <li class="side-nav-li">
                        <a href="#add-review" class="side-nav-li-a  side-nav-li-a--del-arr  js-left-menu-1023-anchor">Добавить
                            отзыв</a>
                    </li>
                    <li class="side-nav-li">
                        <a href="#features" class="side-nav-li-a  side-nav-li-a--del-arr  js-left-menu-1023-anchor">О
                            проекте</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="left-menu-1023__item">
            <a id="my-profile" class="left-menu-1023__ttl">Мой профиль</a>

            <div class="side-nav">

                <ul class="side-nav-ul">
                    <li class="side-nav-li side-nav-li-ttl">Моё участие</li>
                    <li class="side-nav-li">
                        <div class="side-nav-li-a ">Визитка</div>

                        <ul class="side-nav-li__tabs-list">
                            <li class="side-nav-li__tabs-li">
                                <a href="/tophotels/profile-cutaway#authorization">Визитка</a>
                            </li>

                            <li class="side-nav-li__tabs-li">
                                <a href="/tophotels/profile-cutaway#hotels"> Подборки и предложения</a>
                            </li>
                            <li class="side-nav-li__tabs-li">
                                <a href="/tophotels/profile-cutaway#recomend"> Меня рекомендуют</a>
                            </li>
                            <li class="side-nav-li__tabs-li">
                                <a href="/tophotels/profile-cutaway#sertificate">Сертификаты</a>
                            </li>
                        </ul>
                    </li>

                    <li class="side-nav-li">
                        <a href="/tophotels/profile" class="side-nav-li-a">Профиль</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/tape-my-actions" class="side-nav-li-a ">Лента моих действий</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/my-travels" class="side-nav-li-a ">Мои путешествия</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/my-progress" class="side-nav-li-a ">Достижения</a>

                    </li>
                </ul>
                <ul class="side-nav-ul">
                    <li class="side-nav-li side-nav-li-ttl">Коммуникации</li>
                    <li class="side-nav-li ">
                        <a href="/tophotels/log-all-messages" class="side-nav-li-a">Лог всех сообщений</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/my-subscription-hotels" class="side-nav-li-a ">Мои подписки на отели</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/tape-communication" class="side-nav-li-a ">Лента общения</a>

                    </li>
                </ul>
                <ul class="side-nav-ul">
                    <li class="side-nav-li side-nav-li-ttl">Настройка интересов</li>
                    <li class="side-nav-li ">
                        <a href="/tophotels/personal-data" class="side-nav-li-a ">Персональные данные</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/my-preference" class="side-nav-li-a">Мои предпочтения</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/my-connections" class="side-nav-li-a ">Мои контакты</a>

                    </li>
                </ul>
            </div>

        </div>

        <div class="left-menu-1023__item">
            <a id="catalog" class="left-menu-1023__ttl">Каталог отелей</a>

            <div class="side-nav">

                <ul class="side-nav-ul">
                    <li class="side-nav-li pt10">
                        <a href="/tophotels/hotels-catalog#hotelFilter" class="side-nav-li-a  side-nav-li-a--del-arr ">Фильтр</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/hotels-catalog#hotelSearch" class="side-nav-li-a  side-nav-li-a--del-arr ">
                            Поиск отеля</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/hotels-catalog#myInterests" class="side-nav-li-a   side-nav-li-a--del-arr">
                            Мои интересы</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/hotels-catalog#hotelChains" class="side-nav-li-a   side-nav-li-a--del-arr">
                            Сети отелей</a>

                    </li>


                </ul>
            </div>
        </div>


        <div class="left-menu-1023__item">
            <a id="club-tx" class="left-menu-1023__ttl">Клуб ТопХотелс</a>

            <div class="side-nav">

                <ul class="side-nav-ul">
                    <li class="side-nav-li side-nav-li-ttl">Сообщество</li>
                    <li class="side-nav-li ">
                        <a href="#" class="side-nav-li-a grey">Лента клуба</a>
                    </li>
                    <li class="side-nav-li ">
                        <a href="/tophotels/forum" class="side-nav-li-a">Форум по отелям </a>

                    </li>
                    <li class="side-nav-li ">
                        <a href="/tophotels/hotline" class="side-nav-li-a ">Спецакции отелей</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/club-vote" class="side-nav-li-a ">Опросы</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="#" class="side-nav-li-a grey">Конкурсы и игры</a>

                    </li>
                </ul>
                <ul class="side-nav-ul">
                    <li class="side-nav-li side-nav-li-ttl">Рейтинги</li>
                    <li class="side-nav-li ">
                        <a href="/tophotels/ratings-nominations" class="side-nav-li-a ">Номинации отелей</a>

                    </li>
                    <li class="side-nav-li ">
                        <a href="#" class="side-nav-li-a ">Рейтинг номеров</a>
                    </li>
                    <li class="side-nav-li ">
                        <a href="/tophotels/top-users" class="side-nav-li-a ">ТОП участников </a>

                    </li>
                </ul>
                <ul class="side-nav-ul">
                    <li class="side-nav-li side-nav-li-ttl">Участники</li>
                    <li class="side-nav-li">
                        <a href="/tophotels/who-where-when" class="side-nav-li-a ">Кто Где Когда</a>

                    </li>
                    <li class="side-nav-li ">
                        <a href="/tophotels/club-traveler-list" class="side-nav-li-a ">Путешественники</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/club-touragent-list" class="side-nav-li-a ">ПРО Турагенты</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="#" class="side-nav-li-a grey">Индивидуальные гиды</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="#" class="side-nav-li-a grey">Отельеры</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/hotels-communities" class="side-nav-li-a ">Сообщества отелей</a>

                    </li>
                </ul>


            </div>

        </div>

        <div class="left-menu-1023__item">
            <a id="help-selection" class="left-menu-1023__ttl">Помощь в подборе</a>

            <div class="side-nav">

                <ul class="side-nav-ul">
                    <li class="side-nav-li pt10">
                        <a href="/tophotels/help-selection#step1" class="side-nav-li-a  side-nav-li-a--del-arr ">Параметры
                            тура</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/help-selection#form" class="side-nav-li-a  side-nav-li-a--del-arr"> Простая
                            форма</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/help-selection#formStep2" class="side-nav-li-a  side-nav-li-a--del-arr ">Рега</a>

                    </li>


                </ul>
            </div>
        </div>
        <div class="left-menu-1023__item">
            <a id="add-review" class="left-menu-1023__ttl">
                Добавить отзыв</a>

            <div class="side-nav">

                <ul class="side-nav-ul">
                    <li class="side-nav-li pt10">
                        <a href="/tophotels/review#search" class="side-nav-li-a   side-nav-li-a--del-arr">Добавление
                            отзыва</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="/tophotels/review#older" class="side-nav-li-a  side-nav-li-a--del-arr">Черновики
                            (14)</a>

                    </li>

                    <li class="side-nav-li">
                        <a href="/tophotels/review#no-hotel" class="side-nav-li-a  side-nav-li-a--del-arr">Нет отеля на
                            ТопХотелс</a>

                    </li>

                </ul>
            </div>
        </div>

        <div class="left-menu-1023__item">
            <a id="features" class="left-menu-1023__ttl">О проекте</a>

            <div class="side-nav">
                <ul class="side-nav-ul">
                    <li class="side-nav-li side-nav-li-ttl">Путешественникам</li>
                    <li class="side-nav-li">
                        <a href="#" class="side-nav-li-a ">Отдых с ТопХотелс</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="#" class="side-nav-li-a ">Полезные фишки</a>

                    </li>
                    <li class="side-nav-li">
                        <a href="#" class="side-nav-li-a ">Все возможности</a>

                    </li>


                </ul>

                <ul class="side-nav-ul">
                    <li class="side-nav-li side-nav-li-ttl">Для бизнеса</li>

                    <li class="side-nav-li ">
                        <a href="/tophotels/api-services" class="side-nav-li-a ">API сервисы</a>

                    </li>
                    <li class="side-nav-li ">
                        <a href="/tophotels/promotion-hotel" class="side-nav-li-a ">Продвижение отеля</a>

                    </li>
                    <li class="side-nav-li ">
                        <a href="/tophotels/touragent-profile" class="side-nav-li-a ">Профиль турагента</a>

                    </li>
                    <li class="side-nav-li ">
                        <a href="/tophotels/media-ad" class="side-nav-li-a ">Медийная реклама</a>

                    </li>

                </ul>
                <ul class="side-nav-ul">
                    <li class="side-nav-li side-nav-li-ttl">Информация</li>

                    <li class="side-nav-li ">
                        <a href="/tophotels/about-project" class="side-nav-li-a ">О проекте</a>

                    </li>

                    <li class="side-nav-li ">
                        <a href="/tophotels/terms-use" class="side-nav-li-a ">Правила пользования</a>

                    </li>

                    <li class="side-nav-li ">
                        <a href="/tophotels/job-and-career" class="side-nav-li-a ">Работа и карьера </a>

                    </li>

                    <li class="side-nav-li ">
                        <a href="/tophotels/feedback" class="side-nav-li-a">Обратная связь</a>

                    </li>


                </ul>
            </div>
        </div>

    </div>
</div>




        </div>
        
<div id="p-agreement-pp" class="agreement-pp mfp-hide">


    <div class="agreement-pp__mdl">
        <div class="agreement-pp__section">

            <div class="tabs-block">
                <div class="tabs-bar">
                    <div id="agreement" class="agreement-pp__tab active"> Соглашение об обработке личных данных</div>
                    <div id="siteRole" class="agreement-pp__tab"> Правила сайта</div>
                    <div class="agreement-pp__line" style="width: 345.117px; left: 30px;"></div>

                    <div class="js-modal-close agreement-pp__close"></div>
                </div>
                <div class="panel" id="agreementPanel" style="">
                    <div class="agreement-pp__cols ">

                        <div class="agreement-pp__right">
                            <div class="agreement-pp__white-field">
                                <div class="mb5 bold fz13">Текст соглашения</div>
                                <p>Настоящим я предоставляю согласие на обработку ООО «Медиа Трэвел эдвертайзинг» (ИНН
                                    7705523242, ОГРН 1127747058450, юридический адрес: 115093, г. Москва, 1-ый
                                    Щипковский пер., д. 1) моих персональных данных и подтверждаю, что давая такое
                                    согласие, я действую своей волей и в своем интересе. В соответствии с ФЗ от
                                    27.07.2006 г. № 152-ФЗ «О персональных данных» я согласен предоставить информацию,
                                    относящуюся к моей личности: мои фамилия, имя, отчество, адрес проживания,
                                    должность, контактный телефон, электронный адрес. Либо, если я являюсь законным
                                    представителем юридического лица, я согласен предоставить информацию, относящуюся к
                                    реквизитам юридического лица: наименование, юридический адрес, виды деятельности,
                                    наименование и ФИО исполнительного органа. В случае предоставления персональных
                                    данных третьих лиц, я подтверждаю, что мною получено согласие третьих лиц, в
                                    интересах которых я действую, на обработку их персональных данных, в том числе:
                                    сбор, систематизация, накопление, хранение, уточнение (обновление или изменение),
                                    использование, распространение (в том числе, передача), обезличивание, блокирование,
                                    уничтожение, а также осуществление любых иных действий с персональными данными в
                                    соответствии с действующим законодательством.</p>
                                <p> Согласие на обработку персональных данных дается мною в целях получения услуг,
                                    оказываемых ООО «Медиа Трэвел эдвертайзинг».</p>
                                <p> Я выражаю свое согласие на осуществление со всеми указанными персональными данными
                                    следующих действий: сбор, систематизация, накопление, хранение, уточнение
                                    (обновление или изменение), использование, распространение (в том числе, передача),
                                    обезличивание, блокирование, уничтожение, а также осуществление любых иных действий
                                    с персональными данными в соответствии с действующим законодательством. Обработка
                                    данных может осуществляться с использованием средств автоматизации, так и без их
                                    использования (при неавтоматической обработке).</p>
                                <p> При обработке персональных данных компания ООО «Медиа Трэвел эдвертайзинг» не
                                    ограничена в применении способов их обработки.</p>
                                <p> Настоящим я признаю и подтверждаю, что в случае необходимости компания ООО «Медиа
                                    Трэвел эдвертайзинг» вправе предоставлять мои персональные данные для достижения
                                    указанных выше целей третьему лицу, в том числе и при привлечении третьих лиц к
                                    оказанию услуг в указанных целях. Такие третьи лица имеют право на обработку
                                    персональных данных на основании настоящего согласия и на оповещение меня о тарифах
                                    услуг, специальных акциях и предложениях сайта. Информирование осуществляется по
                                    средствам телефонной связи и/или по электронной почте. Я осознаю, что проставление
                                    знака «V» или «X» в поле слева и нажатие кнопки «Продолжить», либо кнопки «Согласен»
                                    ниже текста настоящего соглашения, означает мое письменное согласие с условиями,
                                    описанными ранее.</p>
                                <br>
                                <p>* Авторизованным пользователям согласие на обработку данных необходимо дать только
                                    один раз.</p>
                            </div>
							
                            <button class="bth__btn agreement-pp__btn " onclick="event.preventDefault();$.magnificPopup.close();">Согласен</button>
                        </div>
                        <div class="agreement-pp__left">

                            <h2 class="agreement-pp__h2">Что такое персональные данные</h2>
                            <div class="bth__cnt fz14">
                                <p>Персональные данные - контактная информация,
                                    а также информация идентифицирующая физическое лицо, оставленная пользователем на
                                    проекте.</p>
                                <b> Для чего необходимо согласие на обработку персональных данных?</b>
                                <p> 152-ФЗ «О персональных данных» в ст.9 п.4 указывает на необходимость получения
                                    «письменного согласия субъекта персональных данных на обработку своих
                                    персональных данных». В том же законе разъясняется, что предоставленная информация
                                    является
                                    конфиденциальной. Деятельность организаций, осуществляющих регистрацию пользователей
                                    без получения такого согласия является незаконной.</p>
                                <a class="fz11" target="_blank" href="http://kremlin.ru/events/president/news/12097#sel=">Ознакомиться с законом на
                                    официальном сайте президента РФ</a>

                            </div>

                        </div>


                    </div>


                </div>


                <div class="panel" id="siteRolePanel" style="display: none;">

                    <div class="agreement-pp__role-site">

                        <div class="content-cnt">
                            <p class="about-project-text"><strong>ПРАВОВАЯ ОГОВОРКА </strong></p>
                            <p class="about-project-text">Используя сервисы, предлагаемые www.tophotels.ru, Вы выражаете
                                свое согласие с Условиями пользования ресурса. <br>
                                Пользуясь сервисами, предлагаемыми www.tophotels.ru, Вы принимаете условия
                                нижеизложенного <u><strong>Соглашения об условиях пользования ресурса</strong></u>, вне
                                зависимости от того, являетесь ли вы «Гостем» (что подразумевает простое использование
                                Вами сервиса) или «Зарегистрированным пользователем» (что подразумевает регистрацию на
                                интернет-ресурсе www.tophotels.ru), а так же, вне зависимости от цели и субъекта
                                использования.</p>

                            <p class="about-project-text"><strong>СОГЛАШЕНИЕ ОБ УСЛОВИЯХ ПОЛЬЗОВАНИЯ РЕСУРСА</strong>
                            </p>
                            <p class="about-project-text"><u>в редакции от 29 декабря 2014г.</u></p>
                            <p class="about-project-text"><strong>1.Термины и определения</strong></p>
                            <p class="about-project-text"><strong>Соглашение</strong> – Соглашение об условиях
                                пользования ресурса www.tophotels.ru. <br>
                                <strong>Администратор</strong> – администраторы, модераторы, правообладатели, а равно
                                иные законные владельцы ресурса www.tophotels.ru. <br>
                                <strong>Ресурс (Сервис)</strong> – интернет сайт www.tophotels.ru. <br>
                                <strong>Материалы</strong> - информация, размещенная на ресурсе: тексты, статьи,
                                фотоизображения, видеоизображения, иллюстрации.<br>
                                <strong>Пользователь</strong> - это конкретное лицо, либо организация, которое посещает
                                интернет-ресурс www.tophotels.ru.</p>
                            <p class="about-project-text"><strong>В зависимости от цели и субъекта использования ресурса
                                    различают виды Пользователей:</strong><br>
                                1.<u>Обычные пользователи </u>- физические лица, чаще всего туристы, а также лица,
                                планирующие свой отдых, посещающие ресурс в личных целях, не преследуя возможности
                                извлечения прибыли. <br>
                                2.<u>Коммерческие пользователи</u> – юридические лица, индивидуальные предприниматели, а
                                также их представители или иные лица, действующие в интересах вышеперечисленных
                                субъектов, посещающие ресурс в связи с их профессиональной деятельностью, преследующие
                                коммерческие цели. К коммерческим пользователям в тексте настоящего Соглашения отнесены
                                включая, но не ограничиваясь, следующие Пользователи – турагентства, туроператоры,
                                отели, туристические поисковые и информационные системы и прочие субъекты туристического
                                бизнеса, а равно лица, действующие в их интересах.</p>
                            <p class="about-project-text"><strong>2.Общие положения</strong></p>
                            <p class="about-project-text">2.1.Необходимым условием использования сервиса
                                www.tophotels.ru является согласие Пользователя действовать в полном соответствии со
                                всеми применяемыми правовыми нормами РФ и нормами международного права, а также в
                                соответствии с данным Соглашением. <br>
                                2.2.Администраторы сайта могут менять данное Соглашение в любое время. Любые изменения
                                данного Соглашения вступают в силу с момента их публикации на сайте www.tophotels.ru.
                                Продолжая использование сервиса www.tophotels.ru после публикации изменений, Вы
                                соглашаетесь действовать в соответствии с условиями, указанными в модифицированном
                                Соглашении.<br>
                                2.3.Администраторы ресурса (в т.ч. отели, сотрудничающие с ресурсом) вправе направлять
                                Пользователю полезную, актуальную, интересную и иную информацию путем рассылки по
                                электронной почте и размещения в личном кабинете. В любой момент Пользователи могут
                                отказаться от рассылок через личный кабинет.</p>
                            <p class="about-project-text">2.4<strong>Посещение и использование ресурса означает, что
                                    Пользователь принимает все условия настоящего Соглашения в полном объеме без
                                    каких-либо изъятий и ограничений. Использование ресурса на иных условиях не
                                    допускается. </strong><br>
                                2.5.Виду того, что активная ссылка на Соглашение размещена на главной странице ресурса и
                                доступна неопределенному кругу лиц, Соглашение считается заключенным с конкретным
                                Пользователем с момента посещения ресурса этим Пользователем, даже не смотря на
                                отсутствие регистрации Пользователя на ресурсе.</p>
                            <p class="about-project-text"><strong>3.Описание ресурса</strong></p>
                            <p class="about-project-text">3.1.www.tophotels.ru является информационным рейтингом отелей
                                и гостиниц мира, основанным на мнениях и отзывах профессионалов туристического бизнеса
                                (турагентов) и туристов. <br>
                                3.2.Данный ресурс представляет собой ежедневно пополняемый каталог отелей и гостиниц
                                мира, в который включены описания отелей, их фотографии и контакты. На нашем ресурсе
                                каждый человек, побывавший в том или ином отеле, может оставить о нем свой отзыв,
                                оценить размещение, уровень сервиса и питания в отеле, дополнительно аргументировав свои
                                оценки в отзыве, таким образом формируя рейтинг TOP Hotels. <br>
                                3.3.Кроме общей информации об отелях, пользователи могут найти на www.tophotels.ru ряд
                                дополнительных материалов и сервисов, которые могут пригодиться при выборе места
                                проведения отдыха. К ним относится информация о специальных акциях, новости отелей и
                                прочая сопутствующая информация.<br>
                                3.4.<u><strong>www.tophotels.ru, равно как и правообладатель данного ресурса не является
                                        туристическим агентством и не продает туристические услуги. </strong></u></p>
                            <p class="about-project-text"><strong>4.Интеллектуальная собственность.
                                    Ограничения использования ресурса</strong></p>
                            <p class="about-project-text"><strong><u>Общие ограничения</u>, вне зависимости от вида
                                    Пользователя</strong><br>
                                4.1.Все материалы на ресурсе www.tophotels.ru, включая, без ограничений, любую
                                документацию, текст, наполнение, данные, графические изображения, интерфейсы или другие
                                материалы, на которые распространяется действие закона об авторских правах, охраняются
                                федеральным и международным законодательством. Материалы сайта могут содержать торговые
                                марки, знаки обслуживания и торговые имена (названия). Все права защищены. <br>
                                4.2.Информация, размещенная Администраторами на ресурсе: тексты, статьи,
                                фотоизображения, видеоизображения, иллюстрации является собственностью правообладателя
                                ресурса или его партнеров, за исключением материалов, авторство которых оговорено
                                непосредственно в их содержании (статьи, тексты, фотографии и иллюстрации) или
                                информации загруженной Пользователями.<br>
                                4.3.Использование информации (текстовой, графической, аудиовизуальной и иной),
                                размещаемой на Сайте может осуществляться только при условии соблюдения требований
                                действующего законодательства РФ об авторском праве и интеллектуальной собственности, а
                                также настоящего Соглашения. <br>
                                4.4.Дизайн, структура Сайта, изображение, графика и иные элементы, являющиеся объектом
                                охраны по законодательству РФ, <strong>не могут воспроизводиться полностью или частично
                                    для создания новых информационных объектов</strong>, за исключением случаев
                                договорных или партнерских отношений с Администраторами ресурса, при этом условия
                                воспроизведения оговариваются в каждом случае индивидуально.<br>
                                4.5.Определенные части данного ресурса могут быть защищены паролем и могут требовать
                                регистрации пользователя, желающего просмотреть их. После процесса регистрации на нашем
                                сайте, Пользователю на безвозмездной основе, если иное не оговорено отдельно,
                                предоставляются учетная запись и пароль, позволяющие получать доступ ко всем услугам и
                                сервисам www.tophotels.ru. Пользователь обязуется обеспечивать конфиденциальность
                                пароля, и несет полную ответственность за любой ущерб и любые обязательства, ставшие
                                последствием неспособности обеспечивать конфиденциальность пароля. <br>
                                4.6.<strong>Пользователь соглашается не использовать www.tophotels.ru для: </strong><br>
                                - загрузки материалов, не соответствующих действующему законодательству, являющихся
                                вредными, угрожающими, оскорбительными, клеветническими, вульгарными или
                                неприличными;<br>
                                - того, чтобы выдавать себя за другое лицо или организацию, включая, но не
                                ограничиваясь, официальных представителей www.tophotels.ru или поставщиков туристических
                                услуг, а также для того, чтобы отражать несуществующую связь между Вами и другими
                                лицами, или организациями; <br>
                                - загрузки, рассылки, или любой другой формы публикации материалов, которые Вы не имеете
                                права публиковать; <br>
                                - загрузки, рассылки, или любой другой формы публикации незатребованной или запрещенной
                                рекламы, промо-материалов, спама, и любых других материалов рекламного характера; <br>
                                - загрузки, рассылки, или любой другой формы публикации материалов, содержащих
                                компьютерные вирусы или любые другие программные коды, файлы или программы, созданные с
                                целью прерывания, ликвидации или ограничения функциональности любого программного
                                обеспечения или аппаратуры; <br>
                                - препятствования или прерывания функционирования Сервиса, или серверов и сетей,
                                связанных с ресурсом. <br>
                                4.7.<strong>Пользователь ресурса обязуется:</strong><br>
                                - не переконструировать, не пытаться получить доступ к исходному коду, не распространять
                                и не создавать какие-либо производные работы, основанные на использовании Ресурса или
                                любой из его частей;<br>
                                - не входить на Ресурс какими-либо путями, отличными от предоставленного
                                www.tophotels.ru интерфейса. В дополнение к этому, любое программное обеспечение, доступ
                                к которому предоставляется на данном сайте, включая, но не ограничиваясь всеми HTML
                                кодами и онлайн средствами управления, является собственностью администраторов. Любое
                                воспроизведение или распространение данного программного обеспечения строго
                                запрещено.<br>
                                4.8.Администратор ресурса может по своему усмотрению и без предварительного уведомления
                                запретить/ограничить Пользователю пользование ресурсом. Причины данных мер могут
                                включать в себя, но не ограничиваются следующим:<br>
                                - нарушения данных Условий пользования или других договоров с администрацией
                                www.tophotels.ru;<br>
                                - соответствующие запросы правоохранительных или других государственных органов;<br>
                                - возникновение неожиданных технических неполадок или проблем с системой
                                безопасности;<br>
                                - участие Пользователя в мошеннических или незаконных операциях, и/или невыплата
                                каких-либо денежных сумм, взимаемых за предоставление услуг, связанных с Сервисом. <br>
                                <br>
                                <u><strong>Ограничения использования ресурса для Обычного пользователя:</strong></u><br>
                                4.9.www.tophotels.ru предоставляет бесплатные услуги, предназначенные для личного
                                некоммерческого использования. Пользователю не разрешается использовать данный сайт для
                                получения прибыли, за исключением договорных отношений с Администратором ресурса;<br>
                                4.10.Если обратное не указано на сайте, данное Соглашение разрешает Обычному
                                пользователю просматривать, загружать, кэшировать, копировать и распечатывать Материалы,
                                в соответствии со следующими условиями: <br>
                                - Любая копия Материалов или отдельной их части должна содержать ссылку на страницу
                                ресурса www.tophotels.ru , содержащую скопированную информацию;<br>
                                - Обычному пользователю дается ограниченное, неэксклюзивное право создавать
                                гипертекстовые ссылки на главную и внутренние страницы ресурса, с условием того, что
                                такая ссылка не ведет к ложному, уничижительному, обманному восприятию сервиса
                                www.tophotels.ru.<br>
                                <strong>При этом, www.tophotels.ru оставляет за собой право отменить вышеуказанные
                                    разрешения в любое время, без объяснения причин, вследствие чего любое использование
                                    Материалов должно быть немедленно прекращено по соответствующему уведомлению
                                    Администратора. </strong> <br>
                                <strong><u>Ограничения использования ресурса для Коммерческого
                                        пользователя:</u></strong><br>
                                4.11.Коммерческому пользователю не разрешается загружать, кэшировать, копировать и
                                распечатывать Материалы с сайта без получения предварительного письменного соглашения
                                Администратора сайта <br>
                                4.12.Коммерческому пользователю разрешается размещать ссылки только на полную версию
                                Ресурса, главную страницу www.tophotels.ru.<br>
                                4.13.Коммерческому пользователю не разрешается размещать ссылки на внутренние страницы
                                www.tophotels.ru, в том числе спецссылки с окончанием «?_mode —» вне зависимости от цели
                                их размещения. <br>
                                4.14.Коммерческому пользователю не разрешается использовать никакие из торговых марок,
                                логотипов или торговых названий с ресурса, равно как и любую другую авторскую
                                информацию, включая графические изображения, а также любой текст, или интерфейс/дизайн
                                любой страницы или любой формы, содержащейся на странице Сайта без получения
                                предварительного письменного соглашения Администратора сайта.</p>
                            <p class="about-project-text"><strong>5.Материалы, передаваемые (размещаемые)
                                    Пользователем для публикации и/или распространения посредством
                                    www.tophotels.ru</strong></p>
                            <p class="about-project-text">5.1.Пользователь гарантирует, что вся информация, размещенная
                                им, является подлинной. Ответственность за указание недостоверной, ложной, ошибочной
                                информации лежит на Пользователе.<br>
                                5.2.Пользователь несет ответственность за законность, соответствие реальному положению
                                дел, соответствие контексту, оригинальность и авторство любого из размещаемых им
                                материалов. <br>
                                5.3.Модератор имеет право вносить корректировки в комментарии и отзывы с ошибками или
                                ненормативной лексикой. Комментарии и отзывы, содержащие рекламу или любые другие
                                предложения коммерческого характера, будут удаляться с сайта. Активные или неактивные
                                ссылки, используемые в комментариях, в большинстве случаев будут вырезаны.
                                Администратор/модератор проекта вправе удалять отзывы/комментарии/фото, загруженные
                                пользователями без объяснения причин.<br>
                                5.4.Правообладатель сайта www.tophotels.ru не распространяет свои авторские права на
                                материалы, доступные на ресурсе (включая фотографии и графические элементы), публикуемые
                                Пользователем. Однако, публикуя такие материалы на ресурсе Пользователь передает
                                www.tophotels.ru международную, неэксклюзивную и безвозмездную лицензию (разрешение) на
                                использование, распространение, адаптацию и публикацию данных материалов с целью
                                описания и рекламы описываемого отеля или услуги. Срок действия разрешения
                                заканчивается, когда Пользователь, либо администрация www.tophotels.ru убирает данные
                                материалы со страниц сайта. <br>
                                5.5.Администрация ресурса не несёт ответственности за корректность представленной в
                                отзывах и комментариях информации. www.tophotels.ru не обеспечивает контроль материалов,
                                публикуемых Пользователями на ресурсе, и, вследствие этого, не гарантирует точность,
                                целостность или качество данных материалов. Пользователь самостоятельно должен оценивать
                                потенциальный риск и нести полную ответственность за использование любых материалов,
                                включая уверенность в их точности, полноте и полезности. <br>
                                5.6.Администраторы могут просматривать, либо не просматривать материалы перед их
                                публикацией. Представители www.tophotels.ru имеют право (но не обязанность) отслеживать,
                                отклонять или переносить любые материалы, доступные с помощью Сервиса. <br>
                                5.7.Пользователям ЗАПРЕЩЕНО размещать на ресурсе любые материалы, распространение
                                которых запрещено действующим законодательством Российской Федерации и/или нормами
                                международного права. Пользователь несет ответственность за несоответствие содержания
                                рекламно-информационных материалов, действующему законодательству РФ, в том числе,
                                нормам федеральных законов «О рекламе», «О средствах массовой информации», «Об авторском
                                праве и смежных правах», «О товарных знаках, знаках обслуживания и наименованиях мест
                                происхождения товаров». Пользователь гарантирует, что публикуемые им материалы не
                                являются ненадлежащей рекламой, а также не нарушают неприкосновенность частной жизни,
                                личной и семейной тайны, других охраняемых законом прав и интересов третьих лиц.</p>
                            <p class="about-project-text"><strong>6.Ограничение ответственности</strong>
                            </p>
                            <p class="about-project-text">6.1.Администраторы сайта прилагают все надлежащие усилия по
                                обеспечению корректности всей информации, размещенной на Сайте. Вместе с тем не
                                гарантируют абсолютную точность, полноту или достоверность информации, содержащейся на
                                Сайте, не отвечают за неточности, возможные ошибки или другие недостатки в размещаемой
                                информации. <br>
                                6.2.Оценка качества размещенной на Сайте информации, ее актуальности, полноты и
                                применимости - в ведении и компетенции Пользователя. <br>
                                6.3.www.tophotels.ru не предоставляет никаких гарантий. Информация и услуги,
                                предлагаемые на сайте, могут быть неточными, так как большинство данной информации
                                предоставляется непосредственно поставщиками услуг. <br>
                                6.4.Администраторы не гарантируют, что: <br>
                                - сервис будет соответствовать вашим требованиям;<br>
                                - результаты, полученные в процессе пользования сервисом, будут точными или
                                достоверными; <br>
                                - качество любых услуг, информации, или других материалов, приобретаемых вами с помощью
                                ресурса, будут соответствовать вашим требованиям. <br>
                                6.5.Рейтинги отелей, отражаемые на данном сайте, могут быть использованы только в
                                качестве общих рекомендаций.<br>
                                6.6. Администраторы www.tophotels.ru и/или работающие с ним третьи лица могут вносить
                                изменения в информацию на данном сайте в любое время.<br>
                                6.7.Партнеры www.tophotels.ru, включая, без ограничений, отели, туристические агентства
                                и туристических операторов, предоставляющие туристические или какие-либо другие услуги
                                посредством сервиса www.tophotels.ru не являются агентами или представителями
                                www.tophotels.ru.<br>
                                6.8. www.tophotels.ru не несет ответственность за действия, ошибки, обещания, гарантии
                                своих партнеров или третьих лиц, размещающих информацию на ресурсе, а также за нарушения
                                или несоблюдения ими договоров, равно как и за любой материальный, моральный прямой или
                                косвенный ущерб, или любые другие потери, возникающие вследствие вышеуказанного. <br>
                                6.9.Администраторы сайта не могут нести ответственность за любой прямой, косвенный
                                убыток, связанный с использованием данного сайта, или с задержкой или невозможностью его
                                использования, а также за любую информацию, продукты и услуги, приобретенные посредством
                                данного сайта, или другим способом полученные с его помощью. <br>
                                6.10.Данный сайт содержит гиперссылки на Интернет-ресурсы, управляемые лицами, не
                                связанными с www.tophotels.ru. Эти гиперссылки публикуются исключительно в
                                информационных и ознакомительных целях. Администратор не контролирует эти
                                Интернет-ресурсы и не несет ответственности за их содержимое и использование данного
                                содержимого Пользователями. <br>
                                6.11.Пользователь несет ответственность по искам и претензиям третьих лиц к
                                администраторам сайта и лично Пользователю за нарушения, вызванные размещением им
                                информационных материалов.<br>
                                6.12.Администраторы ресурса не несут ответственности за временные технические сбои и
                                перерывы в предоставлении услуг, за временные сбои и перерывы в работе линий связи, иные
                                аналогичные сбои, а также за неполадки компьютера, с которого Пользователь осуществляет
                                выход в Интернет.</p>
                            <p class="about-project-text"><strong>7.Разрешение споров и применяемая
                                    правовая норма</strong></p>
                            <p class="about-project-text">7.1.В случае публикации материалов, содержащихся на страницах
                                сайта, без соблюдения условий изложенных в настоящем Соглашении, администраторы
                                оставляют за собой право на защиту своих нарушенных прав в соответствии с действующим
                                гражданским законодательством и законодательством об авторском праве и смежных
                                правах.<br>
                                7.2.При обнаружении фактов нарушения условий настоящего Соглашения Администратор
                                отправляет «нарушителю» досудебное уведомление с требованием устранить выявленные
                                нарушения в установленный срок. При неисполнении указанных требований защита нарушенных
                                прав и взыскание причиненных убытков производится в судебном порядке по месту
                                регистрации правообладателя Сайта www.tophotels.ru<br>
                                7.3.Любые судебные процессы по данному Соглашению будут проводиться в Российской
                                Федерации в г. Москве, в соответствии с подсудностью судов судебной системы в РФ и
                                условиями настоящего Соглашения.</p>
                            <p class="about-project-text"><strong>8.Заключительные положения</strong></p>
                            <p class="about-project-text">8.1.Если Вы не согласны с Условиями пользования, или
                                какой-либо их частью, пожалуйста, воздержитесь от использования ресурса
                                www.tophotels.ru.&nbsp;<br>
                                <br>
                                Администраторы ресурса<br>
                                www.tophotels.ru<span id="ctrlcopy"><br><br>Читать полностью на&nbsp;<a href="https://www.tophotels.ru/about/agreement">https://www.tophotels.ru/about/agreement</a></span>
                            </p></div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div><div id="legal-information-pp" class="agreement-pp mfp-hide">


    <div class="agreement-pp__mdl">
        <div class="agreement-pp__section">

            <div class="tabs-block">
                <div class="tabs-bar">
                    <div id="usage-role" class="agreement-pp__tab"> Правила пользования</div>
                    <div id="confidentiality" class="agreement-pp__tab">  Конфиденциальность</div>
                    <div class="agreement-pp__line" style="width: 345.117px; left: 30px;"></div>

                    <div class=" js-modal-close  agreement-pp__close"></div>
                </div>

                <div class="panel" id="usage-rolePanel" style="">

                    <div class="agreement-pp__role-site">

                        <div class="content-cnt">
                            <p class="about-project-text"><strong>ПРАВОВАЯ ОГОВОРКА </strong></p>
                            <p class="about-project-text">Используя сервисы, предлагаемые www.tophotels.ru, Вы выражаете
                                свое согласие с Условиями пользования ресурса. <br>
                                Пользуясь сервисами, предлагаемыми www.tophotels.ru, Вы принимаете условия
                                нижеизложенного <u><strong>Соглашения об условиях пользования ресурса</strong></u>, вне
                                зависимости от того, являетесь ли вы «Гостем» (что подразумевает простое использование
                                Вами сервиса) или «Зарегистрированным пользователем» (что подразумевает регистрацию на
                                интернет-ресурсе www.tophotels.ru), а так же, вне зависимости от цели и субъекта
                                использования.</p>

                            <p class="about-project-text"><strong>СОГЛАШЕНИЕ ОБ УСЛОВИЯХ ПОЛЬЗОВАНИЯ РЕСУРСА</strong>
                            </p>
                            <p class="about-project-text"><u>в редакции от 29 декабря 2014г.</u></p>
                            <p class="about-project-text"><strong>1.Термины и определения</strong></p>
                            <p class="about-project-text"><strong>Соглашение</strong> – Соглашение об условиях
                                пользования ресурса www.tophotels.ru. <br>
                                <strong>Администратор</strong> – администраторы, модераторы, правообладатели, а равно
                                иные законные владельцы ресурса www.tophotels.ru. <br>
                                <strong>Ресурс (Сервис)</strong> – интернет сайт www.tophotels.ru. <br>
                                <strong>Материалы</strong> - информация, размещенная на ресурсе: тексты, статьи,
                                фотоизображения, видеоизображения, иллюстрации.<br>
                                <strong>Пользователь</strong> - это конкретное лицо, либо организация, которое посещает
                                интернет-ресурс www.tophotels.ru.</p>
                            <p class="about-project-text"><strong>В зависимости от цели и субъекта использования ресурса
                                    различают виды Пользователей:</strong><br>
                                1.<u>Обычные пользователи </u>- физические лица, чаще всего туристы, а также лица,
                                планирующие свой отдых, посещающие ресурс в личных целях, не преследуя возможности
                                извлечения прибыли. <br>
                                2.<u>Коммерческие пользователи</u> – юридические лица, индивидуальные предприниматели, а
                                также их представители или иные лица, действующие в интересах вышеперечисленных
                                субъектов, посещающие ресурс в связи с их профессиональной деятельностью, преследующие
                                коммерческие цели. К коммерческим пользователям в тексте настоящего Соглашения отнесены
                                включая, но не ограничиваясь, следующие Пользователи – турагентства, туроператоры,
                                отели, туристические поисковые и информационные системы и прочие субъекты туристического
                                бизнеса, а равно лица, действующие в их интересах.</p>
                            <p class="about-project-text"><strong>2.Общие положения</strong></p>
                            <p class="about-project-text">2.1.Необходимым условием использования сервиса
                                www.tophotels.ru является согласие Пользователя действовать в полном соответствии со
                                всеми применяемыми правовыми нормами РФ и нормами международного права, а также в
                                соответствии с данным Соглашением. <br>
                                2.2.Администраторы сайта могут менять данное Соглашение в любое время. Любые изменения
                                данного Соглашения вступают в силу с момента их публикации на сайте www.tophotels.ru.
                                Продолжая использование сервиса www.tophotels.ru после публикации изменений, Вы
                                соглашаетесь действовать в соответствии с условиями, указанными в модифицированном
                                Соглашении.<br>
                                2.3.Администраторы ресурса (в т.ч. отели, сотрудничающие с ресурсом) вправе направлять
                                Пользователю полезную, актуальную, интересную и иную информацию путем рассылки по
                                электронной почте и размещения в личном кабинете. В любой момент Пользователи могут
                                отказаться от рассылок через личный кабинет.</p>
                            <p class="about-project-text">2.4<strong>Посещение и использование ресурса означает, что
                                    Пользователь принимает все условия настоящего Соглашения в полном объеме без
                                    каких-либо изъятий и ограничений. Использование ресурса на иных условиях не
                                    допускается. </strong><br>
                                2.5.Виду того, что активная ссылка на Соглашение размещена на главной странице ресурса и
                                доступна неопределенному кругу лиц, Соглашение считается заключенным с конкретным
                                Пользователем с момента посещения ресурса этим Пользователем, даже не смотря на
                                отсутствие регистрации Пользователя на ресурсе.</p>
                            <p class="about-project-text"><strong>3.Описание ресурса</strong></p>
                            <p class="about-project-text">3.1.www.tophotels.ru является информационным рейтингом отелей
                                и гостиниц мира, основанным на мнениях и отзывах профессионалов туристического бизнеса
                                (турагентов) и туристов. <br>
                                3.2.Данный ресурс представляет собой ежедневно пополняемый каталог отелей и гостиниц
                                мира, в который включены описания отелей, их фотографии и контакты. На нашем ресурсе
                                каждый человек, побывавший в том или ином отеле, может оставить о нем свой отзыв,
                                оценить размещение, уровень сервиса и питания в отеле, дополнительно аргументировав свои
                                оценки в отзыве, таким образом формируя рейтинг TOP Hotels. <br>
                                3.3.Кроме общей информации об отелях, пользователи могут найти на www.tophotels.ru ряд
                                дополнительных материалов и сервисов, которые могут пригодиться при выборе места
                                проведения отдыха. К ним относится информация о специальных акциях, новости отелей и
                                прочая сопутствующая информация.<br>
                                3.4.<u><strong>www.tophotels.ru, равно как и правообладатель данного ресурса не является
                                        туристическим агентством и не продает туристические услуги. </strong></u></p>
                            <p class="about-project-text"><strong>4.Интеллектуальная собственность.
                                    Ограничения использования ресурса</strong></p>
                            <p class="about-project-text"><strong><u>Общие ограничения</u>, вне зависимости от вида
                                    Пользователя</strong><br>
                                4.1.Все материалы на ресурсе www.tophotels.ru, включая, без ограничений, любую
                                документацию, текст, наполнение, данные, графические изображения, интерфейсы или другие
                                материалы, на которые распространяется действие закона об авторских правах, охраняются
                                федеральным и международным законодательством. Материалы сайта могут содержать торговые
                                марки, знаки обслуживания и торговые имена (названия). Все права защищены. <br>
                                4.2.Информация, размещенная Администраторами на ресурсе: тексты, статьи,
                                фотоизображения, видеоизображения, иллюстрации является собственностью правообладателя
                                ресурса или его партнеров, за исключением материалов, авторство которых оговорено
                                непосредственно в их содержании (статьи, тексты, фотографии и иллюстрации) или
                                информации загруженной Пользователями.<br>
                                4.3.Использование информации (текстовой, графической, аудиовизуальной и иной),
                                размещаемой на Сайте может осуществляться только при условии соблюдения требований
                                действующего законодательства РФ об авторском праве и интеллектуальной собственности, а
                                также настоящего Соглашения. <br>
                                4.4.Дизайн, структура Сайта, изображение, графика и иные элементы, являющиеся объектом
                                охраны по законодательству РФ, <strong>не могут воспроизводиться полностью или частично
                                    для создания новых информационных объектов</strong>, за исключением случаев
                                договорных или партнерских отношений с Администраторами ресурса, при этом условия
                                воспроизведения оговариваются в каждом случае индивидуально.<br>
                                4.5.Определенные части данного ресурса могут быть защищены паролем и могут требовать
                                регистрации пользователя, желающего просмотреть их. После процесса регистрации на нашем
                                сайте, Пользователю на безвозмездной основе, если иное не оговорено отдельно,
                                предоставляются учетная запись и пароль, позволяющие получать доступ ко всем услугам и
                                сервисам www.tophotels.ru. Пользователь обязуется обеспечивать конфиденциальность
                                пароля, и несет полную ответственность за любой ущерб и любые обязательства, ставшие
                                последствием неспособности обеспечивать конфиденциальность пароля. <br>
                                4.6.<strong>Пользователь соглашается не использовать www.tophotels.ru для: </strong><br>
                                - загрузки материалов, не соответствующих действующему законодательству, являющихся
                                вредными, угрожающими, оскорбительными, клеветническими, вульгарными или
                                неприличными;<br>
                                - того, чтобы выдавать себя за другое лицо или организацию, включая, но не
                                ограничиваясь, официальных представителей www.tophotels.ru или поставщиков туристических
                                услуг, а также для того, чтобы отражать несуществующую связь между Вами и другими
                                лицами, или организациями; <br>
                                - загрузки, рассылки, или любой другой формы публикации материалов, которые Вы не имеете
                                права публиковать; <br>
                                - загрузки, рассылки, или любой другой формы публикации незатребованной или запрещенной
                                рекламы, промо-материалов, спама, и любых других материалов рекламного характера; <br>
                                - загрузки, рассылки, или любой другой формы публикации материалов, содержащих
                                компьютерные вирусы или любые другие программные коды, файлы или программы, созданные с
                                целью прерывания, ликвидации или ограничения функциональности любого программного
                                обеспечения или аппаратуры; <br>
                                - препятствования или прерывания функционирования Сервиса, или серверов и сетей,
                                связанных с ресурсом. <br>
                                4.7.<strong>Пользователь ресурса обязуется:</strong><br>
                                - не переконструировать, не пытаться получить доступ к исходному коду, не распространять
                                и не создавать какие-либо производные работы, основанные на использовании Ресурса или
                                любой из его частей;<br>
                                - не входить на Ресурс какими-либо путями, отличными от предоставленного
                                www.tophotels.ru интерфейса. В дополнение к этому, любое программное обеспечение, доступ
                                к которому предоставляется на данном сайте, включая, но не ограничиваясь всеми HTML
                                кодами и онлайн средствами управления, является собственностью администраторов. Любое
                                воспроизведение или распространение данного программного обеспечения строго
                                запрещено.<br>
                                4.8.Администратор ресурса может по своему усмотрению и без предварительного уведомления
                                запретить/ограничить Пользователю пользование ресурсом. Причины данных мер могут
                                включать в себя, но не ограничиваются следующим:<br>
                                - нарушения данных Условий пользования или других договоров с администрацией
                                www.tophotels.ru;<br>
                                - соответствующие запросы правоохранительных или других государственных органов;<br>
                                - возникновение неожиданных технических неполадок или проблем с системой
                                безопасности;<br>
                                - участие Пользователя в мошеннических или незаконных операциях, и/или невыплата
                                каких-либо денежных сумм, взимаемых за предоставление услуг, связанных с Сервисом. <br>
                                <br>
                                <u><strong>Ограничения использования ресурса для Обычного пользователя:</strong></u><br>
                                4.9.www.tophotels.ru предоставляет бесплатные услуги, предназначенные для личного
                                некоммерческого использования. Пользователю не разрешается использовать данный сайт для
                                получения прибыли, за исключением договорных отношений с Администратором ресурса;<br>
                                4.10.Если обратное не указано на сайте, данное Соглашение разрешает Обычному
                                пользователю просматривать, загружать, кэшировать, копировать и распечатывать Материалы,
                                в соответствии со следующими условиями: <br>
                                - Любая копия Материалов или отдельной их части должна содержать ссылку на страницу
                                ресурса www.tophotels.ru , содержащую скопированную информацию;<br>
                                - Обычному пользователю дается ограниченное, неэксклюзивное право создавать
                                гипертекстовые ссылки на главную и внутренние страницы ресурса, с условием того, что
                                такая ссылка не ведет к ложному, уничижительному, обманному восприятию сервиса
                                www.tophotels.ru.<br>
                                <strong>При этом, www.tophotels.ru оставляет за собой право отменить вышеуказанные
                                    разрешения в любое время, без объяснения причин, вследствие чего любое использование
                                    Материалов должно быть немедленно прекращено по соответствующему уведомлению
                                    Администратора. </strong> <br>
                                <strong><u>Ограничения использования ресурса для Коммерческого
                                        пользователя:</u></strong><br>
                                4.11.Коммерческому пользователю не разрешается загружать, кэшировать, копировать и
                                распечатывать Материалы с сайта без получения предварительного письменного соглашения
                                Администратора сайта <br>
                                4.12.Коммерческому пользователю разрешается размещать ссылки только на полную версию
                                Ресурса, главную страницу www.tophotels.ru.<br>
                                4.13.Коммерческому пользователю не разрешается размещать ссылки на внутренние страницы
                                www.tophotels.ru, в том числе спецссылки с окончанием «?_mode —» вне зависимости от цели
                                их размещения. <br>
                                4.14.Коммерческому пользователю не разрешается использовать никакие из торговых марок,
                                логотипов или торговых названий с ресурса, равно как и любую другую авторскую
                                информацию, включая графические изображения, а также любой текст, или интерфейс/дизайн
                                любой страницы или любой формы, содержащейся на странице Сайта без получения
                                предварительного письменного соглашения Администратора сайта.</p>
                            <p class="about-project-text"><strong>5.Материалы, передаваемые (размещаемые)
                                    Пользователем для публикации и/или распространения посредством
                                    www.tophotels.ru</strong></p>
                            <p class="about-project-text">5.1.Пользователь гарантирует, что вся информация, размещенная
                                им, является подлинной. Ответственность за указание недостоверной, ложной, ошибочной
                                информации лежит на Пользователе.<br>
                                5.2.Пользователь несет ответственность за законность, соответствие реальному положению
                                дел, соответствие контексту, оригинальность и авторство любого из размещаемых им
                                материалов. <br>
                                5.3.Модератор имеет право вносить корректировки в комментарии и отзывы с ошибками или
                                ненормативной лексикой. Комментарии и отзывы, содержащие рекламу или любые другие
                                предложения коммерческого характера, будут удаляться с сайта. Активные или неактивные
                                ссылки, используемые в комментариях, в большинстве случаев будут вырезаны.
                                Администратор/модератор проекта вправе удалять отзывы/комментарии/фото, загруженные
                                пользователями без объяснения причин.<br>
                                5.4.Правообладатель сайта www.tophotels.ru не распространяет свои авторские права на
                                материалы, доступные на ресурсе (включая фотографии и графические элементы), публикуемые
                                Пользователем. Однако, публикуя такие материалы на ресурсе Пользователь передает
                                www.tophotels.ru международную, неэксклюзивную и безвозмездную лицензию (разрешение) на
                                использование, распространение, адаптацию и публикацию данных материалов с целью
                                описания и рекламы описываемого отеля или услуги. Срок действия разрешения
                                заканчивается, когда Пользователь, либо администрация www.tophotels.ru убирает данные
                                материалы со страниц сайта. <br>
                                5.5.Администрация ресурса не несёт ответственности за корректность представленной в
                                отзывах и комментариях информации. www.tophotels.ru не обеспечивает контроль материалов,
                                публикуемых Пользователями на ресурсе, и, вследствие этого, не гарантирует точность,
                                целостность или качество данных материалов. Пользователь самостоятельно должен оценивать
                                потенциальный риск и нести полную ответственность за использование любых материалов,
                                включая уверенность в их точности, полноте и полезности. <br>
                                5.6.Администраторы могут просматривать, либо не просматривать материалы перед их
                                публикацией. Представители www.tophotels.ru имеют право (но не обязанность) отслеживать,
                                отклонять или переносить любые материалы, доступные с помощью Сервиса. <br>
                                5.7.Пользователям ЗАПРЕЩЕНО размещать на ресурсе любые материалы, распространение
                                которых запрещено действующим законодательством Российской Федерации и/или нормами
                                международного права. Пользователь несет ответственность за несоответствие содержания
                                рекламно-информационных материалов, действующему законодательству РФ, в том числе,
                                нормам федеральных законов «О рекламе», «О средствах массовой информации», «Об авторском
                                праве и смежных правах», «О товарных знаках, знаках обслуживания и наименованиях мест
                                происхождения товаров». Пользователь гарантирует, что публикуемые им материалы не
                                являются ненадлежащей рекламой, а также не нарушают неприкосновенность частной жизни,
                                личной и семейной тайны, других охраняемых законом прав и интересов третьих лиц.</p>
                            <p class="about-project-text"><strong>6.Ограничение ответственности</strong>
                            </p>
                            <p class="about-project-text">6.1.Администраторы сайта прилагают все надлежащие усилия по
                                обеспечению корректности всей информации, размещенной на Сайте. Вместе с тем не
                                гарантируют абсолютную точность, полноту или достоверность информации, содержащейся на
                                Сайте, не отвечают за неточности, возможные ошибки или другие недостатки в размещаемой
                                информации. <br>
                                6.2.Оценка качества размещенной на Сайте информации, ее актуальности, полноты и
                                применимости - в ведении и компетенции Пользователя. <br>
                                6.3.www.tophotels.ru не предоставляет никаких гарантий. Информация и услуги,
                                предлагаемые на сайте, могут быть неточными, так как большинство данной информации
                                предоставляется непосредственно поставщиками услуг. <br>
                                6.4.Администраторы не гарантируют, что: <br>
                                - сервис будет соответствовать вашим требованиям;<br>
                                - результаты, полученные в процессе пользования сервисом, будут точными или
                                достоверными; <br>
                                - качество любых услуг, информации, или других материалов, приобретаемых вами с помощью
                                ресурса, будут соответствовать вашим требованиям. <br>
                                6.5.Рейтинги отелей, отражаемые на данном сайте, могут быть использованы только в
                                качестве общих рекомендаций.<br>
                                6.6. Администраторы www.tophotels.ru и/или работающие с ним третьи лица могут вносить
                                изменения в информацию на данном сайте в любое время.<br>
                                6.7.Партнеры www.tophotels.ru, включая, без ограничений, отели, туристические агентства
                                и туристических операторов, предоставляющие туристические или какие-либо другие услуги
                                посредством сервиса www.tophotels.ru не являются агентами или представителями
                                www.tophotels.ru.<br>
                                6.8. www.tophotels.ru не несет ответственность за действия, ошибки, обещания, гарантии
                                своих партнеров или третьих лиц, размещающих информацию на ресурсе, а также за нарушения
                                или несоблюдения ими договоров, равно как и за любой материальный, моральный прямой или
                                косвенный ущерб, или любые другие потери, возникающие вследствие вышеуказанного. <br>
                                6.9.Администраторы сайта не могут нести ответственность за любой прямой, косвенный
                                убыток, связанный с использованием данного сайта, или с задержкой или невозможностью его
                                использования, а также за любую информацию, продукты и услуги, приобретенные посредством
                                данного сайта, или другим способом полученные с его помощью. <br>
                                6.10.Данный сайт содержит гиперссылки на Интернет-ресурсы, управляемые лицами, не
                                связанными с www.tophotels.ru. Эти гиперссылки публикуются исключительно в
                                информационных и ознакомительных целях. Администратор не контролирует эти
                                Интернет-ресурсы и не несет ответственности за их содержимое и использование данного
                                содержимого Пользователями. <br>
                                6.11.Пользователь несет ответственность по искам и претензиям третьих лиц к
                                администраторам сайта и лично Пользователю за нарушения, вызванные размещением им
                                информационных материалов.<br>
                                6.12.Администраторы ресурса не несут ответственности за временные технические сбои и
                                перерывы в предоставлении услуг, за временные сбои и перерывы в работе линий связи, иные
                                аналогичные сбои, а также за неполадки компьютера, с которого Пользователь осуществляет
                                выход в Интернет.</p>
                            <p class="about-project-text"><strong>7.Разрешение споров и применяемая
                                    правовая норма</strong></p>
                            <p class="about-project-text">7.1.В случае публикации материалов, содержащихся на страницах
                                сайта, без соблюдения условий изложенных в настоящем Соглашении, администраторы
                                оставляют за собой право на защиту своих нарушенных прав в соответствии с действующим
                                гражданским законодательством и законодательством об авторском праве и смежных
                                правах.<br>
                                7.2.При обнаружении фактов нарушения условий настоящего Соглашения Администратор
                                отправляет «нарушителю» досудебное уведомление с требованием устранить выявленные
                                нарушения в установленный срок. При неисполнении указанных требований защита нарушенных
                                прав и взыскание причиненных убытков производится в судебном порядке по месту
                                регистрации правообладателя Сайта www.tophotels.ru<br>
                                7.3.Любые судебные процессы по данному Соглашению будут проводиться в Российской
                                Федерации в г. Москве, в соответствии с подсудностью судов судебной системы в РФ и
                                условиями настоящего Соглашения.</p>
                            <p class="about-project-text"><strong>8.Заключительные положения</strong></p>
                            <p class="about-project-text">8.1.Если Вы не согласны с Условиями пользования, или
                                какой-либо их частью, пожалуйста, воздержитесь от использования ресурса
                                www.tophotels.ru.&nbsp;<br>
                                <br>
                                Администраторы ресурса<br>
                                www.tophotels.ru<span id="ctrlcopy"><br><br>Читать полностью на&nbsp;<a href="https://www.tophotels.ru/about/agreement">https://www.tophotels.ru/about/agreement</a></span>
                            </p></div>


                    </div>
                </div>


                <div class="panel" id="confidentialityPanel" style="display: none;">
                    <div class="agreement-pp__role-site">

                        <div class="roles-wrapper">
                            <p>Сайт www.tophotels.ru серьезно относится к вопросам защиты Вашей конфиденциальности и с удовольствием
                                представляет Вам эту Политику, чтобы проинформировать Вас о мерах, принимаемых нами в процессе
                                сбора, использования и охраны персональной информации о наших посетителях и зарегистрированных
                                пользователях нашего сайта. Персональная информация – информация, способная служить для
                                идентификации человека, например: Ваше имя, адрес e-mail, номер телефона, почтовый адрес и т.д.

                                Используя данный сайт, Вы соглашаетесь со следующими условиями:
                            </p>
                            <p><strong>2. ИСПОЛЬЗОВАНИЕ ИНФОРМАЦИИ</strong></p>
                            <p>Сайт <a href="#"> www.tophotels.ru </a> использует Вашу персональную информацию в следующих целях:

                            </p><p class="mb5"> • чтобы подтвердить Ваше право на доступ к определенным функциям сайта;</p>
                            <p class="mb5"> • чтобы осуществить Ваш запрос продуктов или услуг;</p>
                            <p class="mb5"> • чтобы персонализировать и модифицировать содержимое сайта и доступные предложения
                                согласно Вашим запросам;</p>
                            <p class="mb5"> • для контакта с Вами, например, если Вы подписаны на нашу рассылку;</p>
                            <p class="mb10"> • для улучшения предоставляемого нами сервиса;</p>
                            <p> • для составления отчетов.

                            </p>


                            <p><strong class="uppercase">3. Раскрытие информации</strong></p>
                            <p>Сайт <a href="#">www.tophotels.ru</a> не дает в аренду, не продает и не делится Вашей персональной
                                информацией с
                                другими людьми и компаниями, кроме случаев (1) когда это необходимо для предоставления Вам продуктов
                                и услуг, заказанных Вами, включая, без ограничений, продукты и услуги от третьих лиц, (2) когда у
                                нас есть соответствующее разрешение от Вас, (3) когда действуют следующие условия: </p>
                            <p class="mb5">
                                • Сайт <a href="#">www.tophotels.ru</a> может пользоваться услугами третьих лиц, помогающих в
                                осуществлении доступа
                                к нашим продуктам и услугам, и может передавать персональную информацию этим лицам, заключившим с
                                нами контракт об обеспечении конфиденциальности Вашей информации, разрешающий лицу использовать эту
                                информацию только в целях, оговоренных в контракте;</p>
                            <p class="mb5"> • при вызове в судебные инстанции, по решению суда, а также в целях сохранения наших
                                законных прав и защиты от судебных исков;</p>
                            <p class="mb5"> • когда мы считаем, что передача информации может поспособствовать расследованию,
                                воспрепятствовать или принять меры относительно незаконной деятельности, при подозрении в
                                мошенничестве, в ситуациях, подразумевающих угрозу физической безопасности человека, при нарушениях
                                Соглашения об условиях пользования ресурсом cайта <a href="#">www.tophotels.ru</a> или когда
                                передача этой
                                информации требуется по закону;</p>
                            <p class="mb10"> • мы можем передать информацию о Вас третьим лицам в том случае, если сайт
                                <a href="#">www.tophotels.ru</a> будет приобретен или станет частью другой компании. В этом случае,
                                сайт
                                <a href="#">www.tophotels.ru</a> пришлет Вам соответствующее уведомление на адрес e-mail, указанный
                                в вашем профиле
                                на сайте <a href="#">www.tophotels.ru</a> , прежде чем другая Политика конфиденциальности вступит в
                                силу по отношению
                                к Вашей персональной информации.</p>


                            <p><strong class="uppercase"> 4. Файлы сookies</strong>
                            </p>
                            <p>Сайт <a href="#">Сайт </a><a href="#">www.tophotels.ru </a> оставляет файлы cookies на Вашем компьютере и
                                имеет доступ к ним. Файл cookie представляет собой небольшой объем информации, который серверы
                                сайта www.tophotels.ru переносят к Вам в браузер, и который может быть прочитан только серверами
                                сайта www.tophotels.ru. Когда Вы посещаете сайт, файл cookie сохраняет особые данные,
                                позволяющие ускорить процесс пользования сайтом. Вы можете деактивировать файлы cookies или
                                удалить их из своего браузера в секции «Настройки конфиденциальности» или «Безопасность». Однако
                                функция cookies должна быть активирована для просмотра некоторых секций сайта www.tophotels.ru.
                                Сайт www.tophotels.ru может позволить другим компаниям, публикующим свою рекламу на наших
                                страницах, оставлять свои файлы cookies на Вашем компьютере и иметь доступ к ним. Использование
                                файлов cookies другими компаниями определяется их политикой конфиденциальности, а не политикой
                                конфиденциальности сайта www.tophotels.ru. Другие компании не могут получить доступ к файлам
                                cookies сайта www.tophotels.ru.Сайт www.tophotels.ru оставляет файлы cookies на Вашем компьютере
                                и имеет доступ к ним. Файл cookie представляет собой небольшой объем информации, который серверы
                                сайта www.tophotels.ru переносят к Вам в браузер, и который может быть прочитан только серверами
                                сайта www.tophotels.ru. Когда Вы посещаете сайт, файл cookie сохраняет особые данные,
                                позволяющие ускорить процесс пользования сайтом. Вы можете деактивировать файлы cookies или
                                удалить их из своего браузера в секции «Настройки конфиденциальности» или «Безопасность». Однако
                                функция cookies должна быть активирована для просмотра некоторых секций сайта www.tophotels.ru.
                                Сайт www.tophotels.ru может позволить другим компаниям, публикующим свою рекламу на наших
                                страницах, оставлять свои файлы cookies на Вашем компьютере и иметь доступ к ним. Использование
                                файлов cookies другими компаниями определяется их политикой конфиденциальности, а не политикой
                                конфиденциальности сайта www.tophotels.ru. Другие компании не могут получить доступ к файлам
                                cookies сайта www.tophotels.ru.Сайт www.tophotels.ru оставляет файлы cookies на Вашем компьютере
                                и имеет доступ к ним. Файл cookie представляет собой небольшой объем информации, который серверы
                                сайта www.tophotels.ru переносят к Вам в браузер, и который может быть прочитан только серверами
                                сайта www.tophotels.ru. Когда Вы посещаете сайт, файл cookie сохраняет особые данные,
                                позволяющие ускорить процесс пользования сайтом. Вы можете деактивировать файлы cookies или
                                удалить их из своего браузера в секции «Настройки конфиденциальности» или «Безопасность». Однако
                                функция cookies должна быть активирована для просмотра некоторых секций сайта www.tophotels.ru.
                                Сайт www.tophotels.ru может позволить другим компаниям, публикующим свою рекламу на наших
                                страницах, оставлять свои файлы cookies на Вашем компьютере и иметь доступ к ним. Использование
                                файлов cookies другими компаниями определяется их политикой конфиденциальности, а не политикой
                                конфиденциальности сайта www.tophotels.ru. Другие компании не могут получить доступ к файлам
                                cookies сайта www.tophotels.ru.www.tophotels.ru  оставляет файлы cookies на Вашем компьютере
                                и имеет доступ к ним. Файл cookie
                                представляет собой небольшой объем информации, который серверы сайта <a href="#">www.tophotels.ru </a> переносят к
                                Вам в браузер, и который может быть прочитан только серверами сайта. Когда Вы
                                посещаете сайт, файл cookie сохраняет особые данные, позволяющие ускорить процесс пользования
                                сайтом. Вы можете деактивировать файлы cookies или удалить их из своего браузера в секции «Настройки
                                конфиденциальности» или «Безопасность». Однако функция cookies должна быть активирована для
                                просмотра некоторых секций сайта <a href="#">www.tophotels.ru </a> . Сайт <a href="#">www.tophotels.ru </a>
                                может позволить другим
                                компаниям, публикующим свою рекламу на наших страницах, оставлять свои файлы cookies на Вашем
                                компьютере и иметь доступ к ним. Использование файлов cookies другими компаниями определяется их
                                политикой конфиденциальности, а не политикой конфиденциальности сайта <a href="#">www.tophotels.ru </a> . Другие
                                компании не могут получить доступ к файлам cookies сайта <a href="#">www.tophotels.ru </a> .

                            </p>


                            <p><strong class="uppercase">5. Ссылки на третьи сайты</strong>
                            </p>
                            <p>Сайт <a href="#">www.tophotels.ru </a> предоставляет ссылки на третьи сайты и может информировать
                                пользователей о
                                продуктах и услугах третьих лиц. Если Вы принимаете решение посетить третий сайт или воспользоваться
                                предлагаемыми на нем продуктами или услугами, помните, что данная Политика конфиденциальности не
                                будет считаться действительной по отношению к предпринимаемым Вами действиям и информации,
                                предоставляемой Вами третьему лицу. Мы настоятельно рекомендуем Вам прочесть Политику
                                конфиденциальности на посещаемом Вами ресурсе.

                            </p>

                            <p><strong class="uppercase">6. Конфиденциальность и безопасность</strong>
                            </p>
                            <p>Мы предоставляем Вашу персональную информацию только тем работникам нашей компании, которые
                                действительно нуждаются в ней для предоставления Вам продуктов или услуг и для выполнения своих
                                непосредственных рабочих задач. Сайт www.tophotels.ru предпринимает процессуальные и технические
                                меры для того, чтобы предотвратить потерю, неправомерное использование Вашей персональной
                                информации, а также несанкционированный доступ к ней и ее распространение. Мы прикладываем
                                максимальные усилия для хранения Вашей информации в безопасной среде, недоступной посторонним.

                            </p>


                            <p><strong class="uppercase">7. Обмен информацией между пользователями сайта www.tophotels.ru</strong>
                            </p>
                            <p>Если Вы включаете персональную информацию в свои комментарии на сайте, открытые текстовые поля или в
                                другие секции сайта, предназначенные для публичного просмотра, другие пользователи смогут
                                просматривать эту информацию и пользоваться ей. Мы не рекомендуем публикацию вашего адреса e-mail и
                                другой персональной информации таким путем, если Вы хотите избежать нежелательных контактов.

                                Чтобы обеспечить Вашу конфиденциальность, сайт www.tophotels.ru не показывает Ваш адрес e-mail или
                                контактную информацию другим пользователям, кроме тех случаев, когда Вы лично запрашиваете обратное.

                            </p>

                            <p><strong class="uppercase">8. Доступ, просмотр и изменение Вашей персональной информации</strong>
                            </p>
                            <p>
                            </p><p class="mb20">Мы предлагаем Вам возможность получать доступ к определенной информации, просматривать и
                                изменять ее через личный кабинет.</p>

                            <p class="mb20">По Вашей просьбе мы можем деактивировать Ваш профиль и скрыть Вашу персональную
                                информацию с проекта. Вам будет направлено письмо с запросом подтверждения удаления учетной записи.
                                После получения утвердительного ответа от Вас, профиль будет деактивирован в максимально короткие
                                сроки в зависимости от Вашей активности в профиле. Мы сохраним определенную часть Вашей персональной
                                информации в наших файлах и базах данных с целью анализа и учета, а также для того, чтобы
                                предотвратить возможное мошенничество, разрешать возможные конфликты, помогать в устранении проблем,
                                помогать в каких-либо расследованиях, обеспечивать выполнение наших Правил пользования и действовать
                                в соответствии с действующим законодательством.</p>

                            <p class="mb20">Помните, что при деактивации учетной записи, Вы не сможете авторизоваться на проекте по
                                данным этой учетной записи и пользоваться некоторыми сервисами проекта. Тем не менее, Вы всегда
                                можете отправить запрос на восстановление учетной записи при помощи формы обратной связи, либо
                                создать новую учетную запись.</p>

                            <p><strong class="uppercase">9. Изменения в Политике конфиденциальности</strong>
                            </p>
                            <p>Сайт www.tophotels.ru может изменять данную Политику конфиденциальности. Мы уведомим Вас о любых
                                существенных изменениях посредством размещения уведомления на сайте.</p>

                        </div>

                    </div>


                </div>


            </div>
        </div>

    </div>
</div>
    </div>
