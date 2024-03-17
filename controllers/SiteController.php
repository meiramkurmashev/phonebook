<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Records;
use yii\data\Pagination;
use app\models\Record;
use yii\data\Sort;
use yii\data\ActiveDataProvider;
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */

     public function actionRecords()
    {
        $sort = new Sort([
        'attributes' => [

            'fio' => [
                'asc' => ['fio' => SORT_ASC],
                'desc' => ['fio' => SORT_DESC],
                'default' => SORT_DESC,
                'label' => 'Сортировать',
            ],
        ],
    ]);
        $records = Records::find()->orderBy($sort->orders);

        $pagination = new Pagination([
            'defaultPageSize' => 4,
            'totalCount' => $records->count(),
        ]);

        $records = $records->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('records', [
            'sort' => $sort,
            'records' => $records,
            'pagination' => $pagination

        ]);
    }
      public function actionEdit($id)
    {
        $model = Records::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()){

            return $this->redirect(['records']);
        }
         return $this->render('edit', [
            'model'=>$model,
            ]);

}

    public function actionAdd()
    {
        $model = new Records();
        if ($model->load(Yii::$app->request->post()) && $model->save()){

            return $this->redirect(['records']);
        }
         return $this->render('edit', [
            'model'=>$model,
            ]);

    }


    public function actionDelete($id)
    {
        $model = Records::findOne($id);
        if ($model) $model->delete();
        return $this->redirect(['records']);

    }

    /*public function actionUpdate($fio,$phone, $id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }*/

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


      public function actionEntry()
    {
        $model = new EntryForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // данные в $model удачно проверены

            // делаем что-то полезное с $model ...

            return $this->render('entry-confirm', ['model' => $model]);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('entry', ['model' => $model]);
        }
    }

}
