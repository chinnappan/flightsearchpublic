<?php   
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	require_once('class/flightclass.php');
	$param 						=	array();
	$param['post']				=	$_POST;
	$flightObj 					= 	new FlightSearch();
	$flightOnwardDetails 		= 	$flightObj->onwardJourney($param);
	$flightJourneyOnward 		= 	$flightOnwardDetails['flightJourneyOnward'];

	$carrierNameOnward 			= 	$flightOnwardDetails['carrierName'];
	$lowestPriceFlightOnward 	= 	current($flightJourneyOnward);
	$higestPriceFlightOnward 	= 	end($flightJourneyOnward);
	//print_r($flightOnwardDetails);
	if($param['post']['trip']=='Return Trip'){
		$flightReturnDetails 		= 	$flightObj->returnJourney($param);
		$flightJourneyReturn		= 	$flightReturnDetails['flightJourneyReturn'];
		
		$lowestPriceFlightReturn	= 	current($flightJourneyReturn);
		$higestPriceFlightReturn	= 	end($flightJourneyReturn);
	//	print_r($flightJourneyReturn);
	}
	$carrierNameReturn 			= 	isset($flightReturnDetails['carrierName']) ? $flightReturnDetails['carrierName'] : array() ;
	$carrierName				= 	array_merge($carrierNameOnward,$carrierNameReturn);
	
	$minValueOnward				= $lowestPriceFlightOnward['sale_price'];
	;
	
	$minValueReturn				= isset($lowestPriceFlightReturn['sale_price']) ? $lowestPriceFlightReturn['sale_price'] : $minValueOnward ;
	$min 						= (isset($minValueReturn )? ($minValueOnward < $minValueReturn ? $minValueOnward : $minValueReturn) : $minValueOnward );	$maxValueOnward				= $higestPriceFlightOnward['sale_price'];
	
	$maxValueReturn				= isset($higestPriceFlightReturn['sale_price']) ? $higestPriceFlightReturn['sale_price'] : $maxValueOnward ;	
	$max 						= (isset($maxValueReturn )? ($maxValueReturn < $maxValueReturn ? $maxValueOnward : $maxValueReturn) : $maxValueOnward );
	
	$lowestPriceFlightReturn['sale_price']			= isset($lowestPriceFlightReturn['sale_price']) ? $lowestPriceFlightReturn['sale_price'] :0 ;
	
	$legCountArrayReturn 			= 	isset($flightJourneyReturn['legCountArray']) ? $flightJourneyReturn['legCountArray'] : array() ;
	$legCountArray					= 	array_merge($flightOnwardDetails['legCountArray'],$legCountArrayReturn);
	
	//print_r($legCountArray	);
	
	
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
   <!--<![endif]-->
   <head>
      <!-- header css and script starts -->
      <link href="css/plugin.css" rel="stylesheet" type="text/css" media="all" />
      <!-- Custom styles for this template -->
      <link href="css/style.css" rel="stylesheet">
      <style>
      </style>
      <script async src="https://www.selfdrive365.com/resources/js/modernizr-2.6.2.min.js"></script>
      <script src="https://www.selfdrive365.com/resources/js/jquery-1.10.2.min.js"></script>
      <!-- header css and script ends --><!-- header css and script ends -->
   </head>
   <body>
      <div class="main-content">
         <div class="filter-sec">
		 <h5><a href="../index.php"> Home </a></h5>
            <div class="search-box " >
            <div class="row" style="width:90%; margin:0 auto;">
			    <div class="col-md-2 flight-time"><br><span  class="amt">Trip :  <span class="flight-duration"><?php echo $_POST['trip'];?></span></div>
                <div class="col-md-2 flight-time"><br><span  class="amt">Source:  <span class="flight-duration"><?php echo $_POST['source'];?></span></div>
				<div class="col-md-2 flight-time"><br><span  class="amt">Destination:  <span class="flight-duration"><?php echo $_POST['destination'];?></span></div>
			    <div class="col-md-2 flight-time"><br><span  class="amt">Onward Date:  <span class="flight-duration"><?php echo $_POST['onwarddate'];?></span></div>
				<?php if(!empty($_POST['returndate'])){ ?>
				<div class="col-md-2 flight-time"><br><span  class="amt">Return Date:  <span class="flight-duration"><?php echo $_POST['returndate'];?></span></div>
				<?php } ?>
				<div class="col-md-2 flight-time"><br><span  class="amt">Passenger:  <span class="flight-duration"><?php echo $_POST['passenger'];?></span></div>
            </div>
         </div>
      </div>
      <div class="section animated shadow-inner" data-animation="fadeInUp" data-animation-delay="300">
         <div class="container">
            <div class="carry-transfer-content">
               <form id="fillform">
                  <div class="filter-sec">
                     <div class="filter-left-sec">
                        <h5>Filter by :</h5>
                        <ul>
                           <li class="selct-type">
                              <label>Airlines</label>
                              <ul>
                                 <?php foreach($carrierName as $key=>$CarrierDetail){  ?>
                                 <li><label><input type="checkbox" name="type" value="<?php echo preg_replace('/\s+/', '', ($key)); ?>" checked><i class="fa-custom-car black styled-checkbox-checked" > </i> <span><?php echo $CarrierDetail; ?></span></label></li>
                                 <?php } ?>
                              </ul>
                              <div class="clear"></div>
                           </li>
							<li class="selct-type">
                              <label>Leg Count</label>
                              <ul>
                         		 <?php foreach($legCountArray as $key=>$legCountArray){  
									if($key=='0'){
										$legDescription ='Direct Flight';
									}else{
										$legDescription = $key.' Stop';
									}
								 
								 ?>
                                 <li><label><input type="checkbox" name="legcount" value="<?php echo $key; ?>" checked><i class="fa-custom-car black styled-checkbox-checked" > </i> <span><?php echo $legDescription; ?></span></label></li>
                                 <?php } ?>
                              </ul>
                              <div class="clear"></div>
                           </li>
                           <li class="selct-location">	
                           </li>
                           <li class="selct-range">
                              <div class="price-slider sliderdiv range-slider-type01">
                                 <div class="DurationSlider-price">
                                    <label>Price (</label>
                                    <i class="fa-x">Rs</i><span class="DurationSlider-1-price"> <?php echo $min?></span></span> -
                                    <i class="fa-rupexe">Rs</i><span class="DurationSlider-2-price">  <?php echo $max?></span> )</span>
                                 </div>
                              </div>
                           </li>
                           <li class="selct-type">
                              <label>Depart Time Onward</label>
                              <ul>
                                 <li><label><input type="checkbox" name="DepartTimeOnward" value="b11" checked><i class="fa-custom-car black styled-checkbox-checked" > </i> <span>Before 11 AM</span></label></li>
                                 <li><label><input type="checkbox" name="DepartTimeOnward" value="a11" checked><i class="fa-custom-car black styled-checkbox-checked" > </i> <span>After 11 AM - 5 PM</span></label></li>
                                 <li><label><input type="checkbox" name="DepartTimeOnward" value="a5" checked><i class="fa-custom-car black styled-checkbox-checked" > </i> <span>After 5 PM - 9 PM</span></label></li>
                                 <li><label><input type="checkbox" name="DepartTimeOnward" value="a9" checked><i class="fa-custom-car black styled-checkbox-checked" > </i> <span>After 9 PM - 12 AM</span></label></li>
                              </ul>
                              <div class="clear"></div>
                           </li>
                            <?php if($param['post']['trip']=='Return Trip'){ ?>
						   <li class="selct-type">
                              <label>Depart Time Return</label>
                              <ul>
                                 <li><label><input type="checkbox" name="DepartTimeReturn" value="b11" checked><i class="fa-custom-car black styled-checkbox-checked" > </i> <span>Before 11 AM</span></label></li>
                                 <li><label><input type="checkbox" name="DepartTimeReturn" value="a11" checked><i class="fa-custom-car black styled-checkbox-checked" > </i> <span>After 11 AM - 5 PM</span></label></li>
                                 <li><label><input type="checkbox" name="DepartTimeReturn" value="a5" checked><i class="fa-custom-car black styled-checkbox-checked" > </i> <span>After 5 PM - 9 PM</span></label></li>
                                 <li><label><input type="checkbox" name="DepartTimeReturn" value="a9" checked><i class="fa-custom-car black styled-checkbox-checked" > </i> <span>After 9 PM - 12 AM</span></label></li>
                              </ul>
                              <div class="clear"></div>
                           </li>
							<?php } ?>
                        </ul>
                     </div>
                     <!--div class="filter-right-sec">
                        <h5>Sort by :</h5>
                        <ul>
                            <li><a href="#"><span>Price</span><i class="fa-exchange"></i></a></li>
                            <li><a href="#"><span>Duration</span><i class="fa-exchange"></i></a></li>
                        </ul>
                        </div-->
                  </div>
               </form>
               <script>
                  minprice = 	<?php echo $min?>;
                  maxprice = 	<?php echo $max?>;
                  
                  
               </script>
               <div class="filter-sec">
				<h5>Lowest Combiantion Price :</h5>
                  <div class="row">
                     <div class="column-search">
                        <div class="col-md-3 pr10"><img class="gws-flights-results__airline-logo flight-logo " style="" alt="" src="<?php echo '//gstatic.com/flights/airline_logos/70px/'.$lowestPriceFlightOnward['CarrierIata'].'.png';?>"
                           height="35" width="35"> 
                           <span class="flight-name">
                           <?php echo $lowestPriceFlightOnward['CarrierName'];?> - <?php echo $lowestPriceFlightOnward['CarrierId'];?>
                           </span>
                        </div>
                        <div class="col-md-5 flight-time"><?php echo $lowestPriceFlightOnward['ActualDeparture'];?> - <?php echo $lowestPriceFlightOnward['ActualArrival'];?> <br><span  class="amt">Rs <?php echo $lowestPriceFlightOnward['sale_price'];?> <sup>*</sup></span></div>
                        <div  class="col-md-4 flight-duration"> <span class="flight-duration">Duration <?php echo date('H:i', mktime(0,$lowestPriceFlightOnward['total_duration'])); ?> Hr <sup>*</sup></span></div>
                     </div>
                     <?php if($param['post']['trip']=='Return Trip'){ ?>
					 <div class="column-search">
                        <div class="col-md-3 pr10"><img class="gws-flights-results__airline-logo flight-logo " style="" alt="" src="<?php echo '//gstatic.com/flights/airline_logos/70px/'.$lowestPriceFlightReturn['CarrierIata'].'.png';?>"
                           height="35" width="35"> 
                           <span class="flight-name">
                           <?php echo $lowestPriceFlightReturn['CarrierName'];?> - <?php echo $lowestPriceFlightReturn['CarrierId'];?>
                           </span>
                        </div>
                        <div class="col-md-5 flight-time"><?php echo $lowestPriceFlightReturn['ActualDeparture'];?> - <?php echo $lowestPriceFlightReturn['ActualArrival'];?> <br><span  class="amt">Rs <?php echo $lowestPriceFlightReturn['sale_price'];?> <sup>*</sup></span></div>
                        <div  class="col-md-4 flight-duration"> <span class="flight-duration">Duration <?php echo date('H:i', mktime(0,$lowestPriceFlightReturn['total_duration'])); ?> Hr <sup>*</sup></span></div>
                     </div>
					 <?php } ?>
					 <div class="column-search">
						<div class="col flight-time">Total lowest Price <br><span  class="amt">Rs <?php echo $lowestPriceFlightOnward['sale_price']+$lowestPriceFlightReturn['sale_price'];?> <sup>*</sup></span></div>
					 </div>
                  </div>
               </div>
               <div class="row" id="triplist">
                  <div class="column">
                     <div class="" >
                        <?php foreach($flightJourneyOnward as $FlightDetails) {
                           $image ='//gstatic.com/flights/airline_logos/70px/'.$FlightDetails['CarrierIata'].'.png';
                           ?>									
                        <div style="display: block;" class="desc-box  tlist" tourtype="<?php echo preg_replace('/\s+/', '', $FlightDetails['CarrierName']); ?>" DepartTimeOnward="<?php echo $FlightDetails['TimeSlot'];?>" price="<?php echo $FlightDetails['sale_price'];?>" days="2" legcount="<?php echo $FlightDetails['LegCount'] ?>" <?php echo preg_replace('/\s+/', '', $FlightDetails['CarrierName']); ?> = "<?php echo preg_replace('/\s+/', '', strtolower($FlightDetails['CarrierName'])); ?>" >
                        <div class="row">
                           <div class="col-md-3 pr10"><img class="gws-flights-results__airline-logo flight-logo " style="" alt="" src="<?php echo $image;?>"
                              height="35" width="35"> 
                              <span class="flight-name">
                              <?php echo $FlightDetails['carrierNameDisplay'];?>
                              </span>
                           </div>
                           <div class="col-md-5 flight-time"><?php echo $FlightDetails['ActualDeparture'];?> - <?php echo $FlightDetails['ActualArrival'];?> <br><span  class="amt">Rs <?php echo $FlightDetails['sale_price'];?> <sup>*</sup></span></div>
                           <div  class="col-md-4 flight-duration"> <span class="flight-duration">Duration <?php echo date('H:i', mktime(0,$FlightDetails['total_duration'])); ?> Hr <sup>*</sup></span></div>
                        </div>
                     </div>
                     <?php } ?>	
                  </div>
               </div>
              <?php if($param['post']['trip']=='Return Trip'){ ?>
			  <div class="column">
                  <div class="" >
                     <?php foreach($flightJourneyReturn as $FlightDetails) {
                        $image ='//gstatic.com/flights/airline_logos/70px/'.$FlightDetails['CarrierIata'].'.png';
                        ?>									
                     <div style="display: block;" class="desc-box  tlist" tourtype="<?php echo preg_replace('/\s+/', '', $FlightDetails['CarrierName']); ?>" DepartTimeReturn="<?php echo $FlightDetails['TimeSlot'];?>" price="<?php echo $FlightDetails['sale_price'];?>" days="2" legcount="<?php echo $FlightDetails['LegCount'] ?>" <?php echo preg_replace('/\s+/', '', $FlightDetails['CarrierName']); ?> = "<?php echo preg_replace('/\s+/', '', strtolower($FlightDetails['CarrierName'])); ?>" >
                     <div class="row">
                        <div class="col-md-3 pr10"><img class="gws-flights-results__airline-logo flight-logo " style="" alt="" src="<?php echo $image;?>"
                           height="35" width="35"> 
                           <span class="flight-name">
                           <?php echo $FlightDetails['carrierNameDisplay']; ?>
                           </span>
                        </div>
                        <div class="col-md-5 flight-time"><?php echo $FlightDetails['ActualDeparture'];?> - <?php echo $FlightDetails['ActualArrival'];?> <br><span  class="amt">Rs <?php echo $FlightDetails['sale_price'];?> <sup>*</sup></span></div>
                        <div  class="col-md-4 flight-duration"> <span class="flight-duration">Duration <?php echo date('H:i', mktime(0,$FlightDetails['total_duration'])); ?> Hr <sup>*</sup></span></div>
                     </div>
                  </div>
                  <?php } ?>	
               </div>
            </div>
			<?php } ?>	
         </div>
      </div>
      </div>	
      </div>
      <!-- MAIN_CONTENT end -->
      <!-- footer ends -->
      <script src="https://www.selfdrive365.com/resources/js/plugins.js"></script>
      <script src="js/main.js"></script>
      <script src="https://www.selfdrive365.com/resources/js/form-elements.js"></script>
   </body>
</html>

