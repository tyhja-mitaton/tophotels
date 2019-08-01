<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\OrderForm;
use app\models\Countries;
use app\models\Resorts;
use app\models\Hotels;
use yii\helpers\Json;
use app\models\OrderComplexForm;
use app\models\OrderFormPlus;
use app\models\WriteJob;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Домашняя страница
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }


    /**
     * Отображает страницу подачи заявки
     *
     * @return Response|string
     */
    public function actionOrder()
    {
        $model = new OrderForm();
		$model2 = new OrderFormPlus();
		$cmplxf_model = new OrderComplexForm();
		$countries_model = new Countries();
		$resorts_model = new Resorts();
		$hotels_model = new Hotels();
		$model->created_at = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$model->sendMail(Yii::$app->params['adminEmail']);
			
			Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh('#form');
        }
        return $this->render('contact', [
            'model' => $model,
			'countries_model' => $countries_model,
			'resorts_model' => $resorts_model,
			'hotels_model' => $hotels_model,
			'cmplxf_model' => $cmplxf_model,
			'model2' => $model2,
        ]);
    }
	
	//обновляет связанный список с курортами
	public function actionRes()
	{
		$out = []; 
		if (isset($_POST['depdrop_parents'])) {
			$parents = $_POST['depdrop_parents'];
			if ($parents != null) {
				$cnt_id = $parents[0];  
				$out = Resorts::find()->where(['country' => $cnt_id])->orderBy("name ASC")->asArray()->all(); 
				return Json::encode(['output'=>$out, 'selected'=>'']);
			}
		}
		echo Json::encode(['output'=>'', 'selected'=>'']);
	}
	
	public function actionUploadStep1()
	{
		$model = new OrderForm();
		$model2 = new OrderFormPlus();
		$cmplxf_model = new OrderComplexForm();
		$countries_model = new Countries();
		$resorts_model = new Resorts();
		$hotels_model = new Hotels();
		if ($cmplxf_model->load(Yii::$app->request->post())) {
			$depart_city = Yii::$app->request->post('cf_depart_city');
			$nights = Yii::$app->request->post('cf_nights');
			$takeoff_range = Yii::$app->request->post('cf_takeoff_date');
			$room_manned = Yii::$app->request->post('cf_room');
			$price_limit = (Yii::$app->request->post('cf_price_limit') != '')?
			'Цена: '.Yii::$app->request->post('cf_price_limit').PHP_EOL:'';
			$hotel_params = (Yii::$app->request->post('cf_hotel_params') != '')?
			'Параметры отеля: '.Yii::$app->request->post('cf_hotel_params').PHP_EOL:'';
			$ad_wishes = (Yii::$app->request->post('cf_wish') != '')?
			'Пожелания: '.Yii::$app->request->post('cf_wish').PHP_EOL:'';
			
			$country2 = (Yii::$app->request->post('cf_direction_country2') != 'не важно')? Yii::$app->request->post('cf_direction_country2'):'';
			$city2 = (Yii::$app->request->post('cf_direction_city2') != 'не важно')? Yii::$app->request->post('cf_direction_city2'):'';
			$depart_city2 = Yii::$app->request->post('cf_depart_city2');
			$hotel_params2 = (Yii::$app->request->post('cf_hotel_params2') != '')?
			'Параметры отеля: '.Yii::$app->request->post('cf_hotel_params2').PHP_EOL:'';
			
			$ad_dir1 = ($country2.$city2 != '')? $country2.', '.$city2.PHP_EOL.'Город вылета: '.$depart_city2.PHP_EOL.$hotel_params2:'';
			$ad_direction1 = ($ad_dir1 != '')? PHP_EOL.PHP_EOL.'Доп. направление 1:'.PHP_EOL.$ad_dir1:'';
			
			$country3 = (Yii::$app->request->post('cf_direction_country3') != 'не важно')? Yii::$app->request->post('cf_direction_country3'):'';
			$city3 = (Yii::$app->request->post('cf_direction_city3') != 'не важно')? Yii::$app->request->post('cf_direction_city3'):'';
			$depart_city3 = Yii::$app->request->post('cf_depart_city3');
			$hotel_params3 = (Yii::$app->request->post('cf_hotel_params3') != '')?
			'Параметры отеля: '.Yii::$app->request->post('cf_hotel_params3').PHP_EOL:'';
			
			$ad_dir2 = ($country3.$city3 != '')? $country3.', '.$city3.PHP_EOL.'Город вылета: '.$depart_city3.PHP_EOL.$hotel_params3:'';
			$ad_direction2 = ($ad_dir2 != '')? PHP_EOL.PHP_EOL.'Доп. направление 2:'.PHP_EOL.$ad_dir2:'';
			
			$dep_city_h = Yii::$app->request->post('cf_depart_city_h');
			$depart_city = ($dep_city_h != 'без перелёта')? $dep_city_h :$depart_city;
			$food_h = (Yii::$app->request->post('cf_food_h') != 'любое')? 'Питание: '.Yii::$app->request->post('cf_food_h').PHP_EOL:'';
			$hotels2 = (Yii::$app->request->post('cf_hotels2') != '')? PHP_EOL.'Доп. отель 1: '.Yii::$app->request->post('cf_hotels2'):'';
			$hotels3 = (Yii::$app->request->post('cf_hotels3') != '')? PHP_EOL.'Доп. отель 2: '.Yii::$app->request->post('cf_hotels3'):'';
			
			$cmplxf_model->created_at = date('Y-m-d H:i:s');
			$cmplxf_model->direction = Yii::$app->request->post('cf_direction_country').', '.
			Yii::$app->request->post('cf_direction_city').PHP_EOL.Yii::$app->request->post('cf_hotels');
			$cmplxf_model->body = 'Вылет: '.$takeoff_range.PHP_EOL.$nights.PHP_EOL.$room_manned.PHP_EOL.
			$price_limit.'Город вылета: '.$depart_city.PHP_EOL.$hotel_params.$ad_wishes.$food_h.
			$ad_direction1.$ad_direction2.$hotels2.$hotels3;
			Yii::$app->session->setFlash('orderFormStep2');
			//Yii::$app->response->format = Response::FORMAT_JSON;
			$cmplxf_model->save();
			Yii::$app->session->set('last_order', $cmplxf_model->id);
			return $this->render('contact', [
			'model' => $model,
			'model2' => $model2,
			'countries_model' => $countries_model,
			'resorts_model' => $resorts_model,
			'hotels_model' => $hotels_model,
			'cmplxf_model' => $cmplxf_model,
			]);
		}
		return $this->render('contact', [
			'model' => $model,
			'model2' => $model2,
			'countries_model' => $countries_model,
			'resorts_model' => $resorts_model,
			'hotels_model' => $hotels_model,
			'cmplxf_model' => $cmplxf_model,
        ]);
	}
	
	public function actionStep1Validate()
	{
		$cmplxf_model = new OrderComplexForm();
		$request = \Yii::$app->getRequest();
		if ($request->isPost && $cmplxf_model->load($request->post())) {
			\Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($cmplxf_model);
		}
	}
	
	public function actionGetHotels()
	{
		$out = [];
			$search_str = Yii::$app->request->post('s');
			$query = "SELECT * FROM ".Hotels::tableName()." where name ILIKE :param";
			$out = Hotels::findBySql($query, [':param' => '%'.$search_str.'%'])->orderBy("name ASC")->asArray()->all();
			$res = Resorts::find()->orderBy("id ASC")->asArray()->all();
		return Json::htmlEncode(['output'=>$out, 'resorts'=>$res]);
	}
	
	public function actionOrderStep2()
	{
		$model = new OrderForm();
		$model2 = new OrderFormPlus();
		$cmplxf_model = new OrderComplexForm();
		$countries_model = new Countries();
		$resorts_model = new Resorts();
		$hotels_model = new Hotels();
		//$ofp = new OrderFormPlus();
		$id = Yii::$app->session->get('last_order');
		$ofp = OrderFormPlus::findOne(['id'=>$id]);
		if($ofp->load(Yii::$app->request->post()) && $ofp->validate()){
			$body_data = $ofp->body;
			$ofp->body = $body_data.PHP_EOL.'Город туриста: '.Yii::$app->request->post('f_tourist_city');
			$ofp->save();
			Yii::$app->session->setFlash('orderForm2Submitted');
			//$ofp->sendMail(Yii::$app->params['adminEmail']);
			//Yii::$app->queue->listen();
			$job_id = Yii::$app->queue->push(new WriteJob([
			'text' => 'test-azaza',
			'file' => Yii::$app->basePath . '/web/file.txt'
			]));
			//Yii::$app->queue->run();//Yii::debug('zzzzzzzzzqqq');

			return $this->render('contact', [
			'model' => $model,
			'model2' => $model2,
			'countries_model' => $countries_model,
			'resorts_model' => $resorts_model,
			'hotels_model' => $hotels_model,
			'cmplxf_model' => $cmplxf_model,
			]);
		}else{
			return $this->refresh();
		}
			
		return $this->render('contact', [
			'model' => $model,
			'model2' => $model2,
			'countries_model' => $countries_model,
			'resorts_model' => $resorts_model,
			'hotels_model' => $hotels_model,
			'cmplxf_model' => $cmplxf_model,
        ]);
		
	}
}
