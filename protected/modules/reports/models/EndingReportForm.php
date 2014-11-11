<?php

class EndingReportForm extends CFormModel {

    public $sales_office_id;
    public $brand_category;
    public $brand;
    public $cover_date;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('cover_date', 'required'),
            array('cover_date', 'type', 'type' => 'date', 'message' => '{attribute} is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('sales_office_id, brand_category, brand', 'safe'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'sales_office_id' => 'Sales Office',
            'brand_category' => 'Brand Category',
            'brand' => 'Brand',
            'cover_date' => 'Covered Date',
        );
    }

    public function getData($sales_offices, $brand_category, $brand, $last_date_time) {

        $qry = array();

        if ($sales_offices != "") {
            $qry[] = "c.sales_office_id IN (" . $sales_offices . ")";
        }

        if ($brand_category != "") {
            $qry[] = "f.brand_category_id = '" . $brand_category . "'";
        }

        if ($brand != "") {
            $qry[] = "e.brand_id = '" . $brand . "'";
        }

        if (count($qry) > 0) {
            $criteria = "AND " . implode(" AND ", $qry);
        } else {
            $criteria = "";
        }

        $sql = "SELECT c.sales_office_name, b.zone_name, f.category_name, e.brand_name, d.sku_code, d.description, d.type, d.sub_type, SUM(a.qty) AS qty , SUM(a.cost_per_unit) AS 
                    price, g.uom_name, ((SUM(a.qty)) * (SUM(a.cost_per_unit))) AS total
                    
                    FROM inventory a
                    INNER JOIN zone b ON b.zone_id = a.zone_id
                    INNER JOIN sales_office c ON c.sales_office_id = b.sales_office_id
                    INNER JOIN sku d ON d.sku_id = a.sku_id
                    INNER JOIN brand e ON e.brand_id = d.brand_id
                    INNER JOIN brand_category f ON f.brand_category_id = e.brand_category_id
                    INNER JOIN uom g ON g.uom_id = a.uom_id
                    WHERE (a.transaction_date BETWEEN '" . $last_date_time . " 00:00:00' AND '" . $last_date_time . " 23:59:59')
                    $criteria
                        
                    GROUP BY b.zone_id ,a.sku_id ORDER BY c.sales_office_name, b.zone_name, f.category_name";
        
        $command = Yii::app()->db->createCommand($sql);
        $data = $command->queryAll();

        return $data;
    }

}
