<?php

namespace app\controllers;

use app\forms\LoginForm;
use app\models\UserToken;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

/**
 * Controller for managing auth tokens.
 * 
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class TokenController extends RestController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class'       => CompositeAuth::class,
                'only'        => ['delete'],
                'authMethods' => [
                    HttpBasicAuth::class,
                ],
            ],
            'accessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['create'],
                        'roles'   => ['?'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['delete'],
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbFilter' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['delete'],
                ],
            ],
        ];
    }

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

    /**
     * Deletes current user auth token.
     */
    public function actionDelete()
    {
        \Yii::$app->response->setStatusCode(204);

        UserToken::deleteAll([
            'user_id' => \Yii::$app->user->id,
            'code'    => \Yii::$app->request->getAuthUser(),
        ]);
    }
}