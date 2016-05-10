<?php

namespace app\controllers;

use yii\web\Controller;

/**
 * Base abstract class for rest controllers.
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
abstract class RestController extends Controller
{
    /**
     * @var bool
     */
    public $enableCsrfValidation = false;
}
