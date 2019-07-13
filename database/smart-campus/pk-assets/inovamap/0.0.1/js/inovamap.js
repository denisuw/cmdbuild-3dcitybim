$("#result").hide();
$("#sidebar-print").hide();
$("[class='checkbox']").bootstrapSwitch();
$("#filter").hide();
document.getElementById("map3d").style.visibility = "hidden";

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
var lantaiStart =[1, 0, -1];
var lantai = [1, 0, -1];
var maxLantai = 10;
var minLantai = -2;
var container = document.getElementById('popup');
var content = document.getElementById('popup-content');
var closer = document.getElementById('popup-closer');
var divLayerMenu = document.getElementById('divLayerMenu');
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

//Get distinct Lantai
$.ajax({
  url: 'helper/floor-distinct-get.php',
  type: 'GET',
  success: function(response) {
	lantai = [];
    var json = $.parseJSON(response);
    json.data.forEach(function(item) {
			lantai.push(item.id_lantai);
    });
	
	console.log(lantai);
	maxLantai = getMaxOfArray(lantai);
	minLantai = getMinOfArray(lantai);
	
	console.log(maxLantai);
	console.log(minLantai);
  },
  error:function(err){
    console.log(err);
  },
  async: false
});

//Initializing Layer Menu
$.ajax({
  url: 'helper/basemap-category-get.php',
  type: 'GET',
  success: function(response) {
    var json = $.parseJSON(response);
	var strMenu = "";
	var lastCategory = "";
    json.data.forEach(function(item) {
		
		if(item.category_name != lastCategory)
		{
			if(lastCategory != "")
			{
				strMenu += "</div></div></div>";
			}
				strMenu += '<button class="accordion child">'+item.category_name+'</button>';
				strMenu += '<div class="panelx"><div class="form-group"><div class="col-md-10 columns">';

		}
		
		var checked = '';
		if(item.visible == true)
			checked = 'checked';
			
		strMenu += '<label class="checkbox-inline" for="'+item.name+'" > '+
                     '<input type="checkbox" class="layer_item" name="'+item.name+'" id="'+item.name+'" value="'+item.name+'" '+checked+'>'+item.title+'</label>';
		
		lastCategory = item.category_name;
    });
	
	divLayerMenu.innerHTML = strMenu;
	//divLayerMenu.innerHTML = '<button class="accordion">Test</button><div class="panelx"><div class="form-group"><div class="col-md-10 columns"><label class="checkbox-inline" for="Checkboxes_Apple"><input type="checkbox" name="Checkboxes" id="Checkboxes_Apple" value="Apple">Keran Air Minum </label> </div> </div> </div>';
  },
  error:function(err){
    console.log(err);
  },
  async: false
});

var acc = document.getElementsByClassName("child");
var i;

	for (i = 0; i < acc.length; i++) {
	  acc[i].addEventListener("click", function() {
		/* Toggle between adding and removing the "active" class,
		to highlight the button that controls the panel */
		this.classList.toggle("active");

		/* Toggle between hiding and showing the active panel */
		var panel = this.nextElementSibling;
		if (panel.style.display === "block") {
		  panel.style.display = "none";
		} else {
		  panel.style.display = "block";
		}
	  });
	}


	
