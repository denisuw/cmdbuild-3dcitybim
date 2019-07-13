$("#result").hide();
$("#sidebar-print").hide();
$("[class='checkbox']").bootstrapSwitch();
$("#filter").hide();
$(function(){ 

//Variables
window.app = {};
var app =window.app;


    app.ZoomExtentControl = function (opt_options) {

        var options = opt_options || {};
        this.extent_ = options.extent;

        var anchor = document.createElement('a');
        anchor.href = '#zoom-to';
        anchor.className = 'zoom-to';
        anchor.innerHTML = '<i class="fa fa-search"></i>';

        var this_ = this;
        var handleZoomTo = function (e) {
            this_.handleZoomTo(e);
        };

        anchor.addEventListener('click', handleZoomTo, false);
        anchor.addEventListener('touchstart', handleZoomTo, false);

        var element = document.createElement('div');
        element.className = 'zoom-extent ol-unselectable';
        element.appendChild(anchor);

        ol.control.Control.call(this, {
            element: element,
            map: options.map,
            target: options.target
        });

    };
    ol.inherits(app.ZoomExtentControl, ol.control.Control);

    
    app.ZoomExtentControl.prototype.handleZoomTo = function (e) {
        // prevent #zoomTo anchor from getting appended to the url
        e.preventDefault();

        var map = this.getMap();
        var view = map.getView();
        view.fit(this.extent_, map.getSize());
    };
    
    app.ZoomExtentControl.prototype.setMap = function (map) {
        ol.control.Control.prototype.setMap.call(this, map);
        if (map && !this.extent_) {
            this.extent_ = map.getView().getProjection().getExtent();
        }
    };

var extent = [11978075.73790395, -769427.4419890676, 11980402.28995238, -768128.0125082197];
var leftToggler = $("#listButton");
var routeToggler = $("#routeButton");
var rightToggler = $(".mini-submenu-right");
var baseLayers = [];
var backgroundLayers = [];
var overlayLayers = [];
var mainLayers = [];
var vectorLayer;
var lantai = [1, 0, -1];
var container = document.getElementById('popup');
var content = document.getElementById('popup-content');
var closer = document.getElementById('popup-closer');
 var popUpOver = new ol.Overlay(({
        element: container,
        autoPan: true,
        autoPanAnimation: {
          duration: 250
        }
      }));

//Openstreet map
var raster = new ol.layer.Tile({
  title:'OSM',
  name:'OSM',
  baseLayer: true,
  source: new ol.source.OSM(),
  opacity:1,
  visible:true
})

var raster2 = new ol.layer.Tile({
  title:'OSM',
  name:'OSM',
  baseLayer: true,
  source: new ol.source.XYZ({                  
    url: "http://server.arcgisonline.com/arcgis/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}"
  }),      
  // source: new ol.source.BingMaps({
  //   key: 'AqkI-QN2umsVxfBIsw9Syejpys2Cdi5jUYuJnT6selOp4z_TP68VZZSpS5Bk6dzS',
  //   imagerySet: ['Aerial', 'Road']
  // }),

  opacity:1,
  visible:false
})

var view = new ol.View({
  center: [11979129.1357, -768873.273534],
  zoom: 17
});
backgroundLayers.push(raster, raster2);
var source = new ol.source.Vector();

var vector = new ol.layer.Vector({
  source: source,
  style: new ol.style.Style({
    fill: new ol.style.Fill({
      color: 'rgba(255, 255, 255, 0.2)'
    }),
    stroke: new ol.style.Stroke({
      color: '#ffcc33',
      width: 2
    }),
    image: new ol.style.Circle({
      radius: 7,
      fill: new ol.style.Fill({
        color: '#ffcc33'
      })
    })
  })
});
//vector.setZIndex(999);
overlayLayers.push(vector);
//Initializing Map
$.ajax({
  url: '/helper/basemap-get.php',
  type: 'GET',
  success: function(response) {
    var json = $.parseJSON(response);
    json.data.forEach(function(item) {
        if(item.base_layer == "main_layer") {
        if(item.active == true) {
          if(item.name == "Ruangan") {
            var overlay = new ol.layer.Tile({
              title: item.title,
              name: item.name,
              baseLayer: false,
              source: new ol.source.TileWMS({
                url: item.url ,
                params: { 
                  'LAYERS' : item.params,
                  'CQL_FILTER' : "id_lantai like '%01'"
                },
                crossOrigin: 'anonymous' //'anonymous' //,                                
              }),
              showLegend:true,
              opacity: item.opacity,
              visible: item.visible,
              maxResolution: item.max_resolution,
              minResolution: item.min_resolution
            });
            overlayLayers.push(overlay);

          } else {
           var overlay = new ol.layer.Tile({
              title: item.title,
              name: item.name,
              baseLayer: false,
              source: new ol.source.TileWMS({
                url: item.url ,
                params: { 
                  'LAYERS' : item.params,
                },
                crossOrigin: 'anonymous' //'anonymous' //,                                
              }),
              showLegend:true,
              opacity: item.opacity,
              visible: item.visible,
              maxResolution: item.max_resolution,
              minResolution: item.min_resolution
            });
		//	overlay.setZIndex(999);
            overlayLayers.push(overlay);
          }
        }
      } else if(item.base_layer == "tile") {
        if(item.active==true)
        {
		  var bgLayer=new ol.layer.Tile({
            title: item.title,
                name: item.name,
                baseLayer: false,
                    source: new ol.source.XYZ({                  
                      url: item.url
                    }),                 
                    opacity:item.opacity,
                    //visible:item.visible,
					visible:false,
                    maxResolution: item.maxResolution,
                    minResolution: item.minResolution
                });
                baseLayers.push(bgLayer); 

        } 
      }
    });
  },
  error:function(err){
    console.log(err);
  },
  async: false
});


$(document).ajaxStop(function () {

});
var layersGroupDB=[
  new ol.layer.Group({
            title: 'Background',
            name:'Background',
            baseLayer:true,
            openInLayerSwitcher: true,
            layers: backgroundLayers
    }),  
    new ol.layer.Group({
              title: 'Tilemap',
              name:'Tilemap',
              baseLayer:true,
              openInLayerSwitcher: true,
              layers: baseLayers
      }),     
    new ol.layer.Group({
            title: 'Overlays',
            name:'Overlays',
            openInLayerSwitcher: false,
            layers: overlayLayers
    }),     
    new ol.layer.Group({
            title: 'Main Layers',
            name:'Main Layers',
            openInLayerSwitcher: false,
            layers: mainLayers
    })
]; 
// End Variables

//Main 

//Function

 closer.onclick = function() {
  popUpOver.setPosition(undefined);
  closer.blur();
  return false;
};
function capitalizeFirst(s)
{
    return s[0].toUpperCase() + s.slice(1);
}

function getInfo(layer, evt) {
  var layerSource = layer.get('visible') ? layer.getSource() :'';
  var url;
   
  if(layerSource.getGetFeatureInfoUrl!=undefined)
  {
    url = layerSource.getGetFeatureInfoUrl(evt.coordinate, view.getResolution(), view.getProjection(),
        {'INFO_FORMAT': 'application/json','FEATURE_COUNT': 5});                  
  } else {     
    // source.clear();
  }

    if (url) {
        
        // source.clear();
        $.getJSON(url, function(response) {
          
          if(response.features.length > 0)
          {
            var featureType=response.features[0].geometry.type;
            var selectedLayer;
            var id;
            var coord = evt.coordinate;
            var prettyCoord = ol.coordinate.toStringHDMS(ol.proj.transform(coord, 'EPSG:3857', 'EPSG:4326'), 3);
			//alert(coord);
            response.features.forEach(function(feature){
              id = feature.id;
              console.log(id);
              if (id.toLowerCase().indexOf("gedung") >= 0){
                name = feature.properties.nm_gedung;
                content.innerHTML = '<p>Nama Gedung : '+ name + '<br/>Link Gallery Gedung <br/>Foto Gedung<br/><img src="/helper/chilly.jpg" alt="Mountain View" style="width:100px;height:100px;"></p>';
              } else if (id.toLowerCase().indexOf("jalan") >= 0){
                name = feature.id;
                content.innerHTML = '<p>Nama Jalan : '+ name +'</p>';
              } else {
                name = feature.id;
                content.innerHTML = '<p>Nama : ' + name + '<br/>Link Gallery Gedung <br/>Foto Gedung<br/><img src="/helper/chilly.jpg" alt="Mountain View" style="width:100px;height:100px;"></p>';
              }
              popUpOver.setPosition(coord);
            });
        }
      });
    }
  }
  

  function zoomExtent() {
    map.getView().fit(extent, map.getSize());
  }

  //End function
/*
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function(){

      this.classList.toggle("active");


      var panel = this.nextElementSibling;
      if (panel.style.display === "block") {
        panel.style.display = "none";
      } else {
        panel.style.display = "block";
      }
    }
  }*/
/*
  $('.sidebar-left .slide-submenu').on('click',function() {
    var thisEl = $(this);
    thisEl.closest('.sidebar-body').fadeOut('slide',function(){
      $("#toolbar").css('margin-left', '0');
      $('#layer-panel').fadeIn();
      $('.ol-control').removeClass('margin-300');
      applyMargins();
    });
  });
  $('.mini-submenu-left').on('click',function() {
    var thisEl = $(this);
    $('.sidebar-left .sidebar-body').toggle('slide');
    thisEl.hide();
    applyMargins();
  });

  $('.sidebar-right .slide-submenu').on('click',function() {
    var thisEl = $(this);
    thisEl.closest('.sidebar-body').fadeOut('slide',function(){
      $('.mini-submenu-right').fadeIn();
      applyMargins();
    });
  });

  $('.mini-submenu-right').on('click',function() {
    var thisEl = $(this);
    $('.sidebar-right .sidebar-body').toggle('slide');
    thisEl.hide();
    applyMargins();
  });

  $(window).on("resize", applyMargins);

  applyInitialUIState();
  applyMargins();
*/  
  
  $("#myButton").click(function() {
    $("#taskpane").toggle('slide');
  });

  $("#layer-panel").on('click', function(e) {
    var thisEl = $(this);
    $("#toolbar").css('margin-left', '300px');
    $('.sidebar-left .sidebar-body').toggle('slide');
    $('.ol-control').addClass('margin-300');
    thisEl.hide();
    applyMargins();
  });


  //Zoom to extent
  // $("#zoom-extent").on('click', function(e) {
  //   zoomExtent();
  // })


  //Tooltip
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
  });

  $("#toolbar-modal").draggable();
  $("#form-type").draggable();
  $("#sidebar-print").draggable();
  $("#map3d").draggable();

  $("#map-tools").on('click', function(e) {
    $("#toolbar-modal").toggle(300);
  });

  $("#modal-shp-trigger").on('click', function(e) {
    $("#modal-shp").modal();
  });
  
  $("#clear-search").hide();

  $("#search").submit(function(e) {
    e.preventDefault();
    $("#result-list").html('');
	$("#loading-spinner").show();
    var $form = $("#form-search");
    var $inputs = $form.find("input");
    var serializeData = $form.serialize();
    var inpuValue = $("#search-input").val();
    if(inpuValue.length > 1) {
      $("#result").slideDown(300);
      $.ajax({
        url: '/helper/search.php',
        type: 'POST',
        data: serializeData,
        success: function(response) {
          var results = $.parseJSON(response); 
          // console.log(results);
          //searchButtonImage.attr('class', 'fa fa-times')
          var body;
          if(!results.error_status) {
			// first clear any existing features in the overlay
			featureOverlay.getSource().clear(); 
            $.each(results, function(i, item){
              $.each(item, function(j, value) {
                var header = '<h5>' + capitalizeFirst(j) + '</h5>';
                $("#result-list").append(header);
                $.each(value, function(k, realVal) {
                  var ext=new ol.format.GeoJSON().readFeature(realVal.geo).getGeometry().getExtent();
                  var center = ol.extent.getCenter(ext);
                  var lon=center[0];
                  var lat=center[1];
				  
				  //add map marker here
				  var iconFeature = new ol.Feature({
					  geometry: new ol.geom.Point(center).transform(UTM48Sprojection,'EPSG:3857'),
					  Nama: 'Null Island'
				  });
				  if(capitalizeFirst(j)=='Gedung') {iconFeature.setStyle(iconStyleBuilding);} else
					  {iconFeature.setStyle(iconStyleRoomEntrance);}
				 // feature.getGeometry().transform(UTM48Sprojection,'EPSG:3857');
				  featureOverlay.getSource().addFeature(iconFeature);
				  
                  var geom=new ol.format.GeoJSON().readFeature(realVal.geo).getGeometry();
                  var format = new ol.format.WKT();
                  var wkt = format.writeGeometry(geom);
                  var namaItem = (realVal.nm_gedung) ? realVal.nm_gedung : realVal.nama_ruang;
                  body = '<li style="padding: 5px;" onClick="CenterMapGeometry(\'' + wkt + '\'' + ',' + '\'' + namaItem + '\')"><img style="margin-right: 10px;" src="/petakampus/pk-assets/images/office-block.svg" class="img-responsive pull-left" width="20px">'+ namaItem + '</li><hr>';
                  $("#result-list").append(body);
				  $("#loading-spinner").hide();
				  $("#clear-search").show();
                })
              });
            })
          } else {
            body = '<p>'+ results.error +'</p>';
            $("#result-list").append(body);
          }
        },
        fail: function(response) {
          console.log("Error");
        }
      });
    } else {
      $("#result").slideUp(300);
    }
  })
  var searchButtonImage = $("#search-button i");
  
  $('#search-input').keyup(function(e) {
    e.preventDefault();
  });
  
  $("#filter-toggle").on('click', function(e) {
	$('#filter').slideToggle(500);
  });

  $("#clear-search").on('click', function(e) {
    featureOverlay.getSource().clear(); 
    $(searchButtonImage).attr('class', 'fa fa-search');
    $("#search-input").val('');
	$("#clear-search").hide();
  });

  $("#expand-search").on('click', function(e) {
    $("#search").toggle(300);
    $(this).toggleClass('add-border');
  });

  $("#close").on('click', function(e) {
    $("#toolbar-modal").hide(300);
  });

  $("#print-map").click(function(e) {
    $("#sidebar-print").toggle(400);
  });

  $(".close-print").click(function(e) {
    $("#sidebar-print").hide(400);
  });

  $('.toolbar-item').tooltip({
    tooltipClass: "mytooltip",
  });

  if($(window).width > 600) {
    $("#search").show();
  }

  var map = new ol.Map({
	//controls: ol.control.defaults({}, [    ]),
	//interactions: ol.interaction.defaults().extend([dragAndDropInteraction]),
	controls: ol.control.defaults({
    attributionOptions:({
      collapsible: true
    })
    
  }),
  
    layers: layersGroupDB,
    overlays: [popUpOver],
    target: 'map',
    projection: 'EPSG:4326',
    view: view
  });

  


