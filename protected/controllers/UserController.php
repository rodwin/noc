<?php

class UserController extends Controller
{

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
				'actions'=>array('index','view','Data'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
            
//            pr($_GET);
            
            User::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value']:null;
            
            $dataProvider = User::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'],$_GET['columns']);
            
            $count = User::model()->count();
                
            $output = array(
                    "draw" => intval($_GET['draw']),
                    "recordsTotal" => $count,
                    "recordsFiltered" => $dataProvider->totalItemCount,
                    "data" => array()
            );
            
            foreach ($dataProvider->getData() as $key => $value) {
                $row = array();
                $row['id']= $value->id;
                $row['user_type_id']= $value->user_type_id;
                $row['user_name']= $value->user_name;
                $row['first_name']= $value->first_name;
                $row['last_name']= $value->last_name;
                $row['email']= $value->email;
                $row['status']= $value->status;
                $row['links']= '<a class="view" title="View" rel="tooltip" href="'.$this->createUrl('user/view',array('id'=>$value->id)).'" data-original-title="View"><i class="fa fa-eye"></i></a>'
                        . '&nbsp;<a class="update" title="Update" rel="tooltip" href="'.$this->createUrl('user/update',array('id'=>$value->id)).'" data-original-title="View"><i class="fa fa-pencil"></i></a>'
                        . '&nbsp;<a class="delete" title="Delete" rel="tooltip" href="'.$this->createUrl('user/delete',array('id'=>$value->id)).'" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>';

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
                $this->layout = "column2";
            
                $model=$this->loadModel($id);
                
                $this->pageTitle = 'View User #'.$model->id;
                
                $this->menu=array(
                        array('label'=>'Create User', 'url'=>array('create')),
                        array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
                        array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
                        array('label'=>'Manage User', 'url'=>array('admin')),
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
                $this->layout = "column2";
                $this->pageTitle = 'Create User';
                
                $this->menu=array(
                        array('label'=>'Manage User', 'url'=>array('admin')),
                        '',
                        array('label'=>'Help', 'url' => '#'),
                );
            
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
            
                $this->layout = "column2";
                
                $this->menu=array(
                        array('label'=>'Create User', 'url'=>array('create')),
                        array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
                        array('label'=>'Manage User', 'url'=>array('admin')),
                        '',
                        array('label'=>'Help', 'url' => '#'),
                );
                
                $this->pageTitle = 'Update User '.$model->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
                }else{
                    
                    echo "Successfully deleted";
                    exit;
                    
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                $this->pageTitle = 'Manage User';
                
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
