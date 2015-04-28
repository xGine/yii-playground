<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ContactForm;
use app\models\User;

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
        
        if(isset($session['fuid'])){
            $uid = $session['fuid'];
        }
        else if(isset($session['yuid'])){
            $uid = $session['yuid'];
        }
        else{//do nothing
        }

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
        $session['fuid'] = $attributes['id'];
        
        //file_put_contents("facebook_attributes.txt", $attributes);
    }

    public function actionLogin()
    {
    //Yahoo login controller
        $serviceName = Yii::$app->getRequest()->getQueryParam('service');
        if (isset($serviceName)) {
            /** @var $eauth \nodge\eauth\ServiceBase */
            $eauth = Yii::$app->get('eauth')->getIdentity($serviceName);
            $eauth->setRedirectUrl(Yii::$app->getUser()->getReturnUrl());
            $eauth->setCancelUrl(Yii::$app->getUrlManager()->createAbsoluteUrl('site/login'));

            try {
                if ($eauth->authenticate()) {
                //var_dump($eauth->getIsAuthenticated(), $eauth->getAttributes()); exit;

                    $identity = User::findByEAuth($eauth);
                    Yii::$app->getUser()->login($identity);

                     $session = Yii::$app->session;       
                     $session['yuid'] = $identity;

                     //$session['yfname'] = $eauth->openid_ax_value_fullname;

                    // special redirect with closing popup window
                    $eauth->redirect();
                }
                else {
                    // close popup window and redirect to cancelUrl
                    $eauth->cancel();
                }
            }
            catch (\nodge\eauth\ErrorException $e) {
                // save error to show it later
                Yii::$app->getSession()->setFlash('error', 'EAuthException: '.$e->getMessage());

                // close popup window and redirect to cancelUrl
                //$eauth->cancel();
                $eauth->redirect($eauth->getCancelUrl());
            }

            $model = new LoginForm();
            if ($model->load($_POST) && $model->login()) {
                    return $this->goBack();
            }
             else {
                    return $this->render('login', array(
                            'model' => $model,
                ));
            }
        }
    //end of yahoo login controller
    }

    //Yahoo 
    public function behaviors() {

            return array(
                'eauth' => array(
                    // required to disable csrf validation on OpenID requests
                    'class' => \nodge\eauth\openid\ControllerBehavior::className(),
                    'only' => array('login'),
                ),
            );
        }
    //Yahoo
}
