<strong>SEARCH RESULTS</strong>
<p id="demo"></p>
<table width="100%" border="1" id="mytable" class="table table-bordered">
   <tr>
      <th width="3%"></th>
      <th>CODE</th>
      <th>NAME</th>
   </tr>
   <?php
   $ctr = 1;
   foreach ($model as $key => $val) {
      echo '<tr class=clickableRow onmouseover="ChangeColor(this, true);" 
              onmouseout="ChangeColor(this, false);" data1="'. $ctr .'" data2 ="'. $val['id'] .'" data3="'. $val['name'] .'">';
      echo '<td id="'. $ctr .'">' . $ctr . '</td>';
      echo '<td id="'. $val['id'] .'">' . $val['id'] . '</td>';
      echo '<td id="'. $val['name'] .'">' . $val['name'] . '</td>';
      echo '</tr>';
      $ctr++;
   }
   ?> 

</table>



<script type="text/javascript"> 
//   jQuery(document).ready(function($) {
//      
//      $(".clickableRow").click(function() {
//         //alert("");
//         //         if(!e.target)
//         //            alert(e.srcElement.innerHTML);
//         //         else
//         alert($("#mytable").attr("data1"));
//         
//         //getBuyerInfo();
//      });
//   });
   
   $("table#mytable").delegate("tr", "click", function(){
      getBuyerInfo($(this).attr("data2"));
      //alert($(this).attr("data1") +', '+$(this).attr("data2"));
   });

   function ChangeColor(tableRow, highLight)
   {
      if (highLight)
      {
         tableRow.style.backgroundColor ='#A7D0E5';//'#81bcda'; //'#dcfac9';
      }
      else
      {
         tableRow.style.backgroundColor = 'white';
      }
   }
  
   function getBuyerInfo(code)
   {
      // var adds= 'jl. damai 3 no 2';
      $.ajax({
         'url': '<?php echo CController::createUrl('default/getInfo'); ?>' ,
         'type' : 'POST',
         'data': { 
            'id' : code
         },
         'dataType': 'text',
         'success': function(data) {
            //alert(data);
            $("#custTabs").html(data);              
         },
         error: function(jqXHR, exception) {}
      });
   }
   
   
</script>