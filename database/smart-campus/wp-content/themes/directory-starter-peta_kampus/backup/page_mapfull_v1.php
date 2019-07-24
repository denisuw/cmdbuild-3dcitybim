<?php
/**
 * Template Name: Map Full
 *
 * @package Directory_Starter
 * @since 1.0.4
 */
get_header('map'); 
//get_header(); 
 ?>
<div>

<div class="navbar-offset"></div>
<div id="bar">
	<span class="text-center" id="collapse-navbar"><i class="fa fa-arrow-down" aria-hidden="true"></i></span>
</div>
<!-- div id="level">
	<button id="button-up"><i class="fa fa-arrow-up up"></i></button>
	<ul id="level-list"> -->
		<!-- <li>2</li>
		<li class="active">1</li>
		<li>0</li> -->
<!--	</ul>
	<button id="button-down"><i class="fa fa-arrow-down"></i></button>
</div> -->
<div id="map"></div>
<div id="popup" class="ol-popup">
  <a href="#" id="popup-closer" class="ol-popup-closer"></a>
  <div id="popup-content"></div>
</div>
<div class="row main-row">
  <div class="col-sm-4 col-md-3 sidebar sidebar-left pull-left" style="z-index: 99999; position: fixed;">
	<div id="accordion-left" class="panel-group sidebar-body">
	  <div class="panel panel-default">
		<div class="panel-heading">
		  <h4 class="panel-title">
		  	<a href="#layers" data-toggle="collapse">
		  	  <i class="fa fa-list-alt"></i>
		  	  Peta Dasar &amp; Mode Peta
		    </a>
		    <span class="pull-right slide-submenu">
			  <i class="fa fa-chevron-left"></i>
		    </span>
          </h4>
		</div>
        
		<div id="layers" class="panel-collapse collapse in">
		  <!--form action="" id="map-type"-->
			<div class="form-group">
			  <table width="100%" border="0">
			    <tr>
			      <td width="43%"><label class="radio-inline"><input type="radio" name="peta-dasar" id="peta-dasar-garis" checked value="peta-garis">Peta Garis</label>
				  <!--label><input type="radio" name="peta-dasar" checked value="peta-garis" />Peta Garis</label--></td>
			      <td width="57%"><label class="radio-inline"><input type="radio" name="mode-peta" id="mode-peta-2d" checked value="mode-2d">Dua Dimensi (2D)</label>
				  <!--label><input type="radio" name="mode-peta" checked value="mode-2d" />Dua Dimensi (2D)</label--></td>
		        </tr>
			    <tr>
			      <td><label class="radio-inline"><input type="radio" name="peta-dasar" id="peta-dasar-foto" value="peta-foto">Peta Foto</label>
					<!--label> input type="radio" name="peta-dasar" value="peta-foto" />Peta Foto</label--></td>
			      
					<td><label class="radio-inline"><input type="radio" name="mode-peta" id="mode-peta-3d" value="mode-3d">Tiga Dimensi (3D)</label>
			        <!-- input type="radio" name="mode-peta" value="mode-3d" />Tiga Dimensi (3D)</label--></td>
		        </tr>
		      </table>
			</div>
		  <!--/form-->
		</div>
	  </div>
	  
	  
	
              <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#properties">
                    <i class="fa fa-list-alt"></i>
                    Fitur &amp; Peta Tematik
                  </a>
                </h4>
              </div>
              <div id="properties" class="panel-collapse collapse in">
              
                <div class="panel-body-property">
                    <button class="accordion">Kampus ITB</button>
                    <div class="panelx">
					  <div class="form-group">
                      <div class="col-md-10 columns">
                    <label class="checkbox-inline" for="Checkboxes_Apple">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Apple" value="Apple">
                      Kampus Ganesa, Sabuga & Saraga
                    </label>
                    <label class="checkbox-inline" for="Checkboxes_Orange">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Orange" value="Orange">
                      Kampus Jatinangor
                    </label>
                    <label class="checkbox-inline" for="Checkboxes_Bananas">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Bananas" value="Bananas">
                      Rektorat ITB Taman Sari
                    </label>
                    
                </div>
                    </div>
					
					</div>
                    
                    <button class="accordion">Fasilitas Umum</button>
                    <div class="panelx">
                      <div class="form-group">
                      <div class="col-md-10 columns">
                    <label class="checkbox-inline" for="Checkboxes_Apple">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Apple" value="Apple">
                      Keran Air Minum 
                    </label>
                    <label class="checkbox-inline" for="Checkboxes_Orange">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Orange" value="Orange">
                      Keranjang Sampah
                    </label>
                    <label class="checkbox-inline" for="Checkboxes_Bananas">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Bananas" value="Bananas">
                      Lampu Taman
                    </label>
                    <label class="checkbox-inline" for="Checkboxes_Kumquats">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Kumquats" value="Kumquats">
                      Sepeda Kampus
                    </label>
                    <label class="checkbox-inline" for="Checkboxes_Kumquats">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Kumquats" value="Kumquats">
                      Toilet
                    </label>
                    <label class="checkbox-inline" for="Checkboxes_Kumquats">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Kumquats" value="Kumquats">
                      Lainnya
                    </label>
                </div>
                    </div>
                    </div>
                    
                    <button class="accordion">Kelas dan Laboratorium</button>
                    <div class="panelx">
                      <div class="form-group">
                      <div class="col-md-10 columns">
                    <label class="checkbox-inline" for="Checkboxes_Apple">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Apple" value="Apple">
                      Aula
                    </label>
                    <label class="checkbox-inline" for="Checkboxes_Orange">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Orange" value="Orange">
                      Auditorium
					</label>
                    <label class="checkbox-inline" for="Checkboxes_Bananas">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Bananas" value="Bananas">
                      Ruang Kuliah Umum
                    </label>
                    <label class="checkbox-inline" for="Checkboxes_Kumquats">
                      <input type="checkbox" name="Checkboxes" id="Checkboxes_Kumquats" value="Kumquats">
                      Ruang Kuliah Multimedia
                    </label>
                    
                </div>
                    </div>
                    </div>
                </div>
              </div>
            </div>
	  
	  
	</div>
	
	<div class="panel-group sidebar-body" id="accordion-left-route">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#routes">
                    <i class="fa fa-list-alt"></i>
                    Routes
                  </a>
                  <span class="pull-right slide-submenu">
                    <i class="fa fa-chevron-left"></i>
                  </span>
                </h4>
              </div>
              <div id="routes" class="panel-collapse collapse in">
                <div class="panel-body list-group">
              <!--    <form> -->
					<div class="input-group input-group-sm">
					  <input type="text" class="form-control" placeholder="Starting Point">
					  <div class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					  </div>
					</div>
					<p></p>
					<div class="input-group input-group-sm">
					  <input type="text" class="form-control" placeholder="Destination ..">
					  <div class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					  </div>
					</div>
					<p></p>
					<button type="submit" class="btn btn-primary">Find my way</button>
 <!-- </form> -->
                </div>
              </div>
            </div>
          </div>
		  
  </div>
  
  <div id="search">
	<div class="row">
	  <div class="col-md-12">		
		<form action="" id="form-search">
		  <div class="input-group">
                         
			<span class="input-group-btn" data-toggle="tooltip" title="Layer">
				
				<button class="btn btn-default" id="listButton">
					<span class="glyphicon glyphicon-list-alt"></span>
				</button>
				<button class="btn btn-default" id="routeButton">
					<span class="glyphicon glyphicon-tasks"></span>
				</button>
			</span>
			
			<input type="text" class="form-control" placeholder="Search" required id="search-input" name="param">
		   
			<span class="input-group-btn">
				
				<button type="reset" class="btn btn-default" id="resetButton">
					<span class="glyphicon glyphicon-remove">
						<span class="sr-only">Close</span>
					</span>
				</button>

			
				<button type="submit" class="btn btn-default" id="search-button" >
					<span class="glyphicon glyphicon-search">
						<span class="sr-only">Search</span>
					</span>
				</button>

				<button class="btn btn-default" type="button" id="filter-toggle">
					<i class="fa fa-arrow-down" aria-hidden="true"></i>
				</button>
			</span>
		  </div>
		<select name="filter" id="filter" class="form-control" onchange="doSomething(this);">
		  <option value="ganesa">Ganesa</option>
		  <option value="jatinangor">Jatinangor</option>
		  <option value="rektorat">Rektorat</option>
		</select>
		</form>
		<div id="result">
            <img class="img-responsive" src="/petakampus/pk-assets/images/loading.gif" id="loading-spinner" width="75px">
			<ul style="list-style-type: none; padding-left: 5px;" id="result-list"></ul>
		</div>
		
		  
	  </div>
	</div>
  </div>
	

<?php get_footer('map'); ?>

