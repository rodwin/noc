<?php

class ImagesController extends Controller {
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
                'actions' => array('index', 'data', 'upload', 'uploadImage', 'ajaxLoadImages', 'deleteMultiple'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('admin'),
                'expression' => "Yii::app()->user->checkAccess('Manage Images', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('create'),
                'expression' => "Yii::app()->user->checkAccess('Add Images', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('view'),
                'expression' => "Yii::app()->user->checkAccess('View Images', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('update'),
                'expression' => "Yii::app()->user->checkAccess('Edit Images', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('delete'),
                'expression' => "Yii::app()->user->checkAccess('Delete Images', array('company_id' => Yii::app()->user->company_id))",
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionData() {

        Images::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = Images::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Images::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );



        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['image'] = CHtml::image($value->url, "Image", array("width" => 100));
            $row['image_id'] = $value->image_id;
            $row['file_name'] = $value->file_name;
            $row['url'] = $value->url;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;


            $row['links'] = '<a class="view" title="View" data-toggle="tooltip" href="' . $this->createUrl('/library/images/view', array('id' => $value->image_id)) . '" data-original-title="View"><i class="fa fa-eye"></i></a>'
//                    . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="' . $this->createUrl('/library/images/update', array('id' => $value->image_id)) . '" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                    . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="' . $this->createUrl('/library/images/delete', array('id' => $value->image_id)) . '" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

            $output['data'][] = $row;
        }

