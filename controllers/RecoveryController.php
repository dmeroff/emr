<?php

namespace app\controllers;

use app\forms\RecoveryRequestForm;
use app\forms\RecoveryForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

/**
 * Password recovery controller.
 * 
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RecoveryController extends RestController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'accessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbFilter' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'request' => ['post'],
                    'recover' => ['put'],
                ],
            ],
        ];
    }

    /**
     * Request password recovery.
     */
    public function actionRequest()
    {
        $model = new RecoveryRequestForm();

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->sendRecoveryMessage()) {
            \Yii::$app->response->setStatusCode(201);
            return null;
        } elseif ($model->hasErrors()) {
            \Yii::$app->response->setStatusCode(422);
            return ['errors' => $model->getErrors()];
        } else {
            throw new ServerErrorHttpException('Failed to send recovery code');
        }
    }

    /**
     * Recovers user's password.
     */
    public function actionRecover()
    {
        $model = new RecoveryForm();

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->recoverPassword()) {
            \Yii::$app->response->setStatusCode(204);
            return null;
        } elseif ($model->hasErrors()) {
            \Yii::$app->response->setStatusCode(422);
            return ['errors' => $model->getErrors()];
        } else {
            throw new ServerErrorHttpException('Failed to recover password');
        }
    }
}