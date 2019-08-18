
		  
	  function applyMargins() {
        //var leftToggler = $(".mini-submenu-left");
		var leftToggler = $("#listButton");
		var routeToggler = $("#routeButton");
        var rightToggler = $(".mini-submenu-right");
        if (leftToggler.is(":visible") && routeToggler.is(":visible")) {
          $("#map .ol-zoom")
            .css("margin-left", 0)
            .removeClass("zoom-top-opened-sidebar")
            //.addClass("zoom-top-collapsed");
			.removeClass("zoom-top-collapsed");
        } else {
          $("#map .ol-zoom")
            .css("margin-left", $(".sidebar-left").width())
            .removeClass("zoom-top-opened-sidebar")
            .removeClass("zoom-top-collapsed");
        }
		
        if (rightToggler.is(":visible")) {
          $("#map .ol-rotate")
            .css("margin-right", 0)
            .removeClass("zoom-top-opened-sidebar")
            .addClass("zoom-top-collapsed");
        } else {
          $("#map .ol-rotate")
            .css("margin-right", $(".sidebar-right").width())
            .removeClass("zoom-top-opened-sidebar")
            .removeClass("zoom-top-collapsed");
        }
      }

      function isConstrained() {
        return $("div.mid").width() == $(window).width();
      }

      function applyInitialUIState() {
     //   if (isConstrained()) {
       /*   $(".sidebar-left .sidebar-body").fadeOut('slide');
          $(".sidebar-right .sidebar-body").fadeOut('slide');
          $('.mini-submenu-left').fadeIn();
          $('.mini-submenu-right').fadeIn();*/
		   $(".sidebar-left .sidebar-body").toggle('slide');
		/*   $('.sidebar-right .sidebar-body').toggle('slide');*/
       // }
	   $("#resetButton").hide();
      }
	  
	  $(document).ready(function() {
       $("#search-button").click(function() {
        //  $("#taskpane").toggle('slide');
		  $("#resetButton").show();
		  $("#search-button").hide();
       });
	   
	          $("#listButton").click(function() {
		  var thisEl = $(this); 
          
		  $("#accordion-left").show();
		  $("#accordion-left-route").hide(); 
		  $("#routeButton").show();
		//  if ($("#routeButton").is(":visible")) {};
	//	  $('.sidebar-left .sidebar-body').toggle('slide');
          thisEl.hide();
          applyMargins();
       });
	   
	          $("#routeButton").click(function() {
          var thisEl = $(this); 
          
		  $("#accordion-left-route").show();	
		  $("#accordion-left").hide();	
		  $("#listButton").show();
		 // if ($("#listButton").is(":visible")) {};  
		  //$('.sidebar-left .sidebar-body').toggle('slide');
          thisEl.hide();
          applyMargins();
       });

      });
	  
	  $(document).ready(function() {
       $("#resetButton").click(function() {
      //    $("#taskpane").toggle('slide');
		  $("#resetButton").hide();
		  $("#search-button").show();
		  
		  var container = $("#result");
          container.slideUp(300);
       });
      });
		
		  
      $(function(){
		  
		  
		var acc = document.getElementsByClassName("accordion");
		var i;
		
		for (i = 0; i < acc.length; i++) {
			acc[i].onclick = function(){
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
			}
		}
  
		  
        $('.sidebar-left .slide-submenu').on('click',function() {
          var thisEl = $(this);
          thisEl.closest('.sidebar-body').fadeOut('slide',function(){
            $('.mini-submenu-left').fadeIn();
			$("#listButton").fadeIn();
			$("#routeButton").fadeIn();
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
      });
	  
	  $(document).ready(function() {

    //When checkboxes/radios checked/unchecked, toggle background color
    $('.form-group').on('click','input[type=radio]',function() {
        $(this).closest('.form-group').find('.radio-inline, .radio').removeClass('checked');
        $(this).closest('.radio-inline, .radio').addClass('checked');
    });
    $('.form-group').on('click','input[type=checkbox]',function() {
        $(this).closest('.checkbox-inline, .checkbox').toggleClass('checked');
    });

    //Show additional info text box when relevant checkbox checked
    $('.additional-info-wrap input[type=checkbox]').click(function() {
        if($(this).is(':checked')) {
            $(this).closest('.additional-info-wrap').find('.additional-info').removeClass('hide').find('input,select').removeAttr('disabled');
        }
        else {
            $(this).closest('.additional-info-wrap').find('.additional-info').addClass('hide').find('input,select').val('').attr('disabled','disabled');
        }
    });

    //Show additional info text box when relevant radio checked
    $('input[type=radio]').click(function() {
        $(this).closest('.form-group').find('.additional-info-wrap .additional-info').addClass('hide').find('input,select').val('').attr('disabled','disabled');
        if($(this).closest('.additional-info-wrap').length > 0) {
            $(this).closest('.additional-info-wrap').find('.additional-info').removeClass('hide').find('input,select').removeAttr('disabled');
        }        
    });
});
var jssor_slider1;
var arrSlider = [];
var lastRandomVal = 0;
var map, featureList, boroughSearch = [], theaterSearch = [], museumSearch = [], selectedGalleryLayerArray = [];
        jssor_slider1_init = function (html = null, randomVal = 0) {
            var options = {
                $AutoPlay: 0,                                    //[Optional] Auto play or not, to enable slideshow, this option must be set to greater than 0. Default value is 0. 0: no auto play, 1: continuously, 2: stop at last slide, 4: stop on click, 8: stop on user navigation (by arrow/bullet/thumbnail/drag/arrow key navigation)
                $AutoPlaySteps: 4,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $Idle: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 160,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                $SlideWidth: 150,                                   //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                $SlideHeight: 100,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 3, 					                //[Optional] Space between each slide in pixels, default value is 0
                $Cols: 10,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                              //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)

                $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Rows: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 0,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 0,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },

                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 4                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };
			//console.log(html);
			
            var thumb_image = "";
			selectedGalleryLayerArray = [];
			//var currentIndex = jssor_slider1.$CurrentIndex();
			if(jssor_slider1 == null)
			{
				//console.log("init");
				jssor_slider1 = new $JssorSlider$('slider1_container', options);
			}
			if(html!= null)
			{			
				//html = removeDuplicates(html,"id");	
				
				console.log(html);
				for ( var i = 0;i< html.length;i++) 
				{					
					var item = html[i];
					console.log(item);
					for(var j = 0;j<item.length;j++)
					{
						var obj = item[j];
						//console.log(obj);
						var caption = obj.properties.Name;
						var wkt = obj.geometry;
						var feat = new ol.format.GeoJSON().readFeature(wkt).getGeometry();
						   var ext=feat.getExtent();
							var center = ol.extent.getCenter(ext);
							var lon=center[0];
							var lat=center[1];
						//console.log(lon);
						//console.log(lat);
						//console.log(feat);
						//console.log(center);
						
						var objItem = {};
						var idItem = obj.properties.Id;
						objItem.Id = idItem;
						objItem.data = new ol.format.GeoJSON().readFeature(wkt);
						objItem.wkt = wkt;
						objItem.name = caption;
						selectedGalleryLayerArray.push(objItem);
						//console.log(objItem);	
						//console.log(selectedGalleryLayerArray);
						var namaLayer = obj.id.split('.')[0];
						
						var PanoUrl = "";
						var linkimg = '/petakampus/pk-assets/image-data/thumb/'+namaLayer+'/'+obj.img_url;
						//linkimg = "http://localhost:8082/petakampus/wp-content/uploads/2017/11/13_88_itb-cirebon.jpg";//testing
						thumb_image += '<div onclick="ZoomToObject(\'' + caption + '\''+ ',' + '\'' + namaLayer + '\',\'' + idItem + '\''+ ',' + '\'' + PanoUrl + '\');"><img data-u="image"  src="'+linkimg+'" />  <div class="title">' +caption+ '</div> </div>';		
						//console.log(linkimg);
					}
					
				}
				
				if(selectedGalleryLayerArray.length < 10 )
				{
					var lessNumber = 9 - selectedGalleryLayerArray.length;
					for(var i= 0;i<lessNumber;i++)
					{
						thumb_image += '<div><img data-u="image" src="" /><div class="title">No Object</div> </div>';
					}
				}
				//console.log("reload");
				
				//arrSlider.push(thumb_image);
				
				jssor_slider1.$ReloadSlides(thumb_image);
			}
			
			lastRandomVal = randomVal;
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
				var screenWidth = window.screen.width;
                if (bodyWidth)
                    jssor_slider1.$ScaleWidth(Math.min(bodyWidth, screenWidth));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
			
			
			
          //  ScaleSlider();
          //  $Jssor$.$AddEvent(window, "load", ScaleSlider);

          //  $Jssor$.$AddEvent(window, "resize", ScaleSlider);
          //  $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            ////responsive code end
        };
		
window.getGalleryArray =  function ()
{
	//console.log(selectedGalleryLayerArray);
	return selectedGalleryLayerArray;
}
		
		function removeDuplicates(myArr, prop) {
			return myArr.filter((obj, pos, arr) => {
				return arr.map(mapObj => mapObj[prop]).indexOf(obj[prop]) === pos;
			});
}
		function AppendSlide(html)
		{
			//var currentIndex = jssor_slider1.$CurrentIndex();
			//console.log(jssor_slider1);
			//jssor_slider1.$AppendSlides(html, currentIndex);
		}
		
		$(document).ready(function() {
  			$('.footerDrawer .open').on('click', function() {
    			$('.footerDrawer .content').slideToggle();
  			});
		});