<?php

namespace app\modules\emr\controllers;

use app\modules\emr\models\BiosignalTimestamp;
use yii\filters\auth\CompositeAuth;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use app\modules\user\models\User;
use app\controllers\RestController;
use yii\web\NotFoundHttpException;

class BiosignalTimestampController extends RestController
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
                    'view'   => ['get'],
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
     * Views all timestamp by biosignal id
     * @param $biosignalId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionIndex($biosignalId)
    {
        return BiosignalTimestamp::find()->byBiosignalId($biosignalId)->all();
    }

    /**
     * View biosignaltimestamp
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = BiosignalTimestamp::find()->byId($id)->one();

        if ($model == null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}