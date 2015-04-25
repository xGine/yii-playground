<?php

namespace app\widgets;

use yii\authclient\widgets\AuthChoice;
use yii\helpers\Url;
use yii\helpers\Html;


/**
* Subclass of [[yii\authclient\widgets\AuthChoice]] using Bootstrap Social Buttons
*
* @author Winston Delos Santos <winston.los.santos@gmail.com>
* @since 1.0
*/
class BootstrapSocialAuthChoice extends AuthChoice
{

    /**
     * Renders the main content, which includes all external services links.
     */
    protected function renderMainContent()
    {
        echo Html::beginTag('ul', ['class' => 'auth-clients']);
        foreach ($this->getClients() as $client) {

            $url = $this->getBaseAuthUrl();
            $url[$this->clientIdGetParamName] = $client->getId();

            echo Html::beginTag('a', ['class' => 'btn btn-block btn-social btn-' . $client->getName(),'href' => Url::to($url)]);
                echo Html::tag('i', '', ['class' => 'fa fa-' . $client->getName()]);
                echo Html::encode('Sign in with ' . $client->getTitle());
            echo Html::endTag('a');
        }
        echo Html::endTag('ul');
    }
}
