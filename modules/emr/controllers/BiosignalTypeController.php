<?php

namespace app\modules\emr\controllers;

use app\controllers\RestController;
use yii\web\ServerErrorHttpException;
use app\modules\emr\models\BiosignalType;
use yii\filters\auth\CompositeAuth;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\user\models\User;
use yii\filters\auth\HttpBasicAuth;
use yii\web\NotFoundHttpException;

/**
 * Biosignal type controller.
 *
 * @author Daniil Ilin <daniil.ilin@gmail.com>
 */
class BiosignalTypeController extends RestController
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
                    'delete' => ['delete'],
                    'create' => ['post'],
                ],
            ],
            'accessControl' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_DOCTOR],
                    ],
                ],
            ],
        ];
    }

    /**
     * View all biosignal types
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionIndex()
    {
        return BiosignalType::find()->all();
    }

    /**
     * View biosignal type information
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = BiosignalType::find()->byId($id)->one();

        if ($model == null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }

    /**
     * Delete biosignal type
     * @param $id
     * @throws \yii\db\Exception
     */
    public function actionDelete($id)
    {
        \Yii::$app->db->createCommand()
            ->delete('biosignal_type', ['id' => $id])
            ->execute();

        \Yii::$app->response->setStatusCode(204);
    }

    /**
     * Update information about biosignal type
     * @param $id
     * @return array|null
     * @throws NotFoundHttpException
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = BiosignalType::find()->byId($id)->one();

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
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
    }

    /**
     * Create new biosignal type
     * @return array
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $model = new BiosignalType();

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->save()) {
            \Yii::$app->response->setStatusCode(201);
            return null;
        } else {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }
}