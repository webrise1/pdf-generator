<?php
namespace webrise1\pdfgenerator\controllers\admin;
use webrise1\filemanager\models\File;
use webrise1\pdfgenerator\models\search\TemplateCertificateSearch;
use webrise1\pdfgenerator\models\TemplateCertificate;
use webrise1\pdfgenerator\models\User;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use kartik\mpdf\Pdf;
use yii\db\Query;
use yii\widgets\ActiveForm;
use yii\web\Response;
class TemplateCertificateController extends Controller {
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'actions' => ['update','create'],
                        'roles' => ['_ext_SUPERADMIN'],
                    ],
                    [
                        'allow' => false,
                        'actions' => ['update','create'],
                    ],
                    [
                        'roles' => ['_ext_ADMIN'],
                        'allow' => true,
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actionTest(){
       return $this->renderPartial('_reportView');
    }

    public function actionIndex()
    {
//        $emails=User::find()->all();
        $searchModel = new TemplateCertificateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
    {
        $model = new TemplateCertificate();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Сертификат успешно добавлен');
            return $this->redirect(['update','id'=>$model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Сертификат успешно изменен');

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionViewPdf($id,$user_id=null){
        $model = $this->findModel($id);
        if($post=Yii::$app->request->post()){
            if($content=$post['content'])
                $model->content=$content;
            if($cssInline=$post['cssInline'])
                $model->cssInline=$cssInline;
            if($cssFiles=$post['cssFiles']){
                $model->css_files=$cssFiles;
            }
            if(($width=$post['width']) && ($height=$post['height'])){

                $model->width=$width;
                $model->height=$height;
            }

            $user_id=$post['user_id'];
        }
        $user=User::findOne($user_id);
        if(!$user)
            throw new Exception('Не передан или не найден пользователь');

        return $model->getGeneratedPdf($user->id);
    }
    public function actionFileList($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, name AS text')
                ->from('filemanager_file')
                ->where(['like', 'name', $q])
                ->andWhere(['folderNS'=>'extension_pdf_generator.assets.css'])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => File::findOne($id)->name];
        }
        return $out;
    }

    protected function findModel($id)
    {
        if (($model = TemplateCertificate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}