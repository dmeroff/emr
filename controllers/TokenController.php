<?php

namespace app\controllers;

use app\forms\LoginForm;
use yii\web\ServerErrorHttpException;

/**
 * Controller for managing auth tokens.
 * 
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class TokenController extends RestController
{
    /**
     * Creates new auth token.
     */
    public function actionCreate()
    {
        $model = new LoginForm();

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->authenticate()) {
            \Yii::$app->response->setStatusCode(201);

            return $model->authToken;
        } elseif ($model->hasErrors()) {
            \Yii::$app->response->setStatusCode(422);
            return ['errors' => $model->getErrors()];
        } else {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }
}