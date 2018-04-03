<?php

namespace yii2module\encrypt\admin\controllers;

use common\enums\rbac\PermissionEnum;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii2lab\helpers\Behavior;
use yii2module\encrypt\admin\forms\CoderForm;

class CoderController extends Controller
{
	
	public function behaviors()
	{
		return [
			'access' => Behavior::access(PermissionEnum::ENCRYPT_MANAGE),
		];
	}
	
	public function actionIndex() {
		$result = null;
		$model = new CoderForm();
		if(Yii::$app->request->isPost) {
			$body = Yii::$app->request->post('CoderForm');
			$model->setAttributes($body, false);
			$model->validate();
			if(Yii::$app->request->post('submit') === CoderForm::ACTION_ENCODE) {
				$result = Yii::$domain->encrypt->coder->encode($model->text);
			} elseif(Yii::$app->request->post('submit') === CoderForm::ACTION_DECODE) {
				$result = Yii::$domain->encrypt->coder->decode($model->text);
			}
		}
		return $this->render('index', [
			'model' => $model,
			'result' => $result,
		]);
	}
	
}
