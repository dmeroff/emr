<?php

namespace app\controllers;

use app\models\Patient;
use app\rbac\Permissions;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;


/**
 * Controller for managing patients.
 *
 * @author Daniil Ilin      <daniil.ilin@gmail.com>
 * @author Zykova Ekaterina <katyazkv15@mail.ru>
 * @author Dmitry Erofeev   <dmeroff@gmail.com>
 */
class PatientController extends RestController
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
            'verbFilter' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'index'  => ['get'],
                    'update' => ['put'],
                    'view'   => ['get'],
                ],
            ],
        ];
    }

    /**
     * Update patient
     * @param $id
     * @return array|null
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = Patient::find()->byId($id)->byDoctorId(\Yii::$app->user->id)->one();

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

    /**
     * Get list patients
     * @return \app\models\Patient[]|array
     */
    public function actionIndex()
    {
        return Patient::find()->all();
    }


    /**
     * Get information about patient
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function  actionView($id)
    {
        $model = Patient::find()->byId($id)->byDoctorId(\Yii::$app->user->id)->one();

        if ($model == null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}