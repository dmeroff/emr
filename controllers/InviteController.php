<?php

namespace app\controllers;

use app\models\UserInvite;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\VerbFilter;

/**
 * Controller for managing invites.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class InviteController extends RestController
{
    /**
     * @inheritdoc
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
                    'create' => ['post'],
                    'delete' => ['delete'],
                ],
            ],
        ];
    }

    /**
     * Creates new user invite.
     */
    public function actionCreate()
    {
        $model = new UserInvite([
            'referrer_id' => \Yii::$app->user->id,
        ]);

        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->create()) {
            \Yii::$app->response->setStatusCode(201);
            \Yii::$app->response->getHeaders()->set('Location', Url::to(['view', 'id' => $model->id], true));

            return $model->code;
        } elseif ($model->hasErrors()) {
            \Yii::$app->response->setStatusCode(422);
            return ['errors' => $model->getErrors()];
        } else {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
    }

    /**
     * Shows all invites sent by user.
     * @return \app\models\UserInvite[]|array
     */
    public function actionIndex()
    {
        return UserInvite::find()->byReferrerId(\Yii::$app->user->id)->all();
    }

    /**
     * Shows invite information.
     * @param  int $id
     * @return UserInvite|array|null
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $invite = UserInvite::find()->byId($id)->byReferrerId(\Yii::$app->user->id)->one();

        if ($invite === null) {
            throw new NotFoundHttpException('Invite is not found');
        }

        return $invite;
    }
}
