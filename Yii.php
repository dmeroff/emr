<?php

/**
 * Этот файл используется для корректного автокомплита наших компонентов.
 * Для использования исключите файл "vendor/yiisoft/yii2/Yii.php" из индекса вашей IDE.
 */

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap  = include(__DIR__ . '/vendor/yiisoft/yii2/classes.php');
Yii::$container = new yii\di\Container;

/**
 * Class BaseApplication
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 *
 * @property app\components\User $user
 */
class WebApplication extends yii\web\Application
{
}

/**
 * Class ConsoleApplication
 */
class ConsoleApplication extends yii\console\Application
{
}