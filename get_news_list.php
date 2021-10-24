<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
//echo 'Test';
require_once dirname(__FILE__) . '/config.php';
//include('config.php');

$data = array();
$response = array();
	
//if(isset($_GET['userid']) && $_GET['userid']!="") {
   // $userid=$_GET['userid'];
	
	
	//$sql="SELECT project_id FROM project_user WHERE user_id = ?";
if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']!="all"){
  $key = $_REQUEST['keyword'];
  $param = "%{$key}%";
  $sql="SELECT id, name, bangla_name, logo, url FROM newspaper WHERE name LIKE ? ORDER BY id DESC";
  $stmt=$db->prepare($sql);
  $stmt->bind_param("s", $param);
}
elseif(isset($_REQUEST['countryid']) && $_REQUEST['countryid']!=""){
  $country = $_REQUEST['countryid'];
  $sql="SELECT id, name, bangla_name, logo, url FROM newspaper WHERE country = ? ORDER BY id DESC";
  $stmt=$db->prepare($sql);
  $stmt->bind_param("i", $country);
}
else{
  $sql="SELECT id, name, bangla_name, logo, url FROM newspaper ORDER BY id DESC";
   $stmt=$db->prepare($sql);
}

 
    $stmt->execute(); 
    $stmt->bind_result($id, $name, $bname, $logo, $url); 
    $result = $stmt->store_result();
    if($stmt->num_rows > 0) {
        while($row = $stmt->fetch()) {
			$data['id'] = $id;
			$data['name'] = $name;
			$data['bangla_name'] = $bname;
			$data['logo'] = $logo;
			$data['url'] = $url;
			array_push($response, $data);	
        }
    }
	else{
		$data['msg'] = "No Data Found";
		array_push($response, $data);
	}




 echo json_encode($response);
?>