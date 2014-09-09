<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->baseUrl . '/css/jqx.base.css');
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jqxcore.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jqxsplitter.js', CClientScript::POS_END);
$this->breadcrumbs = array(
    $this->module->id,
);
?>
<style type="text/css">

   #mapContainer {
      width: 100%;
      height: 100%;
   }
   #tabs {
      width: 100%;
      margin-left: auto;
      margin-right: auto;
      overflow:scroll;
   }
   #img
   {
      float:left;
      margin-right: 10px;
   }
   td
   {
      font-size: 13px;
   }

</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script>
   $(function() {
      $( "#tabs" ).tabs();
   });
</script>
<div id="row">
   <div id="mainSplitter">

      <div>
         <div id="rightSplitter">
            <div>
               <div id="mapContainer"></div>
            </div>
            <div class="nav-tabs-custom" id ="custTabs">
               <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Location Information</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Address</a></li>
                  <li><a href="#tab_3" data-toggle="tab">History</a></li>
               </ul>
               <div class="tab-content" id ="info">
                  <div class="tab-pane active" id="tab_1">
                     <table width ="100%" height ="100%" id="tblinfo">
                        <tbody> 
                           <tr> 
                              <td style="border: solid 1px #CCCCCC; width: 130px; height: 100px;" rowspan="8"><div id="outlet_pic"></div></td> 
                           </tr> 
                           <tr> 
                              <td><p>Code:</p></td> 
                              <td><div id="outlet_code"></div></td>
                              <td><p>PH TYPE:</p></td> 
                              <td><div id="barangay_name"></div></td>
                           </tr>
                           <tr> 
                              <td><p>Name:</p></td>
                              <td><div id="outlet_name"></div></td>
                              <td><p>SIZE OF FAMILY:</p></td>
                              <td><div id="municipal_name"></div></td>
                           </tr>
                           <tr> 
                              <td><p>SURVEY</p></td>
                           </tr> 
                           <tr> 
                              <td><p>Facial Care -</p> 
                              <td><div id="address_1"></div></td> 
                           </tr> 
                           <tr>
                              <td><p>Diaper Care -</p></td>
                              <td><div id="address_2"></div></td> 
                           </tr>
                           <tr>
                              <td><p>Shaver Care -</p></td>
                              <td><div id="address_2"></div></td> 
                           </tr>
<!--                           <tr>
                              <td><p>Conditioner Used -</p></td>
                              <td><div id="address_2"></div></td> 
                           </tr> -->
                        </tbody>
                     </table>
                  </div>
                  <div class="tab-pane" id="tab_2">
                     <p id="samp"></p>
                  </div>
                  <div class="tab-pane" id="tab_3">

                  </div>
               </div>

            </div>

         </div>
      </div>
      <div>
         <div id="table">
            <strong>SEARCH RESULTS</strong>
            <p id="demo"></p>
            <table width="100%" border="1" id="mytable" class="table table-bordered">
               <tr>
                  <th width="3%"></th>
                  <th>CODE</th>
                  <th>NAME</th>
               </tr>
            </table>

         </div>
      </div>
   </div>
