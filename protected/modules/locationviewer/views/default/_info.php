<div class="nav-tabs-custom">
   <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab">Location Information</a></li>
      <li><a href="#tab_2" data-toggle="tab">Address</a></li>
      <li><a href="#tab_3" data-toggle="tab">History</a></li>
   </ul>
   <div class="tab-content" id ="info">
      <div class="tab-pane active" id="tab_1">
         <table width ="100%" height ="100%">
            <tbody> 
               <tr width ="10%"> 
                  <td style="border: solid 1px #CCCCCC; width: 130px; height: 100px;" rowspan="8"><div id="outlet_pic"></div></td> 
               </tr> 
               <tr> 
                  <?php
                  foreach ($model as $key => $val) {
                     echo '  <td><p>Code:</p></td> ';
                     echo'<td><div id="outlet_code">' . $val['id'] . '</div></td>';
                  }
                  ?>
                  <td><p>PH TYPE:</p></td> 
                  <td><div></div></td>
               </tr>
               <tr> 
                  <td><p>Name:</p></td>
                  <?php
                  foreach ($model as $key => $val) {
                     echo '<td><div id="buyer_name">' . $val['name'] . '</div></td>';
                  }
                  ?>
               </tr>
               <tr> 
                  <td><p>SURVEY</p></td>
               </tr> 
               <tr> 
                  <td><p>Facial Care -</p> 
                     <?php
                     foreach ($model as $key => $val) {

                        if ($val['facial'] == 1) {
                           $str = 'PG';
                        } elseif ($val['facial'] == 2) {
                           $str = 'NON-PG';
                        } else {
                           $str = 'NA';
                        }
                        echo '<td><div id="survey1">' . $str . '</div></td>';
                     }
                     ?>
               </tr> 
               <tr>
                  <td><p>Diaper Care -</p></td>
                  <?php
                  foreach ($model as $key => $val) {

                     if ($val['diaper'] == 1) {
                        $str = 'PG';
                     } elseif ($val['diaper'] == 2) {
                        $str = 'NON-PG';
                     } else {
                        $str = 'NA';
                     }
                     echo '<td><div id="survey2">' . $str . '</div></td>';
                  }
                  ?>
               </tr>
               <tr>
                  <td><p>Shaver Care -</p></td>
                  <?php
                  foreach ($model as $key => $val) {

                     if ($val['shaver'] == 1) {
                        $str = 'PG';
                     } elseif ($val['shaver'] == 2) {
                        $str = 'NON-PG';
                     } else {
                        $str = 'NA';
                     }
                     echo '<td><div id="survey1">' . $str . '</div></td>';
                  }
                  ?>
               </tr>
   <!--            <tr>
                  <td><p>Conditioner Used -</p></td>
                  <td><div id="address_2"></div></td> 
               </tr> -->
            </tbody>
         </table>
      </div>
      <div class="tab-pane" id="tab_2">
         <table width ="100%" height ="100%">
            <tbody>
               <tr> 
                  <td><p>Name:</p></td>
                  <?php
                  foreach ($model as $key => $val) {
                     echo '<td><div id="buyer_name">' . $val['name'] . '</div></td>';
                  }
                  ?>
               </tr>
               <tr> 
                  <td><p>Address:</p></td>
                  <?php
                  foreach ($model as $key => $val) {
                     echo '<td><div id="buyer_address">' . $val['address1'] . '</div></td>';
                  }
                  ?>
               </tr>
               <tr> 
                  <td><p>Mobile number:</p></td>
                  <?php
                  foreach ($model as $key => $val) {
                     echo '<td><div id="buyer_mobile">' . $val['mobile_number'] . '</div></td>';
                  }
                  ?>
               </tr>
            </tbody>
         </table>
      </div>
      <div class="tab-pane" id="tab_3">

      </div>
   </div>
</div>