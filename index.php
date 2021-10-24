<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>World Most Popular News</title>

<!-- ===================-Insert Form =============== -->
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once dirname(__FILE__) . '/NewsClass.php';
$objNews = new NewsClass();
	
if(isset($_REQUEST['code']) &&  !empty( $_REQUEST['code'] ) )
{
    echo sprintf( '<p>%s</p>', $_REQUEST['code'] );
}
if(isset($_GET['ni']) && ($_GET['ni']!="" && is_numeric($_GET['ni']))){
	//echo $_GET['ni'];
	$data = $objNews->getUpdateNews($_GET['ni']);
	//print_r($data);
	$jsondecval = json_decode($data);
	foreach($jsondecval as $json)
	{		
		$name = $json->name;
		$bangla_name = $json->bangla_name;
		$logo = $json->logo;
		$url  = $json->url;	
		$continent =  $json->continent;	
		$country =  $json->country;	
		$city =  $json->news_type;	
		$news_type =  $json->news_type;	
		$keyword =  $json->keyword;	
		$description =  $json->description;	
	}
	$action = 'Update';
	$nid = $_GET['ni'];
}
else{
	$name = '';
	$bangla_name = '';
	$logo = '';
	$url = '';
	$continent = '';
	$country = '';
	$city = '';
	$news_type = '';
	$keyword = 'bangaldesh,';
	$description = '';
	$action = 'Insert';
	$nid = '';
}

?>
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script>
	function deleteData(id){
		var c = confirm("Are You sure ? Do you want to delete data ?");
		if(c == true){
			window.location.href='news_action.php?nid='+id+'&action=Delete';
		}
		else{
			return false;
		}
	}
	
	function getCountryList(id){
		//alert(cont);
		$.ajax({
			type : 'POST',
			url  : 'ajaxHandler.php',
			data : {'continent':id,'action':'getCountryValue'},
			success: function(response){
				//alert(response);
				$("#countrylist").html(response);
			},
			error : function(status){
				alert(status);
			}
		
		});
	}
</script>
</head>
<body>
<form method="post" action="news_action.php" enctype="multipart/form-data">
	
	<div style="width: 100%; padding: 5px; margin-bottom:5px; float:left">
		<div style="width: 10%; float: left;">
			<label>Continent</label>	
		</div>
		<div style="width: 90%; float: left;">
			<select name="continent" style="padding: 5px; width: 40%;" onchange="getCountryList(this.value);">
            	<option value="">Continents</option>
                <?php
				$data = $objNews->getContinentList();
				$jsondecval = json_decode($data);
				foreach($jsondecval as $mydata)
				{	    
				?>
				<option value="<?php echo $mydata->id;?>" <?php if($mydata->id==3){?> selected="selected" <?php } ?>><?php echo $mydata->name;?></option>
				<?php
				}	
				?>
        
        
            </select>
		</div>
	</div>

    <div style="width: 100%; padding: 5px; margin-bottom:5px; float:left">
		<div style="width: 10%; float: left;">
			<label>Country</label>	
		</div>
		<div style="width: 90%; float: left;">
        	<div id="countrylist">
			<select name="country" id="country" style="padding: 5px; width: 40%;">
            	<option value="20" selected="selected">Bangladesh</option>
            </select>
            </div>
		</div>
	</div>
    <div style="width: 100%; padding: 5px; margin-bottom:5px; float:left">
		<div style="width: 10%; float: left;">
			<label>City</label>	
		</div>
		<div style="width: 90%; float: left;">
			<input type="text" name="city" value="<?php echo $city;?>" style="padding: 5px; width: 40%;">
		</div>
	</div>
    <div style="width: 100%; padding: 5px; margin-bottom:5px; float:left">
		<div style="width: 10%; float: left;">
			<label>Type</label>	
		</div>
		<div style="width: 90%; float: left;">
			<select name="news_type" id="news_type" style="padding: 5px; width: 40%;">
            	 <option value="Bangla">Bangla</option>
            	<option value="English">English</option>               
                <option value="Hindi">Hindi</option>
                <option value="Tamil">Tamil</option>
                <option value="Urdu">Urdu</option>
                <option value="Arabic">Arabic</option>
                <option value="Chinese">Chinese</option>