        echo json_encode($output);
    }

    public function actionUpload() {

        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Upload Images';

        $model = new Images;

        if (Yii::app()->request->isPostRequest) {

            if (isset($_POST['file_name'])) {

                $file_name = $_POST['file_name'];

                $criteria = new CDbCriteria();
                $criteria->addSearchCondition('t.file_name', $file_name, true);
                $criteria->compare('t.company_id', Yii::app()->user->company_id);

                $dataProvider = new CActiveDataProvider('Images', array(
                    'criteria' => $criteria,
                    'pagination' => array('pageSize' => 18),
                ));

                $this->renderPartial('_images', array(
                    'model' => $model,
                    'dataProvider' => $dataProvider,
                        ), false, true);
            }
        } else {

            $dataProvider = new CActiveDataProvider('Images', array(
                'pagination' => array('pageSize' => 18),
            ));

            $this->render('upload', array(
                'dataProvider' => $dataProvider,
                'model' => $model,
            ));
        }
    }

    public function actionAjaxLoadImages() {

        $dataProvider = new CActiveDataProvider('Images', array(
            'pagination' => array('pageSize' => 18),
        ));

        $this->renderPartial('_images', array('dataProvider' => $dataProvider,), false, true);
    }

    public function actionUploadImage() {

        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) &&
                (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }

        $data = array();

        $model = new Images('upload');

        if (isset($_FILES['Images']['name']) && $_FILES['Images']['name'] != "") {

            $file = CUploadedFile::getInstance($model, 'image');

            $dir = dirname(Yii::app()->getBasePath()) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . Yii::app()->user->company_id;

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $file_name = str_replace(' ', '_', strtolower($file->name));
            $url = Yii::app()->getBaseUrl(true) . '/images/' . Yii::app()->user->company_id . '/' . $file_name;
            if (@fopen($url, "r")) {
                //existing
                throw new CHttpException(409, "Could not upload file. File already exist " . CHtml::errorSummary($model));
            } else {
                //not existing

                $file->saveAs($dir . DIRECTORY_SEPARATOR . $file_name);

                $model->image_id = Globals::generateV4UUID();
                $model->company_id = Yii::app()->user->company_id;
                $model->file_name = $file_name;
                $model->url = $url;
                $model->created_by = Yii::app()->user->name;


                if ($model->save()) {

                    $data[] = array(
                        'name' => $file->name,
                        'type' => $file->type,
                        'size' => $file->size,
                        'url' => $dir . DIRECTORY_SEPARATOR . $file_name,
                        'thumbnail_url' => $dir . DIRECTORY_SEPARATOR . $file_name,
//                    'delete_url' => $this->createUrl('my/delete', array('id' => 1, 'method' => 'uploader')),
//                    'delete_type' => 'POST',
                    );
                } else {

                    if ($model->hasErrors()) {

                        $data[] = array('error', $model->getErrors());
                    }
                }
            }
        } else {

            throw new CHttpException(500, "Could not upload file " . CHtml::errorSummary($model));
        }

        echo json_encode($data);
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);

        $this->pageTitle = 'View Images ' . $model->file_name;

        $this->menu = array(
            array('label' => 'Create Images', 'url' => array('create')),
            array('label' => 'Update Images', 'url' => array('update', 'id' => $model->image_id)),
            array('label' => 'Delete Images', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->image_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage Images', 'url' => array('admin')),
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

        $this->pageTitle = 'Create Images';

        $this->menu = array(
            array('label' => 'Manage Images', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new Images('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Images'])) {
            $model->attributes = $_POST['Images'];
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            unset($model->created_date);

            $model->image_id = Globals::generateV4UUID();

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully created");
                $this->redirect(array('view', 'id' => $model->image_id));
            }
        }

        $this->render('create', array(
            'model' => $model,
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
            array('label' => 'Create Images', 'url' => array('create')),
            array('label' => 'View Images', 'url' => array('view', 'id' => $model->image_id)),
            array('label' => 'Manage Images', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update Images ' . $model->image_id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Images'])) {
            $model->attributes = $_POST['Images'];
            $model->updated_by = Yii::app()->user->name;
            $model->updated_date = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->image_id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            try {
                // we only allow deletion via POST request
                $this->deletebyurl($id);
                $this->loadModel($id)->delete();

//                SkuImage::model()->findByAttributes(array('image_id' => $id, 'company_id' => Yii::app()->user->company_id))->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
                if (!isset($_GET['ajax'])) {
                    Yii::app()->user->setFlash('success', "Successfully deleted");
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                } else {

                    echo "Successfully deleted";
                    exit;
                }
            } catch (CDbException $e) {
                if ($e->errorInfo[1] == 1451) {
                    if (!isset($_GET['ajax'])) {
                        Yii::app()->user->setFlash('danger', "Unable to deleted");
                        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view', 'id' => $id));
                    } else {
                        echo "1451";
                        exit;
                    }
                }
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionDeleteMultiple() {

        $id = isset($_POST['img_id']) ? $_POST['img_id'] : null;

        if (Yii::app()->request->isPostRequest) {
            try {
                // we only allow deletion via POST request
                $this->deletebyurl($id);
                $this->loadModel($id)->delete();


//                SkuImage::model()->findByAttributes(array('image_id' => $id, 'company_id' => Yii::app()->user->company_id))->delete();

                echo "Successfully deleted";
                exit;
            } catch (CDbException $e) {
                if ($e->errorInfo[1] == 1451) {
                    echo "1451";
                    exit;
                }
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Images');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage Images';

        $model = new Images('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Images']))
            $model->attributes = $_GET['Images'];

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
        $model = Images::model()->findByAttributes(array('image_id' => $id, 'company_id' => Yii::app()->user->company_id));
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'images-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function deletebyurl($id) {

        $sql = "SELECT url FROM noc.images WHERE image_id = :image_id";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindParam(':image_id', $id, PDO::PARAM_STR);
        $data = $command->queryAll();
        foreach ($data as $key => $value) {
            $url = $value['url'];
        }
        //$url = substr($url, 16);
        $base = Yii::app()->getBaseUrl(true);
        $arr = explode("/", $base);
        $base = $arr[count($arr) - 1];
        $url = str_replace(Yii::app()->getBaseUrl(true), "", $url);
        $delete_link = '../' . $base . $url;

        if (file_exists($delete_link)) {
            unlink($delete_link);
        }
    }

}