var ol3d = new olcs.OLCesium({map: map}); // map is the ol.Map instance
var scene = ol3d.getCesiumScene();
var terrainProvider = new Cesium.CesiumTerrainProvider({
  url: '//assets.agi.com/stk-terrain/world'
});
scene.terrainProvider = terrainProvider;
  
  
  var highlightStyle = new ol.style.Style({
	stroke: new ol.style.Stroke({
	  color: [255,0,0,0.6],
	  width: 2
	}),
	fill: new ol.style.Fill({
	  color: [255,0,0,0.6]
	}),
	zIndex: 1
  });
  
var collection = new ol.Collection();
var featureOverlay = new ol.layer.Vector({
  map: map,
  source: new ol.source.Vector({
    features: collection,
    useSpatialIndex: false // optional, might improve performance
  }),
  style: highlightStyle,
  updateWhileAnimating: true, // optional, for instant visual feedback
  updateWhileInteracting: true // optional, for instant visual feedback
});

var iconStyleBuilding = new ol.style.Style({
  image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
    anchor: [0.5, 46],
    anchorXUnits: 'fraction',
    anchorYUnits: 'pixels',
    opacity: 0.75,
    src: '/pk-assets/images/mapmarker/office-building.png'
  }))
});

var iconStyleRoomEntrance = new ol.style.Style({
  image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
    anchor: [0.5, 46],
    anchorXUnits: 'fraction',
    anchorYUnits: 'pixels',
    opacity: 0.75,
    src: '/pk-assets/images/mapmarker/entrance.png'
  }))
});




