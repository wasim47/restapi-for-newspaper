<?php

class NewsClass
{
    private $con;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }

    //Method to register a new newspaper
    public function createNewspaper($name,$bangla_name,$logo,$url,$continent,$country,$city,$news_type,$keyword,$description){
        if (!$this->isValidnNwspaper($url)) {
            $apikey = $this->generateApiKey();
            $date = date('Y-m-d');
            $status = 1;
            $stmt = $this->con->prepare("INSERT INTO newspaper(name,bangla_name, logo, url, api_key, continent, country, city, news_type, keyword, description, status, date) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssds", $name, $bangla_name, $logo, $url, $apikey, $continent, $country, $city, $news_type, $keyword, $description, $status, $date);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return 1;
            } else {
                return 0;
            }            
        } 
        else {
            return 2;
        }
    }
	
	
	 //Method to register a new newspaper
    public function updateNewspaper($nid,$stillimg,$name,$bangla_name,$logo,$url,$continent,$country,$city,$news_type,$keyword,$description){
        if (!$this->isValidnNwspaper($url)) {
            $date = date('Y-m-d');
            $stmt = $this->con->prepare("UPDATE newspaper SET name = ?, bangla_name = ?, logo= ?, url= ?, continent= ?, 
			country= ?, city= ?, news_type= ?, keyword= ?, description= ?, date= ? WHERE id = ?");

            $stmt->bind_param("sssssssssssd", $name, $bangla_name, $logo, $url,$continent,$country,$city,$news_type,$keyword,$description, $date, $nid);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return 1;
            } else {
                return 0;
            }            
        } 
        else {
            return 2;
        }
    }

    


       //Method to get newspaper details
    public function getNewspaper($status){
        $stmt = $this->con->prepare("SELECT * FROM newspaper WHERE status = ?");
        $stmt->bind_param("d",$status);
        $stmt->execute();
        $newspaper = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $jsonval = json_encode($newspaper);
        return $jsonval;
    }
	
	
	public function getUpdateNews($id){
       /* $stmt = $this->con->prepare("SELECT * FROM newspaper WHERE id = ?");
        $stmt->bind_param("d",$id);
        $stmt->execute();
        $newspaper = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        $jsonval = json_encode($newspaper);
        return $jsonval;*/
		//$sql = "SELECT * FROM newspaper WHERE id = ?";
		$result = $this->con->query("SELECT * FROM newspaper WHERE id = $id");
		 foreach($result as $val){
            $data[] = $val;
        }
		$jsonval = json_encode($data);
        return $jsonval;
    }

	public function getContinentList(){
		 $result = $this->con->query("SELECT * FROM continents");
		 foreach($result as $val){
            $data[] = $val;
        }
		$jsonval = json_encode($data);
        return $jsonval;
    }
	
	public function getCountryList($cont){
		 $result = $this->con->query("SELECT * FROM countries WHERE cont_code = $cont");
		 foreach($result as $val){
            $data[] = $val;
        }
        return $data;
    }
	
	
	
	public function getMatchValueList($table,$col,$val){
		//echo $cont;
		// $result = $this->con->query("SELECT * FROM ".$table." WHERE ".$col." = '".$val."'");
		$stmt = $this->con->prepare("SELECT * FROM ".$table." WHERE ".$col." = ? ");
        $stmt->bind_param("d",$val);
        $stmt->execute();
        $newspaper = $stmt->get_result()->fetch_assoc();
        $stmt->close();
       // $jsonval = json_encode($newspaper);
        return $newspaper;
    }
	
	public function getDeleteNews($id){
		$result = $this->con->query("DELETE  FROM newspaper WHERE id = $id");
		
        return $result;
    }
	
	

    //Method to fetch all newspaper from database
    public function getAllnewspaper(){
        $newspaper = $this->con->query("SELECT * FROM newspaper ORDER BY id ASC");
        foreach($newspaper as $val){
            $data[] = $val;
        }
        $jsonval = json_encode($data);
        return $jsonval;
    }

   //Method to fetch all newspaper from database
    public function getAllnewspaperAndroid(){
        $newspaper = $this->con->query("SELECT * FROM newspaper ORDER BY id DESC");
        foreach($newspaper as $val){
            $data[] = $val;
        }
        $jsonval = json_encode(array("newspaper"=>$data));
        return $jsonval;
    }

   
    //Method to check the newspaper logo already exist or not
    private function isNewspaperExists($url) {
        $stmt = $this->con->prepare("SELECT id from newspaper WHERE url = ?");
        $stmt->bind_param("s", $url);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

   

    //Checking the newspaper is valid or not by api key
    public function isValidnNwspaper($api_key) {
        $stmt = $this->con->prepare("SELECT id from newspaper WHERE api_key = ?");
        $stmt->bind_param("s", $api_key);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    public function imageUpload($filename,$renameFile,$stillimg){
        //$file = $_FILES;
		if(isset($filename) && $filename['name']!=""){
				$imgFile = $filename['name'];
				$temp = $filename['tmp_name'];
				$size = $filename['size'];
				$path = 'uploads/news/';
				$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
				$validExt = array('jpg','jpeg','png','gif');
				$nexp = explode(' ', $renameFile);
				$imp = implode('_', $nexp);
				$fileRename = strtolower($imp).time().'.'.$imgExt;
		
				// Checking File Extension
				if(in_array($imgExt, $validExt)){
					//if extension ok than check file size limit '5MB'
					if($size < 5000000){
						if(!$path){
							mkdir($path);
						}
						move_uploaded_file($temp, $path.$fileRename);
					}
					else{
						echo 'Image Size is too large';
					}
				}
				else{
						echo 'Image Extension not Valid';
					}
					
			$dbFilenme = $fileRename;
		}
		else{
			$dbFilenme = $stillimg;
		}
		
        return $dbFilenme;

    }
   

    //Method to generate a unique api key every time
    private function generateApiKey(){
        return md5(uniqid(rand(), true));
    }
}