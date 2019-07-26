<?php   
class FlightSearch{
	 
	public $results;
	public $post;
	public $carrierName;
	public function __construct(){
		$apiUrl = "json/1.json";
		$this->results 	= json_decode(file_get_contents($apiUrl),1);
		
	}
	 
	 
	public function onwardJourney($param){		
		 $flightJourneyOnward 	= array();
		 $flightOnward = $this->results['from'];
		 $this->sortArray($flightOnward, 'sale_price');
		 $legCountArray = array();
		 foreach($flightOnward as $key=>$val){
			$flightJourneyOnward[$key] = $val;
			$dateTimeArr 	= 		explode(' ',$val['flights']['0']['departure_date_time']);
			$time			=		$dateTimeArr['1'];			
			if($time <= 9 ){
				$timeSlot ='b11';
			}elseif($time > 9 && $time < 17){
				$timeSlot ='a11';
			}elseif($time > 17 && $time < 21){
				$timeSlot ='a5';
			}else{
				$timeSlot ='a9';
			};	
			$startFlight= current($val['flights']);
			$endFlight	= end($val['flights']);	
			
			$carrierNameDisplay ='';
			foreach($val['flights'] as $flightVal){
					$carrierNameDisplay .= $flightVal['carrier_name'].'-'.$flightVal['carrier_id'].' : ';
			}
			$legCount										=	count($val['flights'])-1;
			$flightJourneyOnward[$key]['ActualDeparture'] 	=  	date('h:i A ', strtotime($startFlight['departure_date_time']));
			$flightJourneyOnward[$key]['ActualArrival'] 	=   date('h:i A ', strtotime($endFlight['arrival_date_time'])); 
			$flightJourneyOnward[$key]['CarrierName'] 		=   $val['flights']['0']['carrier_name']; 
			$flightJourneyOnward[$key]['CarrierId'] 		=   $val['flights']['0']['carrier_id']; 
			$flightJourneyOnward[$key]['CarrierIata'] 		=   $val['flights']['0']['carrier_iata']; 
			$flightJourneyOnward[$key]['carrierNameDisplay'] 	=   substr($carrierNameDisplay,0,-2); 
			$this->carrierName[$val['flights']['0']['carrier_name']] 	=   $val['flights']['0']['carrier_name'];
			$flightJourneyOnward[$key]['TimeSlot'] 			=   $timeSlot;
			$flightJourneyOnward[$key]['LegCount'] 			=   $legCount;
			$legCountArray[$legCount] 						=   $legCount;
				
		   }
			$lowestPriceFlightOnward	= current($flightJourneyOnward);		   
		   return array('flightJourneyOnward'=>$flightJourneyOnward,'carrierName'=>$this->carrierName,'lowestPriceFlightOnward'=>$lowestPriceFlightOnward,'legCountArray'=>$legCountArray);
	}
	 
	public function returnJourney($param){		
		 $flightJourneyReturn 	= array();
		 $flightReturn = $this->results['return'];
		 $this->sortArray($flightReturn, 'sale_price');
		 $legCountArray = array();
		 foreach($flightReturn as $key=>$val){
			$flightJourneyReturn[$key] = $val;
			$dateTimeArr 	= 		explode(' ',$val['flights']['0']['departure_date_time']);
			$time			=		$dateTimeArr['1'];			
			if($time <= 9 ){
				$timeSlot ='b11';
			}elseif($time > 9 && $time < 17){
				$timeSlot ='a11';
			}elseif($time > 17 && $time < 21){
				$timeSlot ='a5';
			}else{
				$timeSlot ='a9';
			};	

			$startFlight= current($val['flights']);
			$endFlight	= end($val['flights']);	
			
			$carrierNameDisplay ='';
			foreach($val['flights'] as $flightVal){
					$carrierNameDisplay .= $flightVal['carrier_name'].'-'.$flightVal['carrier_id'].' : ';
			}
			$legCount										=	count($val['flights'])-1;
			$flightJourneyReturn[$key]['ActualDeparture'] 	=  	date('h:i A ', strtotime($startFlight['departure_date_time']));
			$flightJourneyReturn[$key]['ActualArrival'] 	=   date('h:i A ', strtotime($endFlight['arrival_date_time'])); 
			$flightJourneyReturn[$key]['CarrierName'] 		=   $val['flights']['0']['carrier_name']; 
			$flightJourneyReturn[$key]['CarrierId'] 		=   $val['flights']['0']['carrier_id']; 
			$flightJourneyReturn[$key]['CarrierIata'] 		=   $val['flights']['0']['carrier_iata']; 
			$flightJourneyReturn[$key]['carrierNameDisplay'] 	=   substr($carrierNameDisplay,0,-2); 
			$this->carrierName[$val['flights']['0']['carrier_name']] 		=   $val['flights']['0']['carrier_name'];
			$flightJourneyReturn[$key]['TimeSlot'] 			=   $timeSlot; 	
			$flightJourneyReturn[$key]['LegCount'] 			=   $legCount;
			$legCountArray[$legCount] 						=   $legCount;			
		   }
		   $lowestPriceFlightReturn	= current($flightJourneyReturn);
		   return array('flightJourneyReturn'=>$flightJourneyReturn,'carrierName'=>$this->carrierName,'lowestPriceFlightReturn'=>$lowestPriceFlightReturn,'legCountArray'=>$legCountArray);
	} 

	function sortArray(&$array, $subfield)  {
       $sortarray = array();
       foreach ($array as $key => $row){
           $sortarray[$key] = $row[$subfield];
       }   
       array_multisort($sortarray, SORT_ASC, $array);
   }
	 
	 
	 
 }
  
  
?>