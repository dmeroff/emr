<?php

namespace app\controllers;

use app\models\Organization;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\ServerErrorHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\data\ActiveDataProvider;

class OrganizationController extends RestController
{

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class'       => CompositeAuth::class,
                'only'        => ['create', 'view'],
                'authMethods' => [
                    HttpBasicAuth::class,
                ],
            ],
            'verbFilter' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'view'   => ['view'],
                ],
            ],
        ];
    }

    /**
     * Creates new organization.
     */
    public function actionCreate()
    {
        $model = new Organization();

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->create()) {
            \Yii::$app->response->setStatusCode(201);
            //\Yii::$app->response->getHeaders()->set('Location', Url::to(['view', 'address' => $model->address], true));

        } elseif ($model->hasErrors()) {
            \Yii::$app->response->setStatusCode(422);
            return ['errors' => $model->getErrors()];
        } else {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }

    /**
     * Get information about organization
     */
    public function actionView()
    {
        $model = Organization::find()->byOwnerId(\Yii::$app->user->id)->one();

        return $model;

    }
}