proj4.defs("EPSG:32748","+proj=utm +zone=48 +south +ellps=WGS84 +datum=WGS84 +units=m +no_defs");
//Proj4js.defs["EPSG:32748"] = "+proj=utm +zone=48 +south +ellps=WGS84 +datum=WGS84 +units=m +no_defs";

var UTM48Sprojection = new ol.proj.Projection({
    code: 'EPSG:32748',
    extent:'166021.4431, 1116915.0440, 833978.5569, 10000000.0000',
    units: 'm'
});
ol.proj.addProjection(UTM48Sprojection);

      $("#collapse-navbar").on('click', function(e) {
        $("#site-header").slideToggle(300);
        $(".ds-top-header").slideToggle(300);
        $(this).children().toggleClass("fa fa-arrow-down fa fa-arrow-up");
        $("#map").toggleClass('high-map');
        setTimeout(function(){
          $("#search").toggleClass('high-search');
        }, 150);
      });
      function getWindowWidth() {
        var width = $(window).width();
        var height = $(window).height();

        if (width > 425) {
          $("#site-header").show();
          $(".ds-top-header").show();
          
        } else {
          $("#site-header").hide();
          $(".ds-top-header").hide();
          $("#map").removeClass('high-map');
          $("#search").removeClass('high-search');
          $("#collapse-navbar").children().attr('class', 'fa fa-arrow-down');
        } 

        if(height < 500) {
          if(width < 425) {
            $("#site-header").hide();
            $(".ds-top-header").hide();
            $("#map").removeClass('high-map');
            $("#search").removeClass('high-search');
            $("#collapse-navbar").children().attr('class', 'fa fa-arrow-down');
          }
        }
      }
        getWindowWidth();
        // Bind event listener
        $(window).resize(getWindowWidth);
        map.getView().on('propertychange', function(e) {

        switch (e.key) {
          case 'resolution':
          if(map.getView().getZoom() > 16) {
            $("#level").show();
          } else {
            $("#level").hide();
          }
          break;
        }
      });
    map.on('click', function(evt) {
      var layer = map.forEachLayerAtPixel(evt.pixel, function(layer) {      
        return layer;
      });
      if(layer.get('baseLayer') == true) {

      } else {
        getInfo(layer, evt)
      }    
    });
	
