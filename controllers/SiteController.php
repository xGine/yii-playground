<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ContactForm;

class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $session = Yii::$app->session;

        $uid = $session['uid'];

        return $this->render('index' , ['uid' => $uid]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function successCallback($client)
    {
        $session = Yii::$app->session;
        //client info in an array format
        $attributes =  $client->getUserAttributes();

        //converts array attri var to json format
        //$attributes = json_encode($client->getUserAttributes(), JSON_UNESCAPED_SLASHES);

        //if attributes is on json format 
        //$attributes = json_decode($attributes, true);

        //obtaining $attributes value to session vars
        $session['uid'] = $attributes['id'];
        
        //file_put_contents("facebook_attributes.txt", $attributes);
    }
}
