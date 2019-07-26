<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Fligth Search </title>
<link href="includes/css/style_home.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>
<script type="text/javascript" src="includes/js/script_home.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<meta name="robots" content="noindex,nofollow"/>
</head>
<script>

  </script>
<body>
	<div id="wrap"> <!--wrap start-->
    	<div id="wrap2">  <!--wrap2 start-->
       
       	<h2 class="free_account">Flight Search</h2> 
        
    	<form action="includes/action.php" method="post" id="search_form">
                <p class="validate_msg">Please fix the errors below!</p>
                <p> <label for="trip">Trip</label>  <input name="trip" type="radio" value="One Way Trip" /> One-way <input name="trip" type="radio" value="Return Trip" /> Round <span class="val_trip"></span> </p>
                <p> <label for="source">Source</label> <input name="source" type="text" /> <span class="val_source"></span> </p> 
                <p> <label for="destination">Destination</label>  <input name="destination" type="text" />  <span class="val_destination"></span> </p>
                <p> <label for="onwarddate">OnwardDate</label>  <input name="onwarddate" type="text" id="onwarddate"/>  <span class="val_onwarddate"></span> </p>
				<p> <label for="returndate">ReturnDate</label>  <input name="returndate" type="text" id="returndate"/>  <span class="val_returndate"></span> </p>
				<p> <label for="passenger">Passenger</label> 
                            	<select name="passenger">                    			
                                    <?php 
										$pass = array('1' => '1', '2' => '2', '3' => '3');
										foreach($pass as $m => $pas) {
									?>
                                    <option value="<?php echo $m; ?>"><?php echo $pas; ?></option>
                                    <?php } ?>
                                </select>                               
                <span class="val_passenger"></span> </p> 
				<input type="submit" name="submit" value="Search">
        </form>
       
        </div>  <!--wrap2 end-->
    </div>  <!--wrap start-->
</body>
</html>