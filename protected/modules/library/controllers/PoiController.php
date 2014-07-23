<?php

class PoiController extends Controller
{
    /**
    * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
    * using two-column layout. See 'protected/views/layouts/column2.php'.
    */
    //public $layout='//layouts/column2';
    public $category;

    /**
    * @return array action filters
    */
    public function filters()
    {
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
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view', 'getAllSubCategoryByCategoryID', 'getAllCustomDataByCategoryID', 'getAllSubCategoryByCategoryName'),
                'users'=>array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update','data'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    public function actionData(){

        Poi::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value']:null;

        $dataProvider = Poi::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'],$_GET['columns']);

        $count = Poi::model()->countByAttributes(array('company_id'=>Yii::app()->user->company_id));

        $output = array(
                "draw" => intval($_GET['draw']),
                "recordsTotal" => $count,
                "recordsFiltered" => $dataProvider->totalItemCount,
                "data" => array()
        );



        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
                        $row['poi_id']= $value->poi_id;
                        $row['short_name']= $value->short_name;
                        $row['long_name']= $value->long_name;
                        $row['primary_code']= $value->primary_code;
                        $row['secondary_code']= $value->secondary_code;
                        $row['barangay_id']= $value->barangay_id;
                        $row['municipal_id']= $value->municipal_id;
                        $row['province_id']= $value->province_id;
                        $row['region_id']= $value->region_id;
                        $row['sales_region_id']= $value->sales_region_id;
                        $row['latitude']= $value->latitude;
                        $row['longitude']= $value->longitude;
                        $row['address1']= $value->address1;
                        $row['address2']= $value->address2;
                        $row['zip']= $value->zip;
                        $row['landline']= $value->landline;
                        $row['mobile']= $value->mobile;
                        $row['poi_category_id']= $value->poi_category_id;
                        $row['poi_category_name']= $value->poiCategory->category_name;
                        $row['poi_sub_category_id']= $value->poi_sub_category_id;
                        $row['poi_sub_category_name']= $value->poiSubCategory->sub_category_name;
                        $row['remarks']= $value->remarks;
                        $row['status']= $value->status;
                        $row['created_date']= $value->created_date;
                        $row['created_by']= $value->created_by;
                        $row['edited_date']= $value->edited_date;
                        $row['edited_by']= $value->edited_by;
                        $row['verified_by']= $value->verified_by;
                        $row['verified_date']= $value->verified_date;


            $row['links']= '<a class="view" title="View" data-toggle="tooltip" href="'.$this->createUrl('/library/poi/view',array('id'=>$value->poi_id)).'" data-original-title="View"><i class="fa fa-eye"></i></a>'
                        . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="'.$this->createUrl('/library/poi/update',array('id'=>$value->poi_id)).'" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                        . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="'.$this->createUrl('/library/poi/delete',array('id'=>$value->poi_id)).'" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

            $output['data'][] = $row;
        }