window.CenterMap =  function (lon, lat, zoomlevel) {

  map.getView().setCenter(ol.proj.transform([lon, lat],"EPSG:4326", "EPSG:3857"));	
  
  map.getView().setZoom(zoomlevel);
}
	
window.setInitial =  function (obj){
	obj._initValue = obj.value;
}
window.doSomething =  function (obj){
//if you want to verify a change took place...
if(obj._initValue == obj.value){
  //do nothing, no actual change occurred...
  //or in your case if you want to make a minor update
  //doMinorUpdate();
} else {
  //change happened
  //getNewData(obj.value);
  //alert(obj.value);
  if (obj.value == "ganesa") { 
  CenterMap(107.610368,-6.890886,16) } else if (obj.value == "jatinangor") 
  
  {CenterMap(107.769207,  -6.928818,16)}
}
}




window.CenterMapGeometry =  function (wkt, name) {
  var feature = new ol.format.WKT().readFeature(wkt);
  var buildingList = $("#result-list li");
  for (var i = buildingList.length - 1; i >= 0; i--) {
    $(buildingList[i]).removeClass('active');
    if($(buildingList[i]).text() === name) {
      $(buildingList[i]).addClass('active');
    }
  }
	feature.getGeometry().transform(UTM48Sprojection,'EPSG:3857');
	// first clear any existing features in the overlay
  featureOverlay.getSource().clear(); 
  featureOverlay.getSource().addFeature(feature);
  
  var ext=feature.getGeometry().getExtent();
	var center = ol.extent.getCenter(ext);
	var lon=center[0];
	var lat=center[1];
	
	popUpOver.setPosition(center);
   map.getView().setCenter([lon, lat]);	
  
  map.getView().setZoom(19);
  	

}