//Initializing Map
$.ajax({
  url: 'helper/basemap-get.php',
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
                  'CQL_FILTER' : "NamaLantai like 'Lantai 1'"
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
			
			//console.log(overlay);
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
	
	//console.log(overlayLayers);
	var li = document.getElementsByClassName("layer_item");
	var i;

		for (i = 0; i < li.length; i++) {
		  li[i].addEventListener("change", function() {
			var objLayer = getLayerByName(this.value,overlayLayers);
			console.log(objLayer);
			if(objLayer != null)
			{
				if(this.checked) {
					objLayer.setVisible(true);
				} 
				else {
					objLayer.setVisible(false);
				}
			}
		});
		}
	
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

function getLayerByName(layerName, arrLayer)
{
console.log(arrLayer);
console.log(layerName);

	for(var i = 0;i<arrLayer.length;i++)
	{
	console.log(arrLayer[i].get('name'));
		if (arrLayer[i].get('name') == layerName)
		{
			return arrLayer[i];
		}
	}
	
	return null;
}

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
              console.log(feature);
			  console.log(id);
			  console.log(feature.properties.img_url);
			  
			  var namaLantai = "";
			  var namaGedung = "";
				
              if (id.toLowerCase().indexOf("gedung") >= 0){
                name = feature.properties.Name;
              } else if (id.toLowerCase().indexOf("jalan") >= 0){
                name = feature.id;
              }
			  else if (id.toLowerCase().indexOf("ruangan") >= 0)
			  {
                name = feature.properties.NamaRuang;
				namaLantai = feature.properties.NamaLantai;
				namaGedung = feature.properties.NamaGedung;
              }			  
			  else {
                name = feature.id;
              }
			  
			  getPopupContent(id, name, feature.properties.img_url , namaLantai,namaGedung);
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


var ol3d = new olcs.OLCesium({map: map}); // map is the ol.Map instance
var ol3dnew = new olcs.OLCesium({map: map, target: 'map3dmap'});
var scenenew = ol3dnew.getCesiumScene();
  
  
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
		  //alert(map.getView().getZoom());
          if(map.getView().getZoom() > 17) {
            $("#level").show();
			var ruang = getLayerByName("Ruangan",overlayLayers);
			if(ruang != null)
			{
				ruang.setVisible(true);
			}
          } else {
            $("#level").hide();
			var ruang = getLayerByName("Ruangan",overlayLayers);
			if(ruang != null)
			{
				ruang.setVisible(false);
			}
          }
          break;
        }
      });
	  
	  //map click
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

window.doSomething2 =  function (text){

  if (text == "ganesa") { 
  CenterMap(107.610368,-6.890886,16) } else if (text == "jatinangor") 
  
  {CenterMap(107.769207,  -6.928818,16)}
}



var imageStyle = new ol.style.Circle({
  radius: 10,
  fill: null,
  stroke: new ol.style.Stroke({
    color: 'rgba(255,255,0,0.9)',
    width: 3
  })
});
var strokeStyle = new ol.style.Stroke({
  color: 'rgba(255,255,0,0.9)',
  width: 3
});


window.LineToObj = function (lat, lon) {
var point = null;
var line = null;

  alert (lon + " " + lat);
}


window.CenterMapGeometry =  function (wkt, name, header) {
  var feature = new ol.format.WKT().readFeature(wkt);
  var buildingList = $("#result-list li");
  for (var i = buildingList.length - 1; i >= 0; i--) {
    $(buildingList[i]).removeClass('active');
    if($(buildingList[i]).text() === name) {
      $(buildingList[i]).addClass('active');
    }
  }
	//feature.getGeometry().transform(UTM48Sprojection,'EPSG:3857');
	// first clear any existing features in the overlay
  featureOverlay.getSource().clear(); 
  featureOverlay.getSource().addFeature(feature);
  
   var ext=feature.getGeometry().getExtent();
	var center = ol.extent.getCenter(ext);
	var lon=center[0];
	var lat=center[1];
	//console.log(center);
	console.log(header);
	//search by properties Id
	//var ruang = getLayerByName("Ruangan",overlayLayers);
	//console.log(overlayLayers);
	getPopupContent(header, name, "" , "","");
	
	popUpOver.setPosition(center);
   map.getView().setCenter([lon, lat]);	
  
  map.getView().setZoom(19);
  	

}