        echo json_encode( $output );
    }

    /**
    * Displays a particular model.
    * @param integer $id the ID of the model to be displayed
    */
    public function actionView($id)
    {
        $model=$this->loadModel($id);

        $this->pageTitle = 'View Poi '.$model->short_name;

        $this->menu=array(
                array('label'=>'Create Poi', 'url'=>array('create')),
                array('label'=>'Update Poi', 'url'=>array('update', 'id'=>$model->poi_id)),
                array('label'=>'Delete Poi', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->poi_id),'confirm'=>'Are you sure you want to delete this item?')),
                array('label'=>'Manage Poi', 'url'=>array('admin')),
                '',
                array('label'=>'Help', 'url' => '#'),
        );
        
        $poi_custom_data_value = PoiCustomDataValue::model()->getPoiCustomDataValue($model->poi_id, $model->poi_category_id);

        $this->render('view',array(
            'model'=>$model,
            'poi_custom_data_value' => $poi_custom_data_value,
        ));
    }

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate() {

        $this->pageTitle = 'Create Poi';

        $this->menu = array(
            array('label' => 'Manage Poi', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new Poi('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Poi'])) {

            $model->poi_id = Globals::generateV4UUID();
            $model->attributes = $_POST['Poi'];
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            $model->latitude = !empty($_POST['Poi']['latitude']) ? $_POST['Poi']['latitude'] : 0;
            $model->longitude = !empty($_POST['Poi']['longitude']) ? $_POST['Poi']['longitude'] : 0;
            $model->edited_date = null;
            $model->verified_date = null;

            $poi_sub_category = PoiSubCategory::model()->getSubCategoryOptionListByCategoryID($model->poi_category_id);

            $custom_datas = PoiCustomData::model()->getPoiCustomData($model->poi_id, $model->poi_category_id);

            $model->addError($model->poi_category_id, "error");
            
            if ($model->validate()) {

                $model->save();

                foreach ($custom_datas as $key => $val) {
                    $custom_data_value = new PoiCustomDataValue;
                    
                    $custom_data_value->id = Globals::generateV4UUID();
                    $custom_data_value->poi_id = $model->poi_id;
                    $custom_data_value->custom_data_id = $val['custom_data_id'];
                    
                    $post_name = $val['category_name'] . "_" . $val['name'] = str_replace(' ', '_', strtolower($val['data_type'])) . "_" . $val['data_type'] = str_replace(' ', '_', strtolower($val['name']));
                    $pieces = explode("_", $post_name);
                    
//                    if ($pieces[1] == "numbers") {
//                        $value = rtrim($_POST[$post_name], "0");
//                        $custom_data_value->value = substr($value, -1) == "." ? rtrim($value, ".") : $value;
//                    } else {
                        $custom_data_value->value = $_POST[$post_name];
//                    }

                    $custom_data_value->save();
                }

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', "Successfully created");
                    $this->redirect(array('view', 'id' => $model->poi_id));
                }
            }
        } else {
            $poi_sub_category = array();
            $custom_datas = array();
        }

        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'poi_category_id', 'category_name');

        $this->render('create', array(
            'model' => $model,
            'poi_category' => $poi_category,
            'poi_sub_category' => $poi_sub_category,
            'custom_datas' => $custom_datas,
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
            array('label' => 'Create Poi', 'url' => array('create')),
            array('label' => 'View Poi', 'url' => array('view', 'id' => $model->poi_id)),
            array('label' => 'Manage Poi', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update Poi ' . $model->short_name;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Poi'])) {

            $model->attributes = $_POST['Poi'];
            $model->latitude = !empty($_POST['Poi']['latitude']) ? $_POST['Poi']['latitude'] : 0;
            $model->longitude = !empty($_POST['Poi']['longitude']) ? $_POST['Poi']['longitude'] : 0;
            $model->edited_by = Yii::app()->user->name;
            $model->edited_date = date('Y-m-d H:i:s');
            $model->verified_date = null;
            
            $custom_datas = PoiCustomData::model()->getPoiCustomData($model->poi_id, $model->poi_category_id);
            
            if ($model->validate()) {
            
                PoiCustomDataValue::model()->deletePoiCustomDataValueByPoiID($model->poi_id);
                
                foreach ($custom_datas as $key => $val) {
                    $custom_data_value = new PoiCustomDataValue;
                    
                    $custom_data_value->id = Globals::generateV4UUID();
                    $custom_data_value->poi_id = $model->poi_id;
                    $custom_data_value->custom_data_id = $val['custom_data_id'];

                    $post_name = $val['category_name'] . "_" . $val['name'] = str_replace(' ', '_', strtolower($val['data_type'])) . "_" . $val['data_type'] = str_replace(' ', '_', strtolower($val['name']));
                    $pieces = explode("_", $post_name);
                    
//                    if ($pieces[1] == "numbers") {
//                        $value = rtrim($_POST[$post_name], "0");
//                        $custom_data_value->value = substr($value, -1) == "." ? rtrim($value, ".") : $value;
//                    } else {
                        $custom_data_value->value = $_POST[$post_name];
//                    }

                    $custom_data_value->save();
                }

                if ($model->save()) {
                    Yii::app()->user->setFlash('success', "Successfully updated");
                    $this->redirect(array('view', 'id' => $model->poi_id));
                }
                
            }
        } else {
            $custom_datas = PoiCustomData::model()->getPoiCustomData($model->poi_id, $model->poi_category_id);
        }

        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'poi_category_id', 'category_name');

        $criteria = new CDbCriteria;
        $criteria->condition = 'company_id = "' . Yii::app()->user->company_id . '" AND poi_category_id = "' . $model->poi_category_id . '"';
        $criteria->order = "t.sub_category_name ASC";

        $poi_sub_category = CHtml::listData(PoiSubCategory::model()->findAll($criteria), 'poi_sub_category_id', 'sub_category_name');

        $this->render('update', array(
            'model' => $model,
            'poi_category' => $poi_category,
            'poi_sub_category' => $poi_sub_category,
            'custom_datas' => $custom_datas,
        ));
    }

    /**
    * Deletes a particular model.
    * If deletion is successful, the browser will be redirected to the 'admin' page.
    * @param integer $id the ID of the model to be deleted
    */
    public function actionDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // delete poi custom data value by poi_id
            PoiCustomDataValue::model()->deletePoiCustomDataValueByPoiID($id);
            
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
                Yii::app()->user->setFlash('success',"Successfully deleted");
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
            }else{

                echo "Successfully deleted";
                exit;

            }
        }
        else
        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
    * Lists all models.
    */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('Poi');

        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
    * Manages all models.
    */
    public function actionAdmin()
    {
        $this->layout='//layouts/column1';
        $this->pageTitle = 'Manage Poi';

        $model=new Poi('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Poi']))
            $model->attributes=$_GET['Poi'];
        
        $poi_category = CHtml::listData(PoiCategory::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'category_name ASC')), 'category_name', 'category_name');

        $this->render('admin',array(
            'model'=>$model,
            'poi_category' => $poi_category,
        ));
    }

    /**
    * Returns the data model based on the primary key given in the GET variable.
    * If the data model is not found, an HTTP exception will be raised.
    * @param integer the ID of the model to be loaded
    */
    public function loadModel($id)
    {
        $model=Poi::model()->findByAttributes(array('poi_id'=>$id,'company_id'=>Yii::app()->user->company_id));
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');

        return $model;
    }

    /**
    * Performs the AJAX validation.
    * @param CModel the model to be validated
    */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='poi-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGetAllSubCategoryByCategoryID() {

        echo "<option value=''>Select Sub Category</option>";
        $data = PoiSubCategory::model()->getSubCategoryOptionListByCategoryID($_POST['poi_category_id']);

        foreach ($data as $value => $sub_category_name)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($sub_category_name), true);

    }
    
    public function actionGetAllSubCategoryByCategoryName() {

        echo "<option value=''>Select Sub Category</option>";
        $data = PoiSubCategory::model()->getSubCategoryOptionListByCategoryName($_POST['poi_category_name']);
        
        foreach ($data as $value => $sub_category_name)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($sub_category_name), true);

    }
    
    public function actionGetAllCustomDataByCategoryID() {  
        $model = new Poi;

        $custom_datas = PoiCustomData::model()->getPoiCustomData($_POST['poi_id'], $_POST['category_id']);
                
        if (empty($_POST['poi_id'])) {
            echo $this->renderPartial('_customItems', array('custom_datas' => $custom_datas,));
        } else {
            echo $this->renderPartial('_customItems_update', array('custom_datas' => $custom_datas,));
        }


    }

}
