<?php 

namespace backend\controllers;

use common\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use Yii;
// use yii\filters\VerbFilter;
// use yii\filters\AccessControl;
use yii\web\Controller;


/**
 * Auth controller
 */
class AuthController extends Controller
{

    /**
     * Login action.
     *
     * @return string|Response
     */    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup() {
        $model = new SignupForm();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->signup()) {
                return $this->redirect(['auth/login']);
            }
            
        }

        return $this->render('signup', ['model' => $model]);
    }

}

?>