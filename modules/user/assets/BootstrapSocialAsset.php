<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\user\assets;

use yii\web\AssetBundle;

/**
 * AssetBundle for Bootstrap Social
 *
 * @author Winston Delos Santos <winston.los.santos@gmail.com>
 * @since 1.0
 */
class BootstrapSocialAsset extends AssetBundle
{
    # sourcePath points to the package.
    public $sourcePath = '@vendor/bower/bootstrap-social';

    # CSS file to be loaded.
    public $css = [
        'bootstrap-social.css',
    ];
    public $depends = [
        'app\modules\user\assets\FontAwesomeAsset',
    ];


}
