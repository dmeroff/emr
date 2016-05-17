<?php

namespace app\controllers;

use app\models\Biosignal;
use app\models\User;
use yii\web\BadRequestHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\web\UploadedFile;

/**
 * Biosignal controller.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class BiosignalController extends RestController
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
     * Creates new biosignal model
     */
    public function actionCreate()
    {
        $model = new Biosignal();
        $file  = UploadedFile::getInstanceByName('data');
        
        if (!($file instanceof UploadedFile)) {
            throw new BadRequestHttpException();
        }
        
        $model->data = file_get_contents($file->tempName);

        if ($model->save()) {
            \Yii::$app->response->setStatusCode(201);
            return null;
        } else {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }
}