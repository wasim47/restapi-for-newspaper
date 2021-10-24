<?php

//include('db.php');
$db = new mysqli("localhost", "mohammad_newsu", "wasim!@#$", "mohammad_mostpopularnews");
//$response["newspaper"] = array();
$response = array();
//echo $_REQUEST['status'];
//if(isset($_REQUEST['status']) && $_REQUEST['status']=="newsdisplay"){
	$sql="SELECT * FROM newspaper ORDER BY id DESC";
	$result = $db->query($sql);
	$data=array();
	//print_r($result);
	//echo $result->num_rows;

	if($result->num_rows>0) {
	    while($row = $result->fetch_assoc()) {      
			
			//echo $row->id;
			//echo $row['id'];
			$data['id'] = $row['id'];
			$data['name'] = $row['name'];
			$data['bangla_name'] = $row['bangla_name'];
			$data['logo'] = $row['logo'];
			$data['url'] = $row['url'];
			//array_push($response["newspaper"], $data);
                        array_push($response, $data);    
	    }
	   
	   echo json_encode($response);
	   
	    //echo json_encode($data);
	}
//}
?>