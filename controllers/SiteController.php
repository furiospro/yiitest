<?php

namespace app\controllers;

use app\models\CoursesHelper;
use app\models\SignUpForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public $layout = 'main';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
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
        if (!Yii::$app->getUser()->isGuest) {
            $model = new CoursesHelper();
            $courses = $model->getCourses();
        }

        return $this->render('index', ['courses' => $courses ?? []]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
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

    public function actionSignup()
    {
        $model = new SignUpForm();

        if ($model->load(Yii::$app->request->post()) && $model->signUp()) {
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionView()
    {
        $model = new CoursesHelper();
        $model = $model->getCourseById();
        if ($model) {
            return $this->render('course', [
                'model' => $model,
            ]);
        }
        return false;
    }

    public function actionFinishcourse()
    {
        $course = new CoursesHelper();
        if ($course->load(Yii::$app->request->post()) && $course->setFinishCourse()) {
            return $this->goHome();
        }
        return json_encode(['res' => false]);
    }

    public function actionAddcourse()
    {
        $course = new CoursesHelper();
        if ($course->load(Yii::$app->request->post()) && $course->addCourse()) {
            return json_encode(['res' => 1]);
        }
        return json_encode(['res' => false]);
    }
}
