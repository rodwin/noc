<?php

class SiteController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow readers only access to the view file
                'actions' => array('index', 'logout'),
                'users' => array('@')),
            array('allow',
                'actions' => array('login', 'error'),
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('abi'),
                'expression' => "Yii::app()->user->checkAccess('ABI Dashboard', array('company_id' => Yii::app()->user->company_id))",
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        /*
          // Create the Transport
          $transport = Swift_SmtpTransport::newInstance('ssl://email-smtp.us-east-1.amazonaws.com', 465)
          ->setUsername('AKIAIX2XWIYNE6EGEEQA')
          ->setPassword('AsO1fJO35g1IvtbOUjhsQqK+daLBPzHxm/vWVkUS8vPu');

          // Create the Mailer using your created Transport
          $mailer = Swift_Mailer::newInstance($transport);

          // Create a message
          $message = Swift_Message::newInstance('test')
          ->setFrom(array('bbadmin@vitalink.com.ph' => 'bbadmin@vitalink.com.ph'))
          ->setTo(array('rblising@vitalink.com.ph' => 'rblising@vitalink.com.ph'))
          ->setBody(
          'test',
          'text/plain'
          );


          try{
          $mailer->send($message);
          }catch(Swift_TransportException $ex){
          echo $ex->getMessage().PHP_EOL;
          }  catch (Exception $ex){
          echo $ex->getMessage().PHP_EOL;
          }
         */

//            pre(Globals::generateV4UUID()->tostring());
        /*
          $companyObj = Company::model()->findByAttributes(array('code'=>'vlink'));
          $data = array(
          'user_id'=>  Globals::generateV4UUID(),
          'company_id'=>  $companyObj->company_id,
          'user_type_id'=>'none',
          'user_name'=>'rodwin1',
          'password'=>'winrod1',
          'status'=>'1',
          'first_name'=>'rodwin1',
          'last_name'=>'lising1',
          'email'=>'rblising@vitalink.com.ph',
          'created_by'=>'rodwin',
          );

          $model = new User();
          $model->attributes = $data;
          if($model->validate()){
          $model->save();
          }else{
          pre($model->getErrors());
          }
         */

//            pr(Yii::app()->securityManager->encrypt('rodwin'));
//            pr(sha1('rodwin'));
        /*
          $var = 'helloWorld';
          echo 'NoT ENCRYPTED: '. $var . '<br />';

          $var = Yii::app()->securityManager->encrypt($var);
          echo 'ENCRYPTED: '. $var . '<br />';
          //
          $var = Yii::app()->securityManager->decrypt($var);

          echo 'DeCRYPTED: '. $var . '<br /><br /><br />';
         */
//            $pass = 'winrod';
//            $hash = CPasswordHelper::hashPassword($pass);
//            pr($hash);
//            
//            
//            
//            if (CPasswordHelper::verifyPassword($pass, $hash)){
//                pr('pasok');
//            }else{
//                pr('no');
//            }
//            exit;
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->pageTitle = 'Welcome to ' . CHtml::encode(Yii::app()->name);
//            pre(Yii::app()->user->name);
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $this->layout = 'login';
        $model = new LoginForm();

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(Yii::app()->user->returnUrl);
//                                $this->redirect(array('site/index'));
//                $this->redirect(array(Yii::app()->params['company_modules'][Yii::app()->user->company_id]['dashboard']));
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        $assigned_roles = Yii::app()->authManager->getRoles(Yii::app()->user->id); //obtains all assigned roles for this user id
        if (!empty($assigned_roles)) { //checks that there are assigned roles
            $auth = Yii::app()->authManager; //initializes the authManager
            foreach ($assigned_roles as $n => $role) {
                if ($auth->revoke($n, Yii::app()->user->id)) //remove each assigned role for this user
                    Yii::app()->authManager->save(); //again always save the result
            }
        }
        
        Yii::app()->user->logout();
        Yii::app()->session->clear();
        Yii::app()->session->destroy();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionABI() {

        $this->pageTitle = 'Dashboard';

        $brand_category = CHtml::listData(BrandCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'brand_category_id', 'category_name');

        $this->render('dashboard_abi', array(
            'brand_category' => $brand_category,
        ));
    }

}
