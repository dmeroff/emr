<?php

namespace app\controllers;

use app\models\User;
use yii\helpers\Url;
use yii\web\ServerErrorHttpException;

/**
 * Controller for managing users.
 * 
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class UserController extends RestController
{
    /**
     * Creates new user.
     */
    public function actionCreate()
    {
        $model = new User();

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->register()) {
            \Yii::$app->response->setStatusCode(201);
            \Yii::$app->response->getHeaders()->set('Location', Url::to(['view', 'id' => $model->id], true));

            return $model->authToken;
        } elseif ($model->hasErrors()) {
            \Yii::$app->response->setStatusCode(422);
            return ['errors' => $model->getErrors()];
        } else {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }
}