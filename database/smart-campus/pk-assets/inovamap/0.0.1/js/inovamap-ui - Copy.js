/*  function applyMargins() {
    var leftToggler = $("#listButton");
	var routeToggler = $("#routeButton");
    var rightToggler = $(".mini-submenu-right");
    if (leftToggler.is(":visible")) {
      $("#map .ol-zoom")
      .css("margin-left", 0)
      .removeClass("zoom-top-opened-sidebar")
      .addClass("zoom-top-collapsed");
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
  */
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
		$(".sidebar-left .sidebar-body").toggle('slide');
		$("#resetButton").hide();
	  }
    
	  $(document).ready(function() {
       $("#myButton").click(function() {
          $("#taskpane").toggle('slide');
		  $("#resetButton").show();
		  $("#myButton").hide();
       });
      });
	  
	  $(document).ready(function() {
       $("#resetButton").click(function() {
          $("#taskpane").toggle('slide');
		  $("#resetButton").hide();
		  $("#myButton").show();
       });
      });
	  
	  $(document).ready(function() {
       $("#listButton").click(function() {
		  var thisEl = $(this); 
          $('.sidebar-left .sidebar-body').toggle('slide');
		  $("#accordion-left").show();
		  $("#accordion-left-route").hide(); $("#routeButton").show();
		//  if ($("#routeButton").is(":visible")) {};
		  
          thisEl.hide();
          applyMargins();
       });
      });
	  
	  $(document).ready(function() {
       $("#routeButton").click(function() {
          var thisEl = $(this); 
          $('.sidebar-left .sidebar-body').toggle('slide');
		  $("#accordion-left-route").show();	
		  $("#accordion-left").hide();	$("#listButton").show();
		 // if ($("#listButton").is(":visible")) {};  
		  
          thisEl.hide();
          applyMargins();
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