function getPopupContent(layername, itemname, imgurl , namaLantai = null,namaGedung = null)
{
	//var name = "";
	var str = "";
	var lyr = layername.split(".");
	lyr = lyr[0];
	
	name = itemname;
	content.innerHTML = '<div class="media"><a href="#" class="pull-left"><img src="/petakampus/pk-assets/image-data/'+lyr+'/'+imgurl+'" class="media-object" style="width:100px;height:100px; alt="'+name+'"></a><div class="media-body"><h4 class="media-heading">'+lyr+': '+	name+'</h4></div></div>';
		
	/*if (layername.toLowerCase().indexOf("gedung") >= 0){
        name = itemname;
		content.innerHTML = '<div class="media"><a href="#" class="pull-left"><img src="/petakampus/pk-assets/image-data/Gedung/'+imgurl+'" class="media-object" style="width:100px;height:100px; alt="'+name+'"></a><div class="media-body"><h4 class="media-heading">'+lyr+': '+name+'</h4></div></div>';
    } else if (layername.toLowerCase().indexOf("jalan") >= 0){
      name = itemname;
      content.innerHTML = '<p>Nama Jalan : '+ name +'</p>';
    }
	else if (layername.toLowerCase().indexOf("ruangan") >= 0)
	{
        name = itemname;
		content.innerHTML = '<div class="media"><a href="#" class="pull-left"><img src="/petakampus/pk-assets/image-data/Ruang/'+imgurl+'" class="media-object" style="width:100px;height:100px; alt="'+name+'"></a><div class="media-body"><h4 class="media-heading">'+lyr+': '+	name+'</h4></div></div>';
    }			  
	else {
        name = itemname;
		content.innerHTML = '<div class="media"><a href="#" class="pull-left"><img src="/petakampus/pk-assets/image-data/Pohon/'+imgurl+'" class="media-object" style="width:100px;height:100px; alt="'+name+'"></a><div class="media-body"><h4 class="media-heading">'+name+'</h4><p> 	Deskripsi	</p></div></div>';
    }*/
	
	//return str;
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
	
$("#search").submit(function(e) {
    e.preventDefault();
    $("#result-list").html('');
	$("#loading-spinner").show();
	//$("#result").slideDown(300);
    var $form = $("#form-search");
    var $inputs = $form.find("input");
    var serializeData = $form.serialize();
    var inpuValue = $("#search-input").val();
    if(inpuValue.length > 1) {
      $("#result").slideDown(300);
      $.ajax({
        url: 'helper/search.php',
        type: 'POST',
        data: serializeData,
        success: function(response) {
          var results = $.parseJSON(response); 
          // console.log(results);
          //searchButtonImage.attr('class', 'fa fa-times')
          var body;
          if(!results.error_status) {
			if(results.rowcount > 0)
			{
				// first clear any existing features in the overlay
				featureOverlay.getSource().clear(); 
				$.each(results, function(i, item)
				{
				  $.each(item, function(j, value) 
				  {					
					var header = '<h5>' + capitalizeFirst(j) + '</h5>';
					$("#result-list").append(header);
					$.each(value, function(k, realVal) 
					{
					
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
					  console.log(center);
					  
					  var wkt = format.writeGeometry(geom);
					  console.log(realVal);
					  var namaItem = (realVal.Name) ? realVal.Name : realVal.NamaRuang;
					  var idItem = realVal.Id;
					  body = '<li style="padding: 5px;" onClick="CenterMapGeometry(\'' + wkt + '\'' + ',' + '\'' + namaItem + '\''+ ',' + '\'' + capitalizeFirst(j) + '\')"><img style="margin-right: 10px;" src="/pk-assets/images/office-block.svg" class="img-responsive pull-left" width="20px">'+ namaItem + '</li><hr>';
					  $("#result-list").append(body);
					  $("#loading-spinner").hide();
				//	  $("#clear-search").show();
					})
				  });
				})
			}
			else
			{
				$("#loading-spinner").hide();
				$("#result-list").append("<p><span style='padding-left:15px;margin-top:15px;'>Data tidak ditemukan</span></p>");
			}
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
  
 /* $(document).mouseup(function (e)
  {
      var container = $("#result");

      if (!container.is(e.target) // if the target of the click isn't the container...
          && container.has(e.target).length === 0) // ... nor a descendant of the container
      {
          container.slideUp(300);
      }
  });
  */

  $.each(lantaiStart, function(index, value) {
    activeNumber = 0;
    isActive = activeNumber == value ? 'active' : '';
	if(value >= 0)
	{
        value = "L"+(value+1);
    }
	else
	{
		value = "B"+(value*-1);
	}
	
    var body = '<li class="'+ isActive +'">'+ value +'</li>';
    $("#level-list").append(body);
  });

  $("#button-up").click(function(e) {
  console.log(activeNumber);
    if(activeNumber < maxLantai) 
	{
      activeNumber++;
	 
      $("#level-list").html('');
	  //console.log(lantai);
      $.each(lantai, function(index, val) 
	  {
		//console.log("val:"+val);
		//console.log("index:"+index);
		if(val == activeNumber ||  val == (activeNumber+ 1) || val == (activeNumber- 1))
		{
			if(val <= maxLantai) 
			{
			  isActive = activeNumber == val ? 'active' : '';
			  if(val >= 0)
				{
					val = "L"+(val+1);
				}
				else
				{
					val = "B"+(val*-1);
				}
				console.log("val:"+val+" "+isActive);
			  var body = '<li class="'+ isActive +'">' + val + '</li>';
			  $("#level-list").append(body);  		  
				  if (index==0) SelectLantai(lantai[1]);
			}		
		}
      });
      var cql = "id_lantai = "+ activeNumber +"";
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
   console.log(lantai);
    if(activeNumber > minLantai) {
      activeNumber--;
      console.log(lantai[2]);
      //lantai = lantai.map(function(val){return --val;});
      $("#level-list").html('');
      $.each(lantai, function(index, val) {
	  if(val == activeNumber ||  val == (activeNumber+ 1) || val == (activeNumber- 1))
		{
			if(val >= minLantai) {
			  isActive = activeNumber == val ? 'active' : '';
			  if(val >= 0)
				{
					val = "L"+(val+1);
				}
				else
				{
					val = "B"+(val*-1);
				}
			  var body = '<li class="'+ isActive +'">' + val + '</li>';
			  $("#level-list").append(body);
				  if (index==0) SelectLantai(lantai[1]);
			}
		}
      });
      var cql = "id_lantai = "+ activeNumber +"";
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

  $("#clear").on('click', function(e) {   
    featureOverlay.getSource().clear(); 
  });

  function getMaxOfArray(numArray) {
	return Math.max.apply(null, numArray);
	}
	
	function getMinOfArray(numArray) {
	return Math.min.apply(null, numArray);
	}

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
  $("input[type=radio][name=mode-peta]").change(function(e) {
    var value = $(this).val();
	//alert(value);
    switch(value) {
      case 'mode-2d':
        ol3d.setEnabled(false);
      break;

      case 'mode-3d':
	  	//alert('aaa');
		getBuildingData();
        ol3d.setEnabled(true);
		var scene = ol3d.getCesiumScene();
		var terrainProvider = new Cesium.CesiumTerrainProvider({
		  url : Cesium.IonResource.fromAssetId(3956), //ayaw
				requestVertexNormals : true
		});
		scene.terrainProvider = terrainProvider;	

	 
      break;
    }
  });
  
  function getBuildingData()
  {  	
//alert('aaa');
	var getbuilding;
	//var buildingid=[];
	var buildingid=[];
	var citydbname = 'petakampusitb';
	
	var buildings=[];
	var lod=4;
	var lod=4;
	
	 $.post('helper/requestdata.php?request=2',{lod:lod},function(dbbuilding){

           var parsed = JSON.parse(dbbuilding);          

           for(var x in parsed){
                buildings.push(parsed[x]);
                
        	    getbuilding = JSON.parse(buildings[x]);
        	    buildingid.push(getbuilding.crs.properties.building);
                
                
              }
            var checking=true; 
            var defaultstyle=new ol.style.Style({
             fill: new ol.style.Fill({
             color: '#ffcc33'
              }),
             stroke: new ol.style.Stroke({
              color: '#000000',
              width: 2
              }),
              image: new ol.style.Circle({
              radius: 7,
              fill: new ol.style.Fill({
                color: '#ffcc33'
               })
             })
             });
            
			console.log(defaultstyle);
             for(var i=0;i<buildings.length;i++)
             {
             	var vectorsource = new ol.source.Vector();
             
                 var geojsonFormat = new ol.format.GeoJSON();
                var features = geojsonFormat.readFeatures(buildings[i],
                   {featureProjection: 'EPSG:3857'});
                   vectorsource.addFeatures(features);
             
	           var json=new ol.layer.Vector({
                 title: citydbname+"_building_lod"+lod+"_"+buildingid[i],
                 source: vectorsource,
                 style: defaultstyle
                    });
              
                map.addLayer(json);
               // var layer = findBy(ol2d.getLayerGroup(),citydbname);
                setTimeout(function() {
                        map.getView().fit(json.getSource().getExtent(), map.getSize());
                       }, 200);                
                }               
      	 });
  }
  
  $("#sidebyside").click(function(e) {   
  //alert(document.getElementById("map3d").style.visibility=="hidden");
	if(document.getElementById("map3d").style.visibility=="hidden")
	  {
		$("#map3d").css('visibility','visible');
		ol3dnew.setEnabled(true);
			var scene = ol3dnew.getCesiumScene();
			var terrainProvider = new Cesium.CesiumTerrainProvider({
			  url : Cesium.IonResource.fromAssetId(3956), //ayaw
					requestVertexNormals : true
			});
			scene.terrainProvider = terrainProvider;	
	  }
	  else
	  {
		$("#map3d").css('visibility','hidden');
		ol3dnew.setEnabled(false);	
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
	  
	  var pin_icon = '//cdn.rawgit.com/jonataswalker/ol3-contextmenu/master/examples/img/pin_drop.png';
var center_icon = '//cdn.rawgit.com/jonataswalker/ol3-contextmenu/master/examples/img/center.png';
var list_icon = '//cdn.rawgit.com/jonataswalker/ol3-contextmenu/master/examples/img/view_list.png';

var contextmenu_items = [
{
    text: 'Direction from here',
    classname: 'bold',
    icon: center_icon,
    callback: center
  },
  {
    text: 'Direction to here',
    classname: 'bold',
    icon: center_icon,
    callback: center
  },
  {
    text: 'Center map here',
    classname: 'bold',
    icon: center_icon,
    callback: center
  },
  {
    text: 'Some Actions',
    icon: list_icon,
    items: [
      {
        text: 'Center map here',
        icon: center_icon,
        callback: center
      },
      {
        text: 'Add a Marker',
        icon: pin_icon,
        callback: marker
      }
    ]
  },
  {
    text: 'Add a Marker',
    icon: pin_icon,
    callback: marker
  },
  '-' // this is a separator
];

var contextmenu = new ContextMenu({
  width: 180,
  items: contextmenu_items
});
map.addControl(contextmenu);
var removeMarkerItem = {
  text: 'Remove this Marker',
  classname: 'marker',
  callback: removeMarker
};

contextmenu.on('open', function (evt) {
  var feature =	map.forEachFeatureAtPixel(evt.pixel, ft => ft);
  
  if (feature && feature.get('type') === 'removable') {
    contextmenu.clear();
    removeMarkerItem.data = { marker: feature };
    contextmenu.push(removeMarkerItem);
  } else {
    contextmenu.clear();
    contextmenu.extend(contextmenu_items);
    contextmenu.extend(contextmenu.getDefaultItems());
  }
});

map.on('pointermove', function (e) {
  if (e.dragging) return;

  var pixel = map.getEventPixel(e.originalEvent);
  var hit = map.hasFeatureAtPixel(pixel);

  map.getTargetElement().style.cursor = hit ? 'pointer' : '';
});

// from https://github.com/DmitryBaranovskiy/raphael
function elastic(t) {
  return Math.pow(2, -10 * t) * Math.sin((t - 0.075) * (2 * Math.PI) / 0.3) + 1;
}

function center(obj) {
  view.animate({
    duration: 700,
    easing: elastic,
    center: obj.coordinate
  });
 }

 function removeMarker(obj) {
  vectorLayer.getSource().removeFeature(obj.data.marker);
}

function marker(obj) {
  var coord4326 = ol.proj.transform(obj.coordinate, 'EPSG:3857', 'EPSG:4326'),
      template = 'Coordinate is ({x} | {y})',
      iconStyle = new ol.style.Style({
        image: new ol.style.Icon({ scale: .6, src: pin_icon }),
        text: new ol.style.Text({
          offsetY: 25,
          text: ol.coordinate.format(coord4326, template, 2),
          font: '15px Open Sans,sans-serif',
          fill: new ol.style.Fill({ color: '#111' }),
          stroke: new ol.style.Stroke({ color: '#eee', width: 2 })
        })
      }),
      feature = new ol.Feature({
        type: 'removable',
        geometry: new ol.geom.Point(obj.coordinate)
      });

  feature.setStyle(iconStyle);
  vectorLayer.getSource().addFeature(feature);
}




	  
});

$("#filter-toggle").on('click', function(e) {
	$('#filter').slideToggle(500);
});

