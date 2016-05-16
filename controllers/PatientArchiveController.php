<?php

namespace app\controllers;

use app\models\PatientArchive;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;

/**
 * Controller for managing archive patients.
 *
 * @author Daniil Ilin <daniil.ilin@gmail.com>
 */
class PatientArchiveController extends RestController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class'       => CompositeAuth::class,
                'only'        => ['index', 'view'],
                'authMethods' => [
                    HttpBasicAuth::class,
                ],
            ],
            'verbFilter' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'view'   => ['get'],
                    'index'  => ['get'],
                ],
            ],
        ];
    }

    /**
     * Get list organizations from archive
     */
    public function actionIndex()
    {
        return PatientArchive::find()->byOwnerId(\Yii::$app->user->id)->all();
    }

    /**
     * Get information about organization from archive
     */
    public function actionView($id, $revision)
    {
        $model = PatientArchive::find()->byId($id)->byOwnerId(\Yii::$app->user->id)->byRevision($revision)->all();

        if ($model == null) {
            throw new NotFoundHttpException();
        }

        return $model;
    }
}