function addRandomFeature(lon,lat) {
    var x =lon;
    var y =lat;
    var geom = new ol.geom.Point(ol.proj.transform([x, y],
        'EPSG:32748', 'EPSG:3857'));
    var feature = new ol.Feature(geom);
    //source.addFeature(feature);
}

function SelectLantai(floor) {
    // alert(floor);
	
}
	

  $(document).mouseup(function (e)
  {
      var container = $("#result");

      if (!container.is(e.target) // if the target of the click isn't the container...
          && container.has(e.target).length === 0) // ... nor a descendant of the container
      {
          container.slideUp(300);
      }
  });
  $.each(lantai, function(index, value) {
    activeNumber = 0;
    isActive = activeNumber == value ? 'active' : '';
    var body = '<li class="'+ isActive +'">'+ value +'</li>';
    $("#level-list").append(body);
  });

  $("#button-up").click(function(e) {
    if(lantai[0] <= 10) {
      activeNumber++;
      lantai = lantai.map(function(val){return ++val;});
      $("#level-list").html('');
      $.each(lantai, function(index, val) {
        if(val <= 10) {
          isActive = activeNumber == val ? 'active' : '';
          var body = '<li class="'+ isActive +'">' + val + '</li>';
          $("#level-list").append(body);  		  
		      if (index==0) SelectLantai(lantai[1]);
		    }		
      });
      var cql = "id_lantai like '%"+ activeNumber +"'";
      console.log(cql);
      map.getLayers().forEach(function(layer){
        layer.getLayers().forEach(function(lyr){
          if(lyr.get('name') == 'Ruangan') {
            lyr.getSource().updateParams({"CQL_FILTER": cql});
            lyr.getSource().refresh({force: true});  
          }
        })     
      });   
    }
  });
  $("#button-down").click(function(e) {
    if(lantai[2] >= -2) {
      activeNumber--;
      console.log(lantai[2]);
      lantai = lantai.map(function(val){return --val;});
      $("#level-list").html('');
      $.each(lantai, function(index, val) {
        if(val >= -2) {
          isActive = activeNumber == val ? 'active' : '';
          var body = '<li class="'+ isActive +'">' + val + '</li>';
          $("#level-list").append(body);
		      if (index==0) SelectLantai(lantai[1]);
        }
      });
      var cql = "id_lantai like '%"+ activeNumber +"'";
      map.getLayers().forEach(function(layer){
        layer.getLayers().forEach(function(lyr){
          if(lyr.get('name') == 'Ruangan') {
            lyr.getSource().updateParams({"CQL_FILTER": cql});
            lyr.getSource().refresh({force: true});  
          }
        })     
      });   
    }	
  });

  $("#clear").on('click', function(e) {   
    featureOverlay.getSource().clear(); 
  });

  //Setting peta
  $("input[name=peta-dasar]").change(function(e) {
    var value = $(this).val();
    switch(value) {
      case 'peta-garis':
      raster.setVisible(true);
      raster2.setVisible(false);
      map.getLayers().forEach(function(layer){
        layer.getLayers().forEach(function(lyr){
          if(lyr.get('name') == "Foto") {
            lyr.setVisible(false);
          } else if(lyr.get('name') == "kampus-itb")
		  { lyr.setVisible(true); } 
		  else if(lyr.get('name') == "kampus-itb-foto")
		  { lyr.setVisible(false); }
        });     
      }); 
      break;

      case 'peta-foto':
      raster.setVisible(false);
      raster2.setVisible(true);
      map.getLayers().forEach(function(layer){
        layer.getLayers().forEach(function(lyr){
          if(lyr.get('name') == "Foto") {
            lyr.setVisible(true);
          } else if(lyr.get('name') == "kampus-itb")
		  {
		    lyr.setVisible(false);
		  } else if(lyr.get('name') == "kampus-itb-foto")
		  { lyr.setVisible(true); }
        });     
      }); 
      break;
    }
  });
  $("input[name=mode-peta]").change(function(e) {
    var value = $(this).val();
    switch(value) {
      case 'mode-2d':
        ol3d.setEnabled(false);
      break;

      case 'mode-3d':
        ol3d.setEnabled(true);
      break;
    }
  });

var wgs84Sphere = new ol.Sphere(6378137);
var activeNumber;
var draw;
var active;
var sketch;
var helpTooltipElement = null;
var helpTooltip;
var measureTooltipElement;
var measureTooltip;
var continuePolygonMsg = 'Click to continue drawing the polygon. Double clcik to finish';
var continueLineMsg = 'Click to continue drawing the line. Double click to finish';


      /**
       * Handle pointer move.
       * @param {ol.MapBrowserEvent} evt The event.
       */
      var pointerMoveHandler = function(evt) {
        if (evt.dragging) {
          return;
        }
        /** @type {string} */
        var helpMsg = 'Click to start drawing';

        if (sketch) {
          var geom = (sketch.getGeometry());
          if (geom instanceof ol.geom.Polygon) {
            helpMsg = continuePolygonMsg;
          } else if (geom instanceof ol.geom.LineString) {
            helpMsg = continueLineMsg;
          }
        }

        helpTooltipElement.innerHTML = helpMsg;
        helpTooltip.setPosition(evt.coordinate);

        helpTooltipElement.classList.remove('hidden');
      };


      var typeSelect = 'area'; //document.getElementById('type');
      var geodesicCheckbox = false; //document.getElementById('geodesic');

      var draw; // global so we can remove it later


      /**
       * Format length output.
       * @param {ol.geom.LineString} line The line.
       * @return {string} The formatted length.
       */
      var formatLength = function(line) {
        var length;
        if (geodesicCheckbox.checked) {
          var coordinates = line.getCoordinates();
          length = 0;
          var sourceProj = map.getView().getProjection();
          for (var i = 0, ii = coordinates.length - 1; i < ii; ++i) {
            var c1 = ol.proj.transform(coordinates[i], sourceProj, 'EPSG:4326');
            var c2 = ol.proj.transform(coordinates[i + 1], sourceProj, 'EPSG:4326');
            length += wgs84Sphere.haversineDistance(c1, c2);
          }
        } else {
          length = Math.round(line.getLength() * 100) / 100;
        }
        var output;
        if (length > 100) {
          output = (Math.round(length / 1000 * 100) / 100) +
              ' ' + 'km';
        } else {
          output = (Math.round(length * 100) / 100) +
              ' ' + 'm';
        }
        return output;
      };


      /**
       * Format area output.
       * @param {ol.geom.Polygon} polygon The polygon.
       * @return {string} Formatted area.
       */
      var formatArea = function(polygon) {
        var area;
        if (geodesicCheckbox.checked) {
          var sourceProj = map.getView().getProjection();
          var geom = /** @type {ol.geom.Polygon} */(polygon.clone().transform(
              sourceProj, 'EPSG:4326'));
          var coordinates = geom.getLinearRing(0).getCoordinates();
          area = Math.abs(wgs84Sphere.geodesicArea(coordinates));
        } else {
          area = polygon.getArea();
        }
        var output;
        if (area > 10000) {
          output = (Math.round(area / 1000000 * 100) / 100) +
              ' ' + 'km<sup>2</sup>';
        } else {
          output = (Math.round(area * 100) / 100) +
              ' ' + 'm<sup>2</sup>';
        }
        return output;
      };

      function addInteraction() {
        var type = (typeSelect == 'area' ? 'Polygon' : 'LineString');
        draw = new ol.interaction.Draw({
          source: source,
          type: /** @type {ol.geom.GeometryType} */ (type),
          style: new ol.style.Style({
            fill: new ol.style.Fill({
              color: 'rgba(255, 255, 255, 0.2)'
            }),
            stroke: new ol.style.Stroke({
              color: 'rgba(0, 0, 0, 0.5)',
              lineDash: [10, 10],
              width: 2
            }),
            image: new ol.style.Circle({
              radius: 5,
              stroke: new ol.style.Stroke({
                color: 'rgba(0, 0, 0, 0.7)'
              }),
              fill: new ol.style.Fill({
                color: 'rgba(255, 255, 255, 0.2)'
              })
            })
          })
        });
        map.addInteraction(draw);

        createMeasureTooltip();
        createHelpTooltip();

        var listener;
        draw.on('drawstart',
            function(evt) {
              // set sketch
              sketch = evt.feature;

              /** @type {ol.Coordinate|undefined} */
              var tooltipCoord = evt.coordinate;

              listener = sketch.getGeometry().on('change', function(evt) {
                var geom = evt.target;
                var output;
                if (geom instanceof ol.geom.Polygon) {
                  output = formatArea(geom);
                  tooltipCoord = geom.getInteriorPoint().getCoordinates();
                } else if (geom instanceof ol.geom.LineString) {
                  output = formatLength(geom);
                  tooltipCoord = geom.getLastCoordinate();
                }
                measureTooltipElement.innerHTML = output;
                measureTooltip.setPosition(tooltipCoord);
              });
            }, this);

        draw.on('drawend',
            function() {
              measureTooltipElement.className = 'tooltip tooltip-static';
              measureTooltip.setOffset([0, -7]);
              // unset sketch
              sketch = null;
              // unset tooltip so that a new one can be created
              measureTooltipElement = null;
              createMeasureTooltip();
              ol.Observable.unByKey(listener);
            }, this);
      }


      /**
       * Creates a new help tooltip
       */
      function createHelpTooltip() {
        if (helpTooltipElement) {
          helpTooltipElement.parentNode.removeChild(helpTooltipElement);
        }
        helpTooltipElement = document.createElement('div');
        helpTooltipElement.className = 'tooltip hidden';
        helpTooltip = new ol.Overlay({
          element: helpTooltipElement,
          offset: [15, 0],
          positioning: 'center-left'
        });
        map.addOverlay(helpTooltip);
      }


      /**
       * Creates a new measure tooltip
       */
      function createMeasureTooltip() {
        if (measureTooltipElement) {
          measureTooltipElement.parentNode.removeChild(measureTooltipElement);
        }
        measureTooltipElement = document.createElement('div');
        measureTooltipElement.className = 'tooltip tooltip-measure';
        measureTooltip = new ol.Overlay({
          element: measureTooltipElement,
          offset: [0, -15],
          positioning: 'bottom-center'
        });
        map.addOverlay(measureTooltip);
      }


      /**
       * Let user change the geometry type.
       
      typeSelect.onchange = function() {
        map.removeInteraction(draw);
        addInteraction();
      };

      addInteraction();
	  
	  map.on('pointermove', pointerMoveHandler);
	  
	  map.getViewport().addEventListener('mouseout', function() {
        helpTooltipElement.classList.add('hidden');
      });*/
});


