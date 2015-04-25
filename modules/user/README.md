#Installation

#Usage

['label' => 'Login', 'url' => ['user/default/login']] :
['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
    'url' => ['user/default/logout'],
    'linkOptions' => ['data-method' => 'post']],

#AssetBundles

...
use app\modules\user\assets\BootstrapSocialAsset;

BootstrapSocialAsset::register($this);
...

#Components

'components' => [
    ...
    'user' => [
        'identityClass' => 'app\modules\user\models\User',
        'enableAutoLogin' => true,
    ],
    'authClientCollection' => [
      'class' => 'yii\authclient\Collection',
      'clients' => [
          'google' => [
              'class' => 'yii\authclient\clients\GoogleOAuth',
              'clientId' => 'google_client_id',
              'clientSecret' => 'google_client_secret',
          ],
          'facebook' => [
              'class' => 'yii\authclient\clients\Facebook',
              'clientId' => '1436471209996412',
              'clientSecret' => 'cbd9d6b104ad9e4de3d52fdf81d3f5bf',
              'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
          ],
      ],
    ]
    ...
]

#Modules

'modules' => [
    'user' => [
        'class' => 'app\modules\user\Module',
    ],
]