</div>
<script type="text/javascript" src="http://js.api.here.com/se/2.5.3/jsl.js?with=maps,places,directions,positioning"></script>
<script type="text/javascript">   
   $(document).ready(function () {
      $(window).resize(function(){
         var h = $(window).height();
         console.log(h);
         $("#row").css('height',(h-145));
      });

      $('#mainSplitter').jqxSplitter({ width: '100%', height: '100%', panels: [{ size: '80%',collapsible: false }, { size: '20%'}] });
      $('#rightSplitter').jqxSplitter({ height: '100%', orientation: 'horizontal', panels: [{ size: '80%', collapsible: false }, { size: '20%'}] });
        
      nokia.Settings.set("app_id", "Zu92WCskAzZrStonxMQQ"); 
      nokia.Settings.set("app_code", "DZKw6mNv7p9HBdNA-QPiWw");

      var coord= "";
      // Get the DOM node to which we will append the map
      var mapContainer = document.getElementById("mapContainer");
      // Create a map inside the map container DOM node
      var map = new nokia.maps.map.Display(mapContainer, {
         // initial center and zoom level of the map
         center: [-6.322282366172964, 106.85734738528424],
         //center: [-4, 118.0000],
         zoomLevel: 20,
         components: [
            // ZoomBar provides a UI to zoom the map in & out
            new nokia.maps.map.component.ZoomBar(), 
            // We add the behavior component to allow panning / zooming of the map
            new nokia.maps.map.component.Behavior(),
            // Creates UI to easily switch between street map satellite and terrain mapview modes
            new nokia.maps.map.component.TypeSelector(),
            // Creates a toggle button to show/hide traffic information on the map
            new nokia.maps.map.component.Traffic(),
            // Creates a toggle button to show/hide public transport lines on the map
            new nokia.maps.map.component.PublicTransport(),
            // Creates a toggle button to enable the distance measurement tool
            new nokia.maps.map.component.DistanceMeasurement(),
            // Shows a min-map in the bottom right corner of the map
            new nokia.maps.map.component.Overview(),
            /* Shows a scale bar in the bottom right corner of the map depicting
             * ratio of a distance on the map to the corresponding distance in the real world
             * in either kilometers or miles
             */ 
            new nokia.maps.map.component.ScaleBar(),
            /* Positioning will show a set "map to my GPS position" UI button
             * Note: this component will only be visible if W3C geolocation API
             * is supported by the browser and if you agree to share your location.
             * If you location can not be found the positioning button will reset
             * itself to its initial state
             */
            new nokia.maps.positioning.component.Positioning(),
            // Add ContextMenu component so we get context menu on right mouse click / long press tap
            // new nokia.maps.map.component.ContextMenu(),
            // ZoomRectangle component adds zoom rectangle functionality to the map
            new nokia.maps.map.component.ZoomRectangle()
         ]
      });
      
      addContextMenu(map);

      // Add the context menu to the map
     
   });
    
   function addClicking(map)
   {
      var TOUCH = nokia.maps.dom.Page.browser.touch,
      CLICK = TOUCH ? "tap" : "click";
      map.addListener(CLICK, function (evt) {
         coord = "";
         coord = map.pixelToGeo(evt.displayX, evt.displayY);
        
      });
   }
   function addContextMenu(map) {
      addClicking(map);
      var myhandler1 = function(contextMenuEvent, group) 
      {
         group.addEntry(
         "Search location",
         function(activationEvent) 
         {
            
            // convertlonglat(contextMenuEvent.target.center.toString()); 
            // document.getElementById("demo").innerHTML = coord.latitude+" "+coord.longitude;
         
           map.objects.clear();
            var mark = new nokia.maps.map.StandardMarker(coord, {id:'poi'});
            map.objects.add(mark);
            
            $.ajax({
               'url': '<?php echo CController::createUrl('default/getAddress'); ?>' ,
               'type' : 'POST',
               'data': { 
                  'lat' : coord.latitude,
                  'lon' : coord.longitude
               },
               'dataType': 'text',
               'success': function(data) {
                  if (data != '<pre></pre>')
                  {
                     //alert(data);
                     var cont = data.substr(5, (data.length - 11));
                     getBuyers(cont);
                     setMarkers(cont, map);
                     //document.getElementById("demo").innerHTML = data;    
                  }
                  else
                  {
                     alert('failed to get street name.');
                  }
                  // getBuyers(data);
                  //$("#table").html(data);              
               },
               error: function(jqXHR, exception) {}
            });
            //this.mapDisplay.pan(0, 0, -200, 0);
         });
      }
      var contextMenu = new nokia.maps.map.component.ContextMenu();
      contextMenu.addHandler(myhandler1);
      contextMenu.removeHandler(nokia.maps.map.component.ContextMenu.ContextMenuHandler);
      map.components.add(contextMenu);
   }
   
   function getBuyers(adds)
   {
      // var adds= 'jl. damai 3 no 2';
      $.ajax({
         'url': '<?php echo CController::createUrl('default/getHousehold'); ?>' ,
         'type' : 'POST',
         'data': { 
            'address' : adds
         },
         'dataType': 'text',
         'success': function(data) {
            //alert(data);
            $("#table").html(data);              
         },
         error: function(jqXHR, exception) {}
      });
   }
   function setMarkers(adds, map)
   {
      $.ajax({
         'url': '<?php echo CController::createUrl('default/setMarker'); ?>' ,
         'type' : 'POST',
         'data': { 
            'address' : adds
         },
         'dataType': 'json',
         'success': function(data) {
            //alert(data);
            for (var i = 0; i <= data.length -1 ; i++)
            {
               //               alert(data[i].longitude + ", " + data[i].latitude);
               setMark(parseFloat(data[i].latitude), parseFloat(data[i].longitude), map, (i + 1) )
               //document.getElementById("samp").innerHTML = data[i].longitude;
            }
            // document.getElementById("samp").innerHTML = data;
            
            //$("#mapContainer").html(data);              
         },
         error: function(jqXHR, exception) {}
      });
   }
   
function setMark(lat, lon, map, num)
{
   var coord = new nokia.maps.geo.Coordinate(lat, lon)
   var mark = new nokia.maps.map.StandardMarker(coord, {text: num});

   map.objects.add(mark);
     
   //      var marker = new nokia.maps.map.Marker(new nokia.maps.geo.Coordinate(lat,longt), 
   //      {
   //         icon:"<?php //echo base_url();    ?>application/kookabura/images/truck3.png",
   //         $click : 'showBubble("'+location+'",'+lat+','+longt+',"'+truck+'","'+shipment+'","'+driver_name+'","'+group_name+'","'+datetime+'");'}
   //   }
   //   
   //);
      
}
   
   
//function setmarker(location,lat,longt,truck,shipment,driver_name,group_name,datetime)
//   {
//
//      var marker = new nokia.maps.map.Marker(
//      new nokia.maps.geo.Coordinate(lat,longt),{
//         icon:"<?php //echo base_url();    ?>application/kookabura/images/truck3.png",
//
//
//
//         // Offset the top left icon corner so that it's
//         // Centered above the coordinate
//
//         $click : 'showBubble("'+location+'",'+lat+','+longt+',"'+truck+'","'+shipment+'","'+driver_name+'","'+group_name+'","'+datetime+'");'
//
//      }
//   );
//      // Next we need to add it to the map's object collection so it will be rendered onto the map.
//      map.objects.add(marker);
//   }   

</script>

