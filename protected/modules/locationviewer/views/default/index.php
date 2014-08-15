<?php
$cs = Yii::app()->getClientScript();
$cs->registerCssFile(Yii::app()->baseUrl . '/css/jqx.base.css');
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jqxcore.js',CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl . '/js/jqxsplitter.js',CClientScript::POS_END);
$this->breadcrumbs=array(
	$this->module->id,
);
?>
<style type="text/css">
        
        #mapContainer {
				width: 100%;
				height: 100%;
			}
</style>
<div id="row">
    <div id="mainSplitter">

        <div>
            <div id="rightSplitter">
                <div>
                    <div id="mapContainer"></div>
                </div>
                <div>
                    Bottom-Right Panel</div>
            </div>
        </div>
        <div>
            search
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


        // Get the DOM node to which we will append the map
        var mapContainer = document.getElementById("mapContainer");
        // Create a map inside the map container DOM node
        var map = new nokia.maps.map.Display(mapContainer, {
                // initial center and zoom level of the map
                center: [52.51, 13.4],
                zoomLevel: 10,
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
                        new nokia.maps.map.component.ContextMenu(),
                        // ZoomRectangle component adds zoom rectangle functionality to the map
                        new nokia.maps.map.component.ZoomRectangle()
                ]
        });
    });
</script>

