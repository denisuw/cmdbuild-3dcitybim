(function() {

 Ext.define('CMDBuild.controller.common.field.display.Text', {
  extend: 'CMDBuild.controller.common.abstract.Base',

  uses: ['CMDBuild.core.constants.Proxy'],

  /**
   * @cfg {Mixed}
   */
  parentDelegate: undefined,

  /**
   * @cfg {Array}
   */
  cmfgCatchedFunctions: [
   'onFieldDisplayTextDetailsButtonClick',
   'onFieldDisplayCCTVButtonClick',
   'onFieldDisplayPanoDetailsButtonClick',
   'onFieldDisplayTextRawValueGet',
   'onFieldDisplayTextReset',
   'onFieldDisplayTextValueGet',
   'onFieldDisplayTextValueIsValid',
   'onFieldDisplayTextValueSet',
   'panelGridAndFormSelectedItemGet'
  ],

  /**
   * @property {CMDBuild.view.common.field.display.DetailsWindow}
   */
  detailsWindow: undefined,

  /**
   * @property {CMDBuild.view.common.field.display.Text}
   */
  view: undefined,

  /**
   * @param {Object} configurationObject
   * @param {CMDBuild.view.common.field.display.Text} configurationObject.view
   *
   * @returns {Void}
   *
   * @override
   */
  constructor: function(configurationObject) {
   this.callParent(arguments);
   //console.log(configurationObject);
   //console.log(this);
   //console.log(arguments);
   // Details window build

   if (this.fieldLabel != "FileName") {
    this.detailsWindow = Ext.create('CMDBuild.view.common.field.display.DetailsWindow', {
     title: this.view.fieldLabel
    });
   }
  },

  /**
   * @returns {Void}
   */
  onFieldDisplayTextDetailsButtonClick: function() {
   //alert("onFieldDisplayTextDetailsButtonClick58");
   this.detailsWindow.configureAndShow(this.cmfg('onFieldDisplayTextValueGet'));

  },
  onFieldDisplayCCTVButtonClick: function() 
  {
	var url = this.cmfg('onFieldDisplayTextValueGet');
		var myTopToolbar = {
							text : url,
							handler :function(){
								// I disable the parent window.
								x.disable();

							}};
		var str = "<div id=\"bck\" class=\"overlay\"></div> "+
							"<div id=\"modal-video\" class=\"overlay-modal\"> "+
							  "<video id=\"video_element\" class=\"vid\" width=\"100%\" autoplay>"+
								 "<source id=\"video1\" src=\"\" type=\"video/mp4\">"+
								  "Your browser does not support HTML5 video."+
							  "</video>"+
							"</div>";
		var x = Ext.create("Ext.Window",{
						title : 'Outdoor CCTV Live Streaming',
						width : 1000,
						height: 500,
						html : str
					}).show();	
		function fadeIn(el) {   
							el.style.opacity = 0;
							el.style.display = "block";
							var tick = function() {
								el.style.opacity = +el.style.opacity + 0.05;
								if (+el.style.opacity <= 0.8) {
									(window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 10)
								}
							};
							tick();
						}   

						function show_modal(){
							document.getElementById('modal-video').style.display = 'block';
						}

						//plays the video in cinema-view
						function play_video(vid){
							var vid = vid;
							//disable background
							var el = document.getElementById("bck");
							document.getElementsByTagName('body')[0].style.overflow = 'hidden';
							fadeIn(el);
							el.style.display = 'block';

							//show video modal
							var el = document.getElementById("modal-video");
							fadeIn(el);
							el.style.opacity ='1';
							setTimeout(show_modal, 800);
							//To set the source you need to select 
							var video = document.getElementById("video_element");
							video.src = vid;
							video.play();
						}

						var overlay = document.getElementById('bck');
						fadeIn(overlay);
						play_video(url);	
  },
  onFieldDisplayPanoDetailsButtonClick: function() {
   //alert("onFieldDisplayPanoDetailsButtonClick");		

   var selectCardId = "";
   var name = "selectCardId" + "=";
   var decodedCookie = decodeURIComponent(document.cookie);
   var ca = decodedCookie.split(';');
   for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
     c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
     selectCardId = c.substring(name.length, c.length);
    }
   }


   var params = {};
   var Pitch = 0;
   var Yaw = 0;
   Ext.Ajax.request({
    url: '/cmdbuild/services/json/management/modcard/getcard',
    method: 'GET',
    timeout: 60000,
    async: false,
    params: {
     cardId: selectCardId,
     className: "HotspotPano"
    },
    success: function(response) {
     //console.log(response);
     var jsonData = JSON.parse(response.responseText);
     //console.log(jsonData);
     if (jsonData.success) {
      params.cardId = jsonData.card.CardId;
      params.className = jsonData.card.ClassName;
      params.fileName = jsonData.card.FileName;
      Pitch = jsonData.card.Pitch;
      Yaw = jsonData.card.Yaw;
      //console.log(jsonData.card.IdClass);
      //console.log(jsonData.card.ClassName);
      //console.log(jsonData.card.FileName);

     }

    },
    failure: function(response) {
     Console.log('Request Failed.');

    }
   });

   var arrHotspot = [];
   var objHotspot = {};
   objHotspot.pitch = Pitch;
   objHotspot.yaw = Yaw;
   objHotspot.type = "info";
   objHotspot.text = "";
   objHotspot.URL = "";
   arrHotspot.push(objHotspot);

   var urlPano = CMDBuild.proxy.index.Json.attachment.download + '?' + Ext.urlEncode(params);

   var x = Ext.create("Ext.Window", {
    title: 'Filename - Panorama',
    width: 1000,
    height: 500,
    html: "<div id=\"panorama\"></div>"
   }).show();
   var viewer = pannellum.viewer('panorama', {
    "type": "equirectangular",
    "panorama": urlPano,
    "autoLoad": true,
    "hotSpots": arrHotspot

   });
   viewer.setYaw(Yaw);
   viewer.setPitch(Pitch);

   //this.detailsWindow.configureAndShowPano("pano"+params.cardId,urlPano,arrHotspot,Yaw,Pitch);

  },
  /**
   * @returns {String}
   */
  onFieldDisplayTextRawValueGet: function() {
   //console.log(this.view.displayField);
   return this.view.displayField.getRawValue();
  },

  /**
   * @returns {Void}
   */
  onFieldDisplayTextReset: function() {
   this.view.detailsButton.hide();
   this.view.displayField.reset();
  },

  /**
   * @returns {String}
   */
  onFieldDisplayTextValueGet: function() {
   return this.view.displayField.getValue();
  },
  /**
   * @returns {Boolean}
   */
  onFieldDisplayTextValueIsValid: function() {
   return this.view.displayField.isValid();
  },

  /**
   * @param {String or Object} value
   *
   * @returns {Void}
   */
  onFieldDisplayTextValueSet: function(value) {
   if (!Ext.isEmpty(value)) {
    this.view.displayField.setValue(value);

    if (this.view.isVisible() && this.view.displayField.getHeight() > this.view.maxHeight) {
     this.view.detailsButton.show();
     this.view.displayField.setHeight(this.view.maxHeight);
    }
   }
  }
 });

})();