
<div><?php echo $form->label($model, 'Date Field', array('class' => 'control-label text-primary', 'style' => 'font-weight: bold;')); ?></div>

<div>
    <?php echo $form->label($model, 'Default Value', array('class' => 'control-label')); ?><br/>
    <?php
    echo CHtml::dropDownList('default_value', $unserialize_attribute['default_value'], array(
        'mm/dd/yyyy' => 'Default - (03/07/2014)',
//        'M/d/yyyy' => 'M/d/yyyy - (3/7/2014)',
//        'MM/dd/yyyy' => 'MM/dd/yyyy - (03/07/2014)',
//        'M/d/yy' => 'M/d/yy - (3/7/14)',
//        'MM/dd/yy' => 'MM/dd/yy - (03/07/14)',
        'MMMMM d, yyyy' => 'MMMMM d, yyyy - (March 7, 2014)',
        'd-MMM' => 'd-MMM - (7-Mar)',
        'd-MMM-yy' => 'd-MMM-yy - (7-Mar-14)',
        'd-MMM-yyyy' => 'd-MMM-yyyy - (7-Mar-2014)',
        'dd/MM/yyyy' => 'dd/MM/yyyy - (07/03/2014)',
        'dd/MM/yy' => 'dd/MM/yy - (07/03/14)',
        'yyyy-MM-dd' => 'yyyy-MM-dd - (2014-03-07)',
        'dd MMMM yyyy' => 'dd MMMM yyyy - (07 March 2014)',
            ), array('style' => 'width: 200px; padding: 5px; font-size: 12px;'));
    ?>
</div>
