$(".DurationSlider-price").slider({
    tooltip: 'hide',
    min: minprice,
    max: maxprice,
    value: [minprice, maxprice]
});
$(".DurationSlider-price").on("slide", function(slideEvt) {
    $(".DurationSlider-1-price").text(slideEvt.value[0]);
    $(".DurationSlider-2-price").text(slideEvt.value[1])
});

var airline	=	[];
var OnwardDeptime	=	[];
var ReturnDeptime	=	[];
var leg	=	[];
$(".DurationSlider-price").on("slide", function(slideEvt) {
$(".DurationSlider-1-price").text(slideEvt.value[0]);
  $(".DurationSlider-2-price").text(slideEvt.value[1]);
//airline	=	abc();
//deptime	=	deptimeDuration();
  $('#fillform').trigger("change");
});

$('input[name=type]').on('ifChecked', function(event){
airline	=	airlinetype();	
$('#fillform').trigger('change');
})  ;	
$('input[name=type]').on('ifUnchecked', function(event){
airline= airlinetype();	
$('#fillform').trigger('change');
})  ;

$('input[name=legcount]').on('ifChecked', function(event){
leg	=	legcount();	
$('#fillform').trigger('change');
})  ;	
$('input[name=legcount]').on('ifUnchecked', function(event){
leg= legcount();	
$('#fillform').trigger('change');
})  ;

function airlinetype(){
var data=[]
$("input[name=type]").each(function(){
	if($(this).prop("checked")){
		data.push($(this).val()); 
	}
});
return data;
}

function legcount(){
var data=[]
$("input[name=legcount]").each(function(){
	if($(this).prop("checked")){
		data.push($(this).val()); 
	}
});
return data;
}
$('input[name=DepartTimeOnward]').on('ifChecked', function(event){
OnwardDeptime	=	OnwardDuration();	
$('#fillform').trigger('change');
})  ;	
$('input[name=DepartTimeOnward]').on('ifUnchecked', function(event){
OnwardDeptime= OnwardDuration();	
$('#fillform').trigger('change');
})  ;

function OnwardDuration(){
var dataDeptime=[]
$("input[name=DepartTimeOnward]").each(function(){
	if($(this).prop("checked")){
		dataDeptime.push($(this).val()); 
	}
});
return dataDeptime;
}	

$('input[name=DepartTimeReturn]').on('ifChecked', function(event){
ReturnDeptime	=	ReturnDuration();	
$('#fillform').trigger('change');
})  ;	
$('input[name=DepartTimeReturn]').on('ifUnchecked', function(event){
ReturnDeptime= ReturnDuration();	
$('#fillform').trigger('change');
})  ;

function ReturnDuration(){
var dataReturnDeptime=[]
$("input[name=DepartTimeReturn]").each(function(){
	if($(this).prop("checked")){
		dataReturnDeptime.push($(this).val()); 
	}
});
return dataReturnDeptime;
}	
$('#fillform').change(function(){
airline	=	airlinetype();
OnwardDeptime	=	OnwardDuration();
ReturnDeptime	=	ReturnDuration();
leg				= 	legcount();

var filtros = "";
  if(filtros !== ""){		
	  $("#triplist .tlist").hide().filter(filtros).show();
	pricefillter();	
  } else {
	  $("#triplist .tlist").show();
	pricefillter();
  }
});	

function pricefillter()
{
var minfilprice = parseInt($(".DurationSlider-1-price").text());
  var maxfillprice = $(".DurationSlider-2-price").text();

$("#triplist .tlist:visible").each(function(e){
	var price = parseInt($(this).attr("price"));
	var tourtype = $(this).attr("tourtype");
	var DepartTimeOnward = $(this).attr("DepartTimeOnward");
	var DepartTimeReturn = $(this).attr("DepartTimeReturn");
	var legcur 			 = $(this).attr("legcount");

	displayairline ='no';
	displaydeptimeonward ='no';
	displaydeptimereturn ='no';
	legcheck ='no';
	if(price > 0){			
		for (i = 0; i < airline.length; i++) { 
				if(airline[i] == tourtype){
					//console.log(airline[i]);
					displayairline='yes';
				}
				
		}
		//alert(deptime.length);
		for (i = 0; i < OnwardDeptime.length; i++) { 
				if(OnwardDeptime[i] == DepartTimeOnward){
					//console.log(OnwardDeptime[i]);
					displaydeptimeonward='yes';
				}
				
		}

		for (i = 0; i < ReturnDeptime.length; i++) { 
				if(ReturnDeptime[i] == DepartTimeReturn){
					console.log(ReturnDeptime[i]);
					displaydeptimereturn='yes';
				}
				
		}
		for (i = 0; i < leg.length; i++) { 
				if(leg[i] == legcur){
					console.log(leg[i]);
					legcheck='yes';
				}
				
		}
		if((price >= minfilprice && price <= maxfillprice ) && displayairline =='yes' && legcheck =='yes' && (displaydeptimeonward =='yes' || displaydeptimereturn =='yes')){					
			$(this).show();					
		}else{
			$(this).hide();
		}	
	}
});
}