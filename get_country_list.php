
	<?php
$db = new mysqli("localhost", "mohammad_newsu", "wasim!@#$", "mohammad_mostpopularnews");
$response["country"] = array();

if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']!="all"){
  $key = $_REQUEST['keyword'];
  $sql="SELECT * FROM countries WHERE name LIKE '%$key%' ORDER BY country_id DESC";
}
/*elseif(isset($_REQUEST['continent']) && $_REQUEST['continent']!="all"){
  $key = $_REQUEST['continent'];
  $sql="SELECT * FROM countries WHERE cont_code = '".$key."' ORDER BY country_id DESC";
}*/
else{
  $sql="SELECT * FROM countries ORDER BY country_id DESC";
}
	
	$result = $db->query($sql);
	$data=array();
	//print_r($result);
	//echo $result->num_rows;

	if($result->num_rows>0) {
	    while($row = $result->fetch_assoc()) {      
			$data['id'] = $row['country_id'];
			$data['name'] = $row['name'];
			array_push($response["country"], $data);
	    }
	   
	   echo json_encode($response);
	}
?>