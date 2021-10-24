<!-- ===================-Insert Form =============== -->
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once dirname(__FILE__) . '/NewsClass.php';
$objNews = new NewsClass();

if(isset($_REQUEST['status']) &&  $_REQUEST['status']=='newsdisplay')
{
    $data = $objNews-> getAllnewspaperAndroid();
    echo $data;
    ///echo json_decode($data);
}
else{
   $data= array('status'=>'Invalid Request');
   echo json_encode($data);
}
?>