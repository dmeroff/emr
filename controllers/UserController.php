<?php

namespace app\controllers;

use app\models\User;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;

/**
 * Controller for managing users.
 * 
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class UserController extends RestController
{
    /**
     * @inheritdoc
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
                    ],
                ],
            ],
            'verbFilter' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * @api {post} /users Create new user
     * @apiDescription Creates new user and returns authentication token
     * @apiParam {String} email User's email
     * @apiParam {String} password User's password
     * @apiParam {String} inviteCode User's invite code
     * @apiName CreateUser
     * @apiPermission Guest
     * @apiSuccess (200) {String} Authentication token for created user
     */
    public function actionCreate()
    {
        $model = new User();

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->register()) {
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