<?php

class AuthitemController extends Controller {
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
                'actions' => array('admin', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionData() {

        Authitem::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = Authitem::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Authitem::model()->countByAttributes(array('type' => 2));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );

        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['name'] = $value->name;
            $row['type'] = $value->type;
            $row['description'] = $value->description;
            $row['bizrule'] = $value->bizrule;
            $row['data'] = $value->data;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/admin/authitem/view', array('id' => $value->name)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/admin/authitem/update', array('id' => $value->name)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/admin/authitem/delete', array('id' => $value->name)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);

        $this->pageTitle = 'View ' . Authitem::AUTHITEM_LABEL . " " . $model->name;

        $this->menu = array(
            array('label' => 'Create ' . Authitem::AUTHITEM_LABEL, 'url' => array('create')),
            array('label' => 'Update ' . Authitem::AUTHITEM_LABEL, 'url' => array('update', 'id' => $model->name)),
            array('label' => 'Delete ' . Authitem::AUTHITEM_LABEL, 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->name), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage ' . Authitem::AUTHITEM_LABEL, 'url' => array('admin')),
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

        $this->pageTitle = 'Create ' . Authitem::AUTHITEM_LABEL;
        $this->layout = '//layouts/column1';

        $this->menu = array(
            array('label' => 'Manage Authitem', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new Authitem;

        $bizrule = 'return "' . Yii::app()->user->company_id . '" == $params["company_id"];';

        $c = new CDbCriteria;
        $c->condition = "t.type = 0 AND t.bizrule IN ('" . $bizrule . "', 'return true;')";
        $c->order = "t.description ASC";
        $operations = Authitem::model()->findAll($c);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Authitem'])) {

            $model->attributes = $_POST['Authitem'];
            $model->type = 2;
            $model->created_by = Yii::app()->user->name;
            unset($model->created_date);

            if ($model->validate()) {

                $data['so'] = CJSON::encode(isset($_POST['so']) ? $_POST['so'] : "");
                $data['zone'] = CJSON::encode(isset($_POST['zone']) ? $_POST['zone'] : "");

                $model->data = CJSON::encode($data);
                $auth = Yii::app()->authManager;
                $auth->createRole($model->name, $model->description, Yii::app()->user->auth_company_id, $model->data);

                if (count($operations) > 0) {
                    if (isset($_POST['operations'])) {
                        foreach ($_POST['operations'] as $key => $value) {
                            $auth->addItemChild($model->name, $value);
                        }
                    }
                }

                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->name));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'operations' => $operations,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        $this->pageTitle = 'Update ' . Authitem::AUTHITEM_LABEL . " " . $model->name;
        $this->layout = '//layouts/column1';

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $bizrule = 'return "' . Yii::app()->user->company_id . '" == $params["company_id"];';

        $c = new CDbCriteria;
        $c->condition = "t.type = 0 AND t.bizrule IN ('" . $bizrule . "', 'return true;')";
        $c->order = "t.description ASC";
        $operations = Authitem::model()->findAll($c);

        $auth = Yii::app()->authManager;
        $childs = $auth->getItemChildren($id);

        if ($model->updated_date == "") {

            $data_first_rem = strstr($model->data, '{');
            $data_last_rem = strstr(strrev($data_first_rem), '}');
            $final_data = strrev($data_last_rem);
        } else {

            $final_data = $model->data;
        }
        $unserialize = CJSON::decode($final_data);

        if (isset($_POST['Authitem'])) {

            $data['so'] = CJSON::encode(isset($_POST['so']) ? $_POST['so'] : "");
            $data['zone'] = CJSON::encode(isset($_POST['zone']) ? $_POST['zone'] : "");
            $model->data = CJSON::encode($data);
            $model->name = $_POST['Authitem']['name'];
            $model->description = $_POST['Authitem']['description'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->validate()) {

                if ($model->save()) {

                    foreach ($childs as $key => $value) {
                        $auth->removeItemChild($id, $value->name);
                    }

                    if (isset($_POST['operations'])) {
                        foreach ($_POST['operations'] as $key => $value) {
                            $auth->addItemChild($id, $value);
                        }
                    }

                    Yii::app()->user->setFlash('success', "Successfully updated");
                    $this->redirect(array('view', 'id' => $model->name));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'selected_so' => CJSON::decode($unserialize['so']),
            'operations' => $operations,
            'childs' => $childs,
            'selected_zone' => CJSON::decode($unserialize['zone']),
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
//            $this->loadModel($id)->delete();

            if (Authitem::model()->getUserCountByRole($id) == 0) {
                $auth = Yii::app()->authManager;
                $auth->removeAuthItem($id);
            }

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
        $dataProvider = new CActiveDataProvider('Authitem');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage ' . Authitem::AUTHITEM_LABEL;

        $model = new Authitem('search');
        $model->unsetAttributes();  // clear any default values
        $model->type = 2;

        if (isset($_GET['Authitem']))
            $model->attributes = $_GET['Authitem'];

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
        $model = Authitem::model()->findByAttributes(array('name' => $id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'authitem-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
