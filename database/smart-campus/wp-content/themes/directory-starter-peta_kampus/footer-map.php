<div id="bottombar">
        <div class="footerDrawer">        
          <div class="open"><button id="button" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo">
      <span class="glyphicon glyphicon-collapse-down"></span> Show
    </button></div>
          <div class="content">
          <div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 1366px; height: 100px; overflow: hidden; ">


        <!-- Slides Container -->
        <div u="slides" style="position: absolute; left: 0px; top: 0px; width: 1366px; height: 100px; overflow: hidden; cursor: pointer;">
		
<?php
		$image_limit = '';
		if (defined('GEODIRPAYMENT_VERSION') && !empty($package_info) && isset($package_info->image_limit) && $package_info->image_limit !== '') {
			$image_limit = (int)$package_info->image_limit;
		}
		$post_images = petakampus_get_images_geo();
		$thumb_image = '';
		if ( ! empty( $post_images ) ) {
			$count = 1;
			foreach ( $post_images as $image ) {
				if ($image_limit !== '' && $count > $image_limit) {
					break;
				}
				$caption = ( ! empty( $image->caption ) ) ? $image->caption : '';
				//$thumb_image .= '<a href="' . $image->src . '" title="' . $caption . '">';
				//$thumb_image .= geodir_show_image( $image, 'thumbnail', true, false );
				//$thumb_image .= '</a>';
				$thumb_image .= '<div><img u="image" onclick="LineToObj(' . $image->latitude . ','. $image->longitude .');" src="' . $image->src . '" />  <div class="title">' . $caption . '</div> </div>';
				$count++;
			}
		}
		echo $thumb_image;
?>		

        </div>
        
        <!--#region Bullet Navigator Skin Begin -->
        <!-- Help: https://www.jssor.com/development/slider-with-bullet-navigator.html -->
        <style>
            /* jssor slider bullet navigator skin 03 css */
            /*
            .jssorb03 div           (normal)
            .jssorb03 div:hover     (normal mouseover)
            .jssorb03 .av           (active)
            .jssorb03 .av:hover     (active mouseover)
            .jssorb03 .dn           (mousedown)
            */
            .jssorb03 {
                position: absolute;
            }
            .jssorb03 div, .jssorb03 div:hover, .jssorb03 .av {
                position: absolute;
                /* size of bullet elment */
                width: 21px;
                height: 21px;
                text-align: center;
                line-height: 21px;
                color: white;
                font-size: 12px;
                background: url(img/b03.png) no-repeat;
                overflow: hidden;
                cursor: pointer;
            }
            .jssorb03 div { background-position: -5px -4px; }
            .jssorb03 div:hover, .jssorb03 .av:hover { background-position: -35px -4px; }
            .jssorb03 .av { background-position: -65px -4px; }
            .jssorb03 .dn, .jssorb03 .dn:hover { background-position: -95px -4px; }
        </style>
        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb03" style="bottom: 4px; right: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype"><div u="numbertemplate"></div></div>
        </div>
        <!--#endregion Bullet Navigator Skin End -->
        
        <!--#region Arrow Navigator Skin Begin -->
        <!-- Help: https://www.jssor.com/development/slider-with-arrow-navigator.html -->
        <style>
            /* jssor slider arrow navigator skin 03 css */
            /*
            .jssora03l                  (normal)
            .jssora03r                  (normal)
            .jssora03l:hover            (normal mouseover)
            .jssora03r:hover            (normal mouseover)
            .jssora03l.jssora03ldn      (mousedown)
            .jssora03r.jssora03rdn      (mousedown)
            .jssora03l.jssora03lds      (disabled)
            .jssora03r.jssora03rds      (disabled)
            */
            .jssora03l, .jssora03r {
                display: block;
                position: absolute;
                /* size of arrow element */
                width: 55px;
                height: 55px;
                cursor: pointer;
                background: url(img/a03.png) no-repeat;
                overflow: hidden;
            }
            .jssora03l { background-position: -3px -33px; }
            .jssora03r { background-position: -63px -33px; }
            .jssora03l:hover { background-position: -123px -33px; }
            .jssora03r:hover { background-position: -183px -33px; }
            .jssora03l.jssora03ldn { background-position: -243px -33px; }
            .jssora03r.jssora03rdn { background-position: -303px -33px; }

            .jssora03l.jssora03lds { background-position: -3px -33px; opacity: .3; pointer-events: none; }
            .jssora03r.jssora03rds { background-position: -63px -33px; opacity: .3; pointer-events: none; }
        </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora03l" style="top: 123px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora03r" style="top: 123px; right: 8px;">
        </span>
        <!--#endregion Arrow Navigator Skin End -->
        <!-- Trigger -->
        <script>
            jssor_slider1_init();
        </script>
    </div>
    <!-- Jssor Slider End -->
          </div>
        </div>
      </div>

<script src="/petakampus/pk-assets/inovamap/0.0.1/js/inovamap.js"></script>




</div> 
</body>
</html>