<option value="Spanish">Spanish</option>
<option value="Germany">Germany</option>
<option value="Italy">Italy</option>
<option value="France">France</option>
<option value="Turkish">Turkish</option>
<option value="Japanies">Japanies</option>
            </select>
		</div>
	</div>
    <div style="width: 100%; padding: 5px; margin-bottom:5px; float:left">
		<div style="width: 10%; float: left;">
			<label>Name</label>	
		</div>
		<div style="width: 90%; float: left;">
			<input type="text" name="paperName" value="<?php echo $name;?>" style="padding: 5px; width: 40%;">
		</div>
	</div>
	<div style="width: 100%; padding: 5px;margin-bottom:5px; float:left">
		<div style="width: 10%; float: left;">
			<label>Bangla Name</label>	
		</div>
		<div style="width: 90%; float: left;">
			<input type="text" name="bangla_name" value="<?php echo $bangla_name;?>"  style="padding: 5px;width: 40%;">
		</div>
	</div>

	<div style="width: 100%; padding: 5px;margin-bottom:5px; float:left">
		<div style="width: 10%; float: left;">
			<label>URL</label>	
		</div>
		<div style="width: 90%; float: left;">
			<input type="text" name="url"  value="<?php echo $url;?>"  style="padding: 5px;width: 40%;">
		</div>
	</div>
	<div style="width: 100%; padding: 5px;margin-bottom:5px; float:left">
		<div style="width: 10%; float: left;">
			<label>Logo</label>	
		</div>
		<div style="width: 90%; float: left;">
			<div style="width:25%; float:left"><input type="file" name="logo"></div>
            <div style="width:20%; float:left">
            <img src="http://mohammadwasim.net/mostpopnews/uploads/news/<?php echo $logo;?>" style="width:150px; height:auto"></div>
            <input type="hidden" name="stillimg"  value="<?php echo $logo;?>"  />
		</div>
	</div>
	
    <div style="width: 100%; padding: 5px;margin-bottom:5px; float:left">
		<div style="width: 10%; float: left;">
			<label>Keyword</label>	
		</div>
		<div style="width: 90%; float: left;">
			<input type="text" name="keyword"  value="bangladesh,"  style="padding: 5px;width: 40%;">
		</div>
	</div>
    <div style="width: 100%; padding: 5px;margin-bottom:5px; float:left">
		<div style="width: 10%; float: left;">
			<label>Description</label>	
		</div>
		<div style="width: 90%; float: left;">
			<input type="text" name="description"  value="<?php echo $description;?>"  style="padding: 5px;width: 40%;">
		</div>
	</div>
	<div style="width: 100%; padding: 5px;">
    	<input type="hidden" name="nid"  value="<?php echo $nid;?>"  />
		<input type="submit" name="action" value="<?php echo $action;?>" style="padding: 5px 10px; font-size: 15px; background: #333; color: #fff">
	</div>

</form>



<div style="width: 95%; padding: 5px; margin-bottom:5px; margin:auto">
<!-- ===================- Display Data =============== -->
<table width="100%" border="1" align="center" style="border-collapse: collapse;">
	<tr bgcolor="#ccc">
		<td width="10%" align="center" style="padding: 5px">Name</td>
	  <td width="15%" align="center" style="padding: 5px">Bangla Name</td>
      <td width="12%" align="center" style="padding: 5px">Continent</td>
      <td width="9%" align="center" style="padding: 5px">Country</td>
      <td width="9%" align="center" style="padding: 5px">City</td>
      <td width="7%" align="center" style="padding: 5px">Type</td>
	  <td width="15%" align="center" style="padding: 5px">Logo</td>
	  <td width="16%" align="center" style="padding: 5px">URL</td>
      <td width="7%" align="center" style="padding: 5px">Action</td>
  </tr>

	<?php
		$data = $objNews->getAllnewspaper();
		$jsondecval = json_decode($data);
		foreach($jsondecval as $mydata)
		{	
	    //$countryinfo = $objNews->getMatchValueList('countries','country_id',$mydata->country);

	    //foreach($countryinfo as $cinfo);
			
	    ?>
	    <tr>
		<td align="center" style="padding: 5px"><?php echo $mydata->name;?></td>
		<td align="center" style="padding: 5px"><?php echo $mydata->bangla_name	;?></td>
        <td align="center" style="padding: 5px"><?php echo $mydata->continent;?></td>
        <td align="center" style="padding: 5px"><?php echo $mydata->country;?></td>
        <td align="center" style="padding: 5px"><?php echo $mydata->city;?></td>
        <td align="center" style="padding: 5px"><?php echo $mydata->news_type	;?></td>
		<td align="center" style="padding: 5px">
                <img src="http://mohammadwasim.net/mostpopnews/uploads/news/<?php echo $mydata->logo;?>" style="width:150px; height:auto"></td>
		<td align="center" style="padding: 5px"><?php echo $mydata->url;?></td>
        <td align="center" style="padding: 5px"><a href="index.php?ni=<?php echo $mydata->id;?>">Edit</a> | 
        <a href="javascript:void(0)" onclick="deleteData(<?php echo $mydata->id;?>);">Delete</a></td>
		</tr>
	    <?php	    
	}
?>
</table>
</div>
</body>
</html>