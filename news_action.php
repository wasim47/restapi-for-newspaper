<?php
include_once dirname(__FILE__) . '/NewsClass.php';
$objNews = new NewsClass();
$methType = $_SERVER['REQUEST_METHOD'];
if($methType == 'GET'){
	if(isset($_GET['action']) && $_GET['action']!=""){
		$name = $_GET['paperName'];
		$bangla_name = $_GET['bangla_name'];
		$url = $_GET['url'];
		$logo = $_FILES['logo'];
		$stillimg = $_GET['stillimg'];
		$finalLogo = $objNews->imageUpload($logo,$name,$stillimg);
		if($_GET['action']=="Insert"){
			$createFunc = $objNews->createNewspaper($name,$bangla_name,$finalLogo,$url);
		}
		elseif($_GET['action']=="Update"){
			$nid = $_GET['nid'];
			$createFunc = $objNews->updateNewspaper($nid,$name,$bangla_name,$finalLogo,$url);
		}
		elseif($_GET['action']=="Delete"){
			$nid = $_GET['nid'];
			$createFunc = $objNews->getDeleteNews($nid);
		}
		header("Location:index.php?code={$createFunc}");
	}
	else{
		//echo trigger_error("No Request Found");
		echo 'No Request Found';
	}
}
elseif($methType == 'POST'){
	if(isset($_POST['action']) && $_POST['action']!=""){
		$name = $_POST['paperName'];
		$bangla_name = $_POST['bangla_name'];
		$continent = $_POST['continent'];
		$country = $_POST['country'];
		$city = $_POST['city'];
		$news_type = $_POST['news_type'];
		$keyword = strtolower($_POST['keyword']);
		$description = $_POST['description'];
		$url = $_POST['url'];
		$logo = $_FILES['logo'];
		$stillimg = $_POST['stillimg'];
		$finalLogo = $objNews->imageUpload($logo,$name,$stillimg);
		if($_POST['action']=="Insert"){
			$createFunc = $objNews->createNewspaper($name,$bangla_name,$finalLogo,$url,$continent,$country,$city,$news_type,$keyword,$description);
		}
		elseif($_POST['action']=="Update"){
			$nid = $_POST['nid'];
			$createFunc = $objNews->updateNewspaper($nid,$stillimg,$name,$bangla_name,$finalLogo,$url,$continent,$country,$city,$news_type,$keyword,$description);
		}
		elseif($_POST['action']=="Delete"){
			$nid = $_POST['nid'];
			$createFunc = $objNews->getDeleteNews($nid);
		}
		header("Location:index.php?code={$createFunc}");
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