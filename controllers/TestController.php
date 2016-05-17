<?php

namespace app\controllers;

use app\models\Test;
use app\models\User;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;

/**
 * Controller for uploading test results.
 * 
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class TestController extends RestController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class'       => CompositeAuth::class,
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
                        'roles'   => [User::ROLE_PATIENT],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['index'],
                        'roles'   => [User::ROLE_DOCTOR],
                    ],
                ],
            ],
            'verbFilter' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'index'  => ['get'],
                ],
            ],
        ];
    }

    /**
     * Creates new test model.
     */
    public function actionCreate()
    {
        $model = new Test(['patient_id' => \Yii::$app->user->identity->patient->id]);
        $model->data = \Yii::$app->getRequest()->getBodyParams();

        if ($model->save()) {
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
     * Shows all tests.
     * @param  int $id
     * @return array
     */
    public function actionIndex($id = null)
    {
        $query = Test::find()->byDoctorId(\Yii::$app->user->identity->doctor->id);
        
        if ($id !== null) {
            $query->byPatientId($id);
        }
        
        return $query->all();
    }
}