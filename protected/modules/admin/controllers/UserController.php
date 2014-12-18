<?php

class UserController extends Controller {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    //public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'data'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'profile'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionData() {

        User::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = User::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = User::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );



        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['user_id'] = $value->user_id;
            $row['user_type_id'] = $value->user_type_id;
            $row['user_name'] = $value->user_name;
            $row['password'] = $value->password;
            $row['status'] = $value->status;
            $row['first_name'] = $value->first_name;
            $row['last_name'] = $value->last_name;
            $row['email'] = $value->email;
            $row['position'] = $value->position;
            $row['telephone'] = $value->telephone;
            $row['address'] = $value->address;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_by'] = $value->updated_by;
            $row['updated_date'] = $value->updated_date;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/admin/user/view', array('id' => $value->user_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/admin/user/update', array('id' => $value->user_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/admin/user/delete', array('id' => $value->user_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionProfile($id) {

        $this->layout = '//layouts/column1';

        $model = $this->loadModel($id);

        $this->pageTitle = 'Update Profile';

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $CompanyObj = new Company('search');
        $CompanyObj->unsetAttributes();  // clear any default values
        $companies = $CompanyObj->search();
        $listCompanies = CHtml::listData($companies->getData(), 'company_id', 'name');

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->user_id));
            }
        }

        $this->render('profile', array(
            'model' => $model,
            'listCompanies' => $listCompanies,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);

        $this->pageTitle = 'View User ' . $model->user_name;

        $this->menu = array(
            array('label' => 'Create User', 'url' => array('create')),
            array('label' => 'Update User', 'url' => array('update', 'id' => $model->user_id)),
            array('label' => 'Delete User', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->user_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage User', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $CompanyObj = new Company('search');
        $CompanyObj->unsetAttributes();  // clear any default values
        $companies = $CompanyObj->search();
        $listCompanies = CHtml::listData($companies->getData(), 'company_id', 'name');

        $this->pageTitle = 'Create User';

        $this->menu = array(
            array('label' => 'Manage User', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new User('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->user_id = Globals::generateV4UUID();
            $model->company_id = Yii::app()->user->company_id;
            unset($this->created_date);
            $model->created_by = Yii::app()->user->name;

            if ($model->save()) {

                $user = User::model()->userDetailsByID($model->user_id, $model->company_id);

                $content = ('<html>'
                        . '<body>'
                        . ''
                        . '<div>'
                        . '<p style="'
                        . "font-family: 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;"
                        . 'font-size: 14px; font-style: normal; font-variant: normal; font-weight: 500; line-height: 15.3999996185303px;'
                        . '">Good Day <b>' . ucwords($user->first_name) . " " . ucwords($user->last_name) . '</b>,</p>'
                        . '<div style="margin-left: 30px;">'
                        . '<p style="'
                        . "font-family: 'Brush Script MT', cursive; font-size: 23px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 30px;"
                        . '">Welcome to ' . Yii::app()->name . '</p>'
                        . '<p style="'
                        . "font-family: 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;"
                        . 'font-size: 14px; font-style: normal; font-variant: normal; font-weight: 500; line-height: 15.3999996185303px;'
                        . '">'
                        . '<span>Here is your User Name and Password:</span><br/><br/>'
                        . '<b>Account Name:</b>&nbsp;&nbsp;&nbsp;<i style="color: #0000FF;">' . $user->company->code . '</i><br/>'
                        . '<b>Username:</b>&nbsp;&nbsp;&nbsp;<i style="color: #0000FF;">' . $user->user_name . '</i><br/>'
                        . '<b>Password:</b>&nbsp;&nbsp;&nbsp;<i style="color: #0000FF;">' . $model->password2 . '</i><br/><br/>'
                        . '</p>'
                        . '<span>You may now <a href="' . Yii::app()->params['serverIP'] . 'index.php?r=site/login" target="_blank">login</a>.</span>'
                        . '</div>'
                        . '</div>'
                        . ''
                        . '</body>'
                        . '</html>');

                Globals::sendMail(Yii::app()->name . ' User Name and Password', $content, 'text/html', Yii::app()->params['swiftMailer']['username'], Yii::app()->params['swiftMailer']['accountName'], $user->email, ucwords($user->first_name) . " " . ucwords($user->last_name));

                Yii::app()->user->setFlash('success', "Successfully created");
                $this->redirect(array('view', 'id' => $model->user_id));
            }
        }

        $auth = Yii::app()->authManager;
        $role_data = $auth->getRoles();
        $role_arr = array();

        foreach ($role_data as $key => $val) {
            if ($val->bizrule == Yii::app()->user->auth_company_id) {
                $role_arr[] = $val;
            }
        }

        $list_role = CHtml::listData($role_arr, 'name', 'name');

        $this->render('create', array(
            'model' => $model,
            'listCompanies' => $listCompanies,
            'list_role' => $list_role,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->menu = array(
            array('label' => 'Create User', 'url' => array('create')),
            array('label' => 'View User', 'url' => array('view', 'id' => $model->user_id)),
            array('label' => 'Manage User', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update User ' . $model->user_name;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $CompanyObj = new Company('search');
        $CompanyObj->unsetAttributes();  // clear any default values
        $companies = $CompanyObj->search();
        $listCompanies = CHtml::listData($companies->getData(), 'company_id', 'name');

        if (isset($_POST['User'])) {
            $model->attributes = $_POST['User'];
            $model->updated_date = date('Y-m-d H:i:s');
            $model->updated_by = Yii::app()->user->name;

            if ($model->save()) {

                $user = User::model()->userDetailsByID($model->user_id, $model->company_id);

                $content = ('<html>'
                        . '<body>'
                        . ''
                        . '<div>'
                        . '<p style="'
                        . "font-family: 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;"
                        . 'font-size: 14px; font-style: normal; font-variant: normal; font-weight: 500; line-height: 15.3999996185303px;'
                        . '">Good Day <b>' . ucwords($user->first_name) . " " . ucwords($user->last_name) . '</b>,</p>'
                        . '<div style="margin-left: 30px;">'
                        . '<p style="'
                        . "font-family: 'Brush Script MT', cursive; font-size: 23px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 30px;"
                        . '">Welcome to ' . Yii::app()->name . '</p>'
                        . '<p style="'
                        . "font-family: 'Trebuchet MS', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif;"
                        . 'font-size: 14px; font-style: normal; font-variant: normal; font-weight: 500; line-height: 15.3999996185303px;'
                        . '">'
                        . '<span>Here is your User Name and Password:</span><br/><br/>'
                        . '<b>Account Name:</b>&nbsp;&nbsp;&nbsp;<i style="color: #0000FF;">' . $user->company->code . '</i><br/>'
                        . '<b>Username:</b>&nbsp;&nbsp;&nbsp;<i style="color: #0000FF;">' . $user->user_name . '</i><br/>'
                        . '<b>Password:</b>&nbsp;&nbsp;&nbsp;<i style="color: #0000FF;">' . $model->password2 . '</i><br/><br/>'
                        . '</p>'
                        . '<span>You may now <a href="' . Yii::app()->params['serverIP'] . 'index.php?r=site/login" target="_blank">login</a>.</span>'
                        . '</div>'
                        . '</div>'
                        . ''
                        . '</body>'
                        . '</html>');

                Globals::sendMail(Yii::app()->name . ' User Name and Password', $content, 'text/html', Yii::app()->params['swiftMailer']['username'], Yii::app()->params['swiftMailer']['accountName'], $user->email, ucwords($user->first_name) . " " . ucwords($user->last_name));

                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->user_id));
            }
        }

        $auth = Yii::app()->authManager;
        $role_data = $auth->getRoles();
        $role_arr = array();

        foreach ($role_data as $key => $val) {
            if ($val->bizrule == Yii::app()->user->auth_company_id) {
                $role_arr[] = $val;
            }
        }

        $list_role = CHtml::listData($role_arr, 'name', 'name');

        $this->render('update', array(
            'model' => $model,
            'listCompanies' => $listCompanies,
            'list_role' => $list_role,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                Yii::app()->user->setFlash('success', "Successfully deleted");
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            } else {

                echo "Successfully deleted";
                exit;
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('User');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage User';

        $model = new User('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['User']))
            $model->attributes = $_GET['User'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = User::model()->findByAttributes(array('user_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
