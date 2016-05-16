<?php

namespace app\controllers;

use app\models\Organization;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;


/**
 * Controller for managing organizations.
 *
 * @author Daniil Ilin <daniil.ilin@gmail.com>
 */
class OrganizationController extends RestController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class'       => CompositeAuth::class,
                'only'        => ['create', 'index', 'update', 'view'],
                'authMethods' => [
                    HttpBasicAuth::class,
                ],
            ],
            'verbFilter' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'view'   => ['get'],
                    'index'  => ['get'],
                    'update' => ['put']
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
            return null;
        } elseif ($model->hasErrors()) {
            \Yii::$app->response->setStatusCode(422);
            return ['errors' => $model->getErrors()];
        } else {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }

    /**
     * Get list organizations
     */
    public function actionIndex()
    {
        return Organization::find()->byOwnerId(\Yii::$app->user->id)->all();
    }

    /**
     * Get information about organization
     */
    public function actionView($id)
    {
        $model = Organization::find()->byId($id)->byOwnerId(\Yii::$app->user->id)->one();

        if ($model == null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }

    /**
     * Update organization
     */
    public function actionUpdate($id)
    {
        $model = Organization::find()->byId($id)->byOwnerId(\Yii::$app->user->id)->one();

        if ($model == null) {
            throw new NotFoundHttpException();
        }

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            \Yii::$app->response->setStatusCode(204);
            return null;
        } elseif ($model->hasErrors()) {
            \Yii::$app->response->setStatusCode(422);
            return ['errors' => $model->getErrors()];
        } else {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }
}