<?php
include_once dirname(__FILE__) . '/NewsClass.php';
$objNews = new NewsClass();
$methType = $_SERVER['REQUEST_METHOD'];
if($methType == 'GET'){
	if(isset($_GET['action']) && $_GET['action']!=""){
		if($_GET['action']=="getCountryValue"){
			$continent = $_GET['continent'];
			$getCount = $objNews->getCountryList($continent);
			//echo $getCount;
			if($getCount!=""){
				//$jsondecval = json_decode($getCount);
				echo '<select name="country" style="padding: 5px; width: 40%;">';
				foreach($getCount as $json)
				{	
					echo '<option value="'.$json->code.'">'.$json->name.'</option>';
				}
          		 echo '</select>';
			}
			else{
				echo 'No Data Found';
			}
		}
	}
	else{
		//echo trigger_error("No Request Found");
		echo 'No Request Found';
	}
}
elseif($methType == 'POST'){
	if(isset($_POST['action']) && $_POST['action']!=""){
		if($_POST['action']=="getCountryValue"){
			$continent = $_POST['continent'];
			$getCount = $objNews->getCountryList($continent);
			//echo $getCount;
			if($getCount!=""){
				//$jsondecval = json_decode($getCount);
				echo '<select name="country" id="country" style="padding: 5px; width: 40%;">';
				foreach($getCount as $json)
				{		
					echo '<option value="'.$json['country_id'].'">'.$json['name'].'</option>';
				}
          		 echo '</select>';
			}
			else{
				echo 'No Data Found';
			}
		}
	}
	else{
		echo trigger_error("No Request Found");
		return false;
	}
	//echo 'Action: '.$_POST['action'];
}
else{
	//echo trigger_error("Invalid URL");
	echo 'Invalid URL';
	return false;
}
?>