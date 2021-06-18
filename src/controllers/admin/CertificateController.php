<?php
namespace webrise1\pdfgenerator\controllers\admin;
use webrise1\pdfgenerator\models\Certificate;
use webrise1\pdfgenerator\models\search\CertificateSearch;
use webrise1\pdfgenerator\models\TemplateCertificate;
use webrise1\pdfgenerator\models\User;
use Yii;
use kartik\mpdf\Pdf;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class CertificateController extends Controller {

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
                        'roles' => ['_ext_ADMIN'],
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

    public function actionIndex($template_certificate_id)
    {

        $template_certificate=TemplateCertificate::findOne($template_certificate_id);
        if(!$template_certificate)
            die();
        if($users=Yii::$app->request->post('users')){

            $countUser=count($users);
            $countAddUser=0;
            foreach($users as $user_id){
                $userCert=new Certificate();
                $userCert->user_id=$user_id;
                $userCert->template_certificate_id=$template_certificate->id;
                if($userCert->save())
                    $countAddUser++;
            }
//            Yii::$app->session->setFlash('success', 'Добавленно пользователей ['.$countAddUser.'/'.$countUser.']');
            $this->refresh();
        }

//        $users=ArrayHelper::map(User::find()->select('id,email')->all(),'id','email');

        if(!$template_certificate){
            return $this->redirect(Yii::$app->url->referrer);
        }
        $searchModel = new CertificateSearch();
        $dataProvider = $searchModel->search($template_certificate->id,Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'template_certificate'=>$template_certificate,
        ]);
    }
    public function actionUserList($q = null, $id = null,$template_certificate_id=null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];

        if(!$template_certificate_id)
            return false;
        if (!is_null($q)) {
            $subQuery=new Query();
            $subQuery->select('user_id')
                ->from('pdf_generator_certificate cert')
                ->where('u.id = cert.user_id AND cert.template_certificate_id='.$template_certificate_id);
            $query = new Query();
            $query->select('id, email AS text')
                ->from('user u')
                ->where(['like', 'email', $q])
                ->andWhere(['not exists', $subQuery])
                ->limit(40);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => User::findOne($id)->email];
        }
        return $out;
    }
    public function actionLoadUsersFromExcel(){
        $file=$_FILES['excel_file'];
        $template_certificate_id=Yii::$app->request->post('template_certificate_id');
        if($file && $template_certificate_id){
            $data['not_found_users']=[];
            $data['users']=[];
            $data['already_added_users']=[];
            $data['is_not_email']=[];
            $objPHPExcel = \PHPExcel_IOFactory::load($file['tmp_name']);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            foreach($sheetData as $column){
                foreach ($column as $item) {
                    if($item){
                        if (filter_var($item, FILTER_VALIDATE_EMAIL)) {
                            $user=User::findOne(['email'=>$item]);
                            if($user){
                                $user_cert=$user->getCertificate($template_certificate_id);
                                if($user_cert){
                                    $data['already_added_users'][]=$item;
                                }else{
                                    $data['users'][]=$user;
                                }
                            }else{
                                $data['not_found_users'][]=$item;
                            }
                        }else{
                            $data['is_not_email'][]=$item;
                        }
                    }
                }
            }
            return $this->render('load_users',['data'=>$data,'template_certificate_id'=>$template_certificate_id]);

        }elseif($users=Yii::$app->request->post('users')){
            $count_add_cert=0;
            $count_all_user=count($users);
            foreach($users as $user_id){
                $userCertificate=new Certificate();
                $userCertificate->user_id=$user_id;
                $userCertificate->template_certificate_id=$template_certificate_id;
                if($userCertificate->save()){
                    $count_add_cert++;
                }
            }
            Yii::$app->session->setFlash('success', 'Добавленно пользователей ['.$count_add_cert.'/'.$count_all_user.']');
            return $this->render('load_users',['template_certificate_id'=>$template_certificate_id]);
        }
    }
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $cert_id=$model->template_certificate_id;
        $model->delete();
        return $this->redirect(['/pdfgenerator/admin/certificate','template_certificate_id'=>$cert_id]);
    }
    protected function findModel($id)
    {
        if (($model = Certificate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}