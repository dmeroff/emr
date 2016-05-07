<?php

namespace app\controllers;

use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => ErrorAction::class,
        ];
    }
}