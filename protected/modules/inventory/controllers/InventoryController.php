<?php

class InventoryController extends Controller {
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
                'actions' => array('index', 'view','trans','test','increase','history'),
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
    
    public function actionHistory($inventory_id){
        
        $model = $this->loadModel($inventory_id);
        
        $history = InventoryHistory::model()->getAllByInventoryID($inventory_id,Yii::app()->user->company_id);
        
        $this->pageTitle = 'Inventory Record History';

        $this->menu = array(
            array('label' => 'Create Inventory', 'url' => array('create')),
            array('label' => 'Manage Inventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );
        
        $headers = InventoryHistory::model()->attributeLabels();
        
        $this->render('history', array(
            'model' => $model,
            'history' => $history,
            'headers' => $headers,
        ));
        
    }
    
    public function actionTest($inventory_id,$transaction_type,$qty){
        $this->layout = '//layouts/column1';
        
        $inventoryObj = $this->loadModel($inventory_id);
        $model = new IncreaseInventoryForm();
        $this->render('_increase', array(
            'inventoryObj' => $inventoryObj,
            'model' => $model,
            'qty' => $qty,
        ));
        
        
    }
    
    public function actionIncrease() {
        
        $model = new IncreaseInventoryForm();
        
        if (isset($_POST['IncreaseInventoryForm'])) {
            $model->attributes = $_POST['IncreaseInventoryForm'];
            $model->created_by =Yii::app()->user->name;
            
            if(!$model->validate()){
                echo json_encode(CActiveForm::validate($model));
                Yii::app()->end();
            }
            
            $data['success'] = false;
            
            if ($model->increase(false)) {
                $data['message']= 'Successfully increased';
                $data['success'] = true;
            }else{
                $data['message']= 'An error occured!';
            }
            
            echo json_encode($data);
            Yii::app()->end();
        }
        
    }
    
    public function actionTrans(){
        
        $inventory_id = Yii::app()->request->getParam('inventory_id');
        $transaction_type = Yii::app()->request->getParam('transaction_type');
        $qty = Yii::app()->request->getParam('qty');
        
        $inventoryObj = $this->loadModel($inventory_id);
        
        $title = "";
        $body="";
        switch ($transaction_type) {
            case 1:
                $model = new IncreaseInventoryForm();
                echo CJSON::encode(array($this->renderPartial('_increase', array(
                    'inventoryObj' => $inventoryObj,
                    'model' => $model,
                    'qty' => $qty,
                ),true)));
                
                Yii::app()->end();
                
                break;
            case 2:

                break;
            case 3:

                break;
            case 4:

                break;
            case 5:

                break;
            case 6:

                break;

            default:
                break;
        }
        
        Yii::app()->end();
        
    }

    public function actionData() {

        Inventory::model()->search_string = $_GET['search']['value'] != "" ? $_GET['search']['value'] : null;

        $dataProvider = Inventory::model()->data($_GET['order'][0]['column'], $_GET['order'][0]['dir'], $_GET['length'], $_GET['start'], $_GET['columns']);

        $count = Inventory::model()->countByAttributes(array('company_id' => Yii::app()->user->company_id));

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $count,
            "recordsFiltered" => $dataProvider->totalItemCount,
            "data" => array()
        );

        foreach ($dataProvider->getData() as $key => $value) {
            $row = array();
            $row['DT_RowId'] = $value->inventory_id;// Add an ID to the TR element
            $row['inventory_id'] = $value->inventory_id;
            $row['sku_code'] = $value->sku->sku_code;
            $row['sku_id'] = $value->sku_id;
            $row['sku_name'] = $value->sku->sku_name;
            $row['qty'] = $value->qty;
            $row['uom_id'] = $value->uom_id;
            $row['uom_name'] = $value->uom->uom_name;
            $row['action_qty'] = '<input type="text" data-id="'.$value->inventory_id.'" name="action_qty" id="action_qty_'.$value->inventory_id.'" />';
            $row['zone_id'] = $value->zone_id;
            $row['zone_name'] = $value->zone->zone_name;
            $row['sku_status_id'] = $value->sku_status_id;
            $row['sku_status_name'] = isset($value->skuStatus->status_name) ? $value->skuStatus->status_name:'';
            $row['sales_office_name'] = isset($value->zone->salesOffice->sales_office_name) ? $value->zone->salesOffice->sales_office_name:'';
            $row['brand_name'] = isset($value->sku->brand->brand_name) ? $value->sku->brand->brand_name:'';
            $row['transaction_date'] = $value->transaction_date;
            $row['created_date'] = $value->created_date;
            $row['created_by'] = $value->created_by;
            $row['updated_date'] = $value->updated_date;
            $row['updated_by'] = $value->updated_by;
            $row['expiration_date'] = $value->expiration_date;
            $row['reference_no'] = $value->reference_no;


            $row['links'] = '<a class="btn btn  btn-default" title="Inventory Record History" href="' . $this->createUrl('/inventory/inventory/history', array('inventory_id' => $value->inventory_id)) . '">
                                <i class="fa fa-clock-o"></i>
                            </a>
                            <a class="btn btn  btn-default" title="Item Detail" href="' . $this->createUrl('/inventory/inventory/history', array('inventory_id' => $value->inventory_id)) . '">
                                <i class="fa fa-wrench"></i>
                            </a>';

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

        $this->pageTitle = 'View Inventory ' . $model->inventory_id;

        $this->menu = array(
            array('label' => 'Create Inventory', 'url' => array('create')),
            array('label' => 'Update Inventory', 'url' => array('update', 'id' => $model->inventory_id)),
            array('label' => 'Delete Inventory', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->inventory_id), 'confirm' => 'Are you sure you want to delete this item?')),
            array('label' => 'Manage Inventory', 'url' => array('admin')),
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

        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Inventory';

        $this->menu = array(
            array('label' => 'Manage Inventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $model = new CreateInventoryForm();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $selectedSkuname = "";
        $selectedSkuBrand = "";
        if (isset($_POST['CreateInventoryForm'])) {
            
            $model->attributes = $_POST['CreateInventoryForm'];
            $model->company_id = Yii::app()->user->company_id;
            $model->created_by = Yii::app()->user->name;
            if ($model->create()) {
                
                Yii::app()->user->setFlash('success', "Successfully created");
                
                if (isset($_POST['create'])) {
                    $this->redirect(array('/inventory/Inventory/create'));
                } else if (isset($_POST['save'])) {
                    $this->redirect(array('/inventory/inventory/admin'));
                }
            }
            
            if(isset($_POST['CreateInventoryForm']['sku_code'])){
                $selectedSku = Sku::model()->findByAttributes(array('sku_code'=>$model->sku_code,'company_id'=>Yii::app()->user->company_id));
                if($selectedSku){
                    $selectedSkuname = $selectedSku->sku_name;
                    $selectedSkuBrand = isset($selectedSku->brand->brand_name) ? $selectedSku->brand->brand_name:'';
                }
            }
            
        }

        $sku = CHtml::listData(Sku::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'sku_name ASC')), 'sku_id', 'sku_name','brand.brand_name');
        $uom = CHtml::listData(UOM::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'uom_name ASC')), 'uom_id', 'uom_name');
        $zone = CHtml::listData(Zone::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'zone_name ASC')), 'zone_id', 'zone_name');
        $sku_status = CHtml::listData(SkuStatus::model()->findAll(array('condition' => 'company_id = "' . Yii::app()->user->company_id . '"', 'order' => 'status_name ASC')), 'sku_status_id', 'status_name');

        //top 20 new created item
        $recentlyCreatedItems = Inventory::model()->recentlyCreatedItems(Yii::app()->user->company_id);
//        foreach ($recentlyCreatedItems as $key => $value) {
//            pr($value);
//        }
        
        $this->render('create', array(
            'model' => $model,
            'sku' => $sku,
            'uom' => $uom,
            'zone' => $zone,
            'sku_status' => $sku_status,
            'selectedSkuname' => $selectedSkuname,
            'selectedSkuBrand' => $selectedSkuBrand,
            'recentlyCreatedItems' => $recentlyCreatedItems,
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
            array('label' => 'Create Inventory', 'url' => array('create')),
            array('label' => 'View Inventory', 'url' => array('view', 'id' => $model->inventory_id)),
            array('label' => 'Manage Inventory', 'url' => array('admin')),
            '',
            array('label' => 'Help', 'url' => '#'),
        );

        $this->pageTitle = 'Update Inventory ' . $model->inventory_id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Inventory'])) {
            $model->attributes = $_POST['Inventory'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Successfully updated");
                $this->redirect(array('view', 'id' => $model->inventory_id));
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
        $dataProvider = new CActiveDataProvider('Inventory');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $this->layout = '//layouts/column1';
        $this->pageTitle = 'Manage Inventory';

        $model = new Inventory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Inventory']))
            $model->attributes = $_GET['Inventory'];
        
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
        $model = Inventory::model()->findByPk($id);
        if ($model === null || $model->company_id != Yii::app()->user->company_id){
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'inventory-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
