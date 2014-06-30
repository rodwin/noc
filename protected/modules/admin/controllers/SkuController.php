<?php

class SkuController extends Controller
{
    /**
    * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
    * using two-column layout. See 'protected/views/layouts/column2.php'.
    */
    //public $layout='//layouts/column2';

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
                'actions'=>array('index','view'),
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
            
        Sku::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value']:null;

        $dataProvider = Sku::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'],$_GET['columns']);

        $count = Sku::model()->countByAttributes(array('company_id'=>Yii::app()->user->company_id,'deleted'=> 0));

        $output = array(
                "draw" => intval($_GET['draw']),
                "recordsTotal" => $count,
                "recordsFiltered" => $dataProvider->totalItemCount,
                "data" => array()
        );
        
        
        
        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
                        $row['code']= $value->code;
                        $row['brand_code']= $value->brand_code;
                        $row['name']= $value->name;
                        $row['description']= $value->description;
                        $row['uom']= $value->uom;
                        $row['unit_price']= $value->unit_price;
                        $row['type']= $value->type;
                        $row['created_date']= $value->created_date;
                        $row['created_by']= $value->created_by;
                        $row['updated_date']= $value->updated_date;
                        $row['updated_by']= $value->updated_by;
                        $row['deleted_date']= $value->deleted_date;
                        $row['deleted_by']= $value->deleted_by;
                        $row['deleted']= $value->deleted;
                        
                        
            $row['links']= '<a class="view" title="View" data-toggle="tooltip" href="'.$this->createUrl('/admin/sku/view',array('id'=>$value->code)).'" data-original-title="View"><i class="fa fa-eye"></i></a>'
                        . '&nbsp;<a class="update" title="Update" data-toggle="tooltip" href="'.$this->createUrl('/admin/sku/update',array('id'=>$value->code)).'" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                        . '&nbsp;<a class="delete" title="Delete" data-toggle="tooltip" href="'.$this->createUrl('/admin/sku/delete',array('id'=>$value->code)).'" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

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

        $this->pageTitle = 'View Sku '.$model->code;

        $this->menu=array(
                array('label'=>'Create Sku', 'url'=>array('create')),
                array('label'=>'Update Sku', 'url'=>array('update', 'id'=>$model->code)),
                array('label'=>'Delete Sku', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->code),'confirm'=>'Are you sure you want to delete this item?')),
                array('label'=>'Manage Sku', 'url'=>array('admin')),
                '',
                array('label'=>'Help', 'url' => '#'),
        );
        
        $this->render('view',array(
            'model'=>$model,
        ));
    }

    /**
    * Creates a new model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    */
    public function actionCreate()
    {
        
        $this->pageTitle = 'Create Sku';

        $this->menu=array(
                array('label'=>'Manage Sku', 'url'=>array('admin')),
                '',
                array('label'=>'Help', 'url' => '#'),
        );
    
        $model=new Sku('create');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Sku']))
        {
            $model->attributes=$_POST['Sku'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->code));
            }
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }

    /**
    * Updates a particular model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id the ID of the model to be updated
    */
    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
            
        $this->menu=array(
                array('label'=>'Create Sku', 'url'=>array('create')),
                array('label'=>'View Sku', 'url'=>array('view', 'id'=>$model->code)),
                array('label'=>'Manage Sku', 'url'=>array('admin')),
                '',
                array('label'=>'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update Sku '.$model->code;
        
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Sku']))
        {
            $model->attributes=$_POST['Sku'];
            if($model->save()){
                $this->redirect(array('view','id'=>$model->code));
            }
        }

        $this->render('update',array(
            'model'=>$model,
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
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax'])){
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
        $dataProvider=new CActiveDataProvider('Sku');
        
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
        $this->pageTitle = 'Manage Sku';
        
        $model=new Sku('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Sku']))
            $model->attributes=$_GET['Sku'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
    * Returns the data model based on the primary key given in the GET variable.
    * If the data model is not found, an HTTP exception will be raised.
    * @param integer the ID of the model to be loaded
    */
    public function loadModel($id)
    {
        $model=Sku::model()->findByAttributes(array('code'=>$id,'company_id'=>Yii::app()->user->company_id));
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='sku-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
