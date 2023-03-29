<?php
class Main_model extends CI_Model{
    public $paypalEnv       = 'sandbox'; // Or 'production'
    public $paypalURL       = 'https://api.sandbox.paypal.com/v1/';
    public $paypalClientID  = 'AV0tQaQRZXnYjr4d4ZlMPuRVpJElwm8nrtKT5VCuDZRFHRUjHetGVJr0ezFJo2y3KhVDkyD4CkvkbP4C';
    private $paypalSecret   = 'EP7cD4d3CnYxAklrwMknIQdKLHKbmoNUOgzPNL_rTsT2LfRRr_bKglTDiuqHl3BV4LdUgmIBkzzaQmK6';
    function __construct() {
        $this->tableName = 'users';
        $this->primaryKey = 'id';
    }
    
    /*
     * Insert / Update facebook profile data into the database
     * @param array the data for inserting into the table
     */
    public function checkUser($userData = array()){
        if(!empty($userData)){
            //check whether user data already exists in database with same oauth info
            $this->db->select($this->primaryKey);
            $this->db->from($this->tableName);
            $this->db->where(array('oauth_provider'=>$userData['oauth_provider'], 'oauth_uid'=>$userData['oauth_uid']));
            $prevQuery = $this->db->get();
            $prevCheck = $prevQuery->num_rows();
            
            if($prevCheck > 0){
                $prevResult = $prevQuery->row_array();
                
                //update user data
                $userData['modified'] = date("Y-m-d H:i:s");
                $update = $this->db->update($this->tableName, $userData, array('id' => $prevResult['id']));
                
                //get user ID
                $userID = $prevResult['id'];
            }else{
                //insert user data
                $userData['created']  = date("Y-m-d H:i:s");
                $userData['modified'] = date("Y-m-d H:i:s");
                $insert = $this->db->insert($this->tableName, $userData);
                
                //get user ID
                $userID = $this->db->insert_id();
            }
        }
        
        //return user ID
        return $userID?$userID:FALSE;
    }
    public function validate($paymentID, $paymentToken, $payerID, $productID){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->paypalURL.'oauth2/token');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->paypalClientID.":".$this->paypalSecret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $response = curl_exec($ch);
        curl_close($ch);
        
        if(empty($response)){
            return false;
        }else{
            $jsonData = json_decode($response);
            $curl = curl_init($this->paypalURL.'payments/payment/'.$paymentID);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $jsonData->access_token,
                'Accept: application/json',
                'Content-Type: application/xml'
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            
            // Transaction data
            $result = json_decode($response);
            
            return $result;
        }
    
    }
    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}
        function insertData($table,$data){
        $this->db->insert($table,$data);
        $id = $this->db->insert_id();
        $q = $this->db->get_where($table, array('id' => $id));
        return $q->row();
    }
    function convertBalance($id,$oldAB,$oldCB){
        if(isset($id) && $id !== ''){
            $c_balances = $this->getByData('c_balance','u_id',$id);
            $current = $this->dateTime('date').' '.$this->dateTime('time');
            if($c_balances){
            foreach($c_balances as $CBalance){
                $dateTime = $this->dateTime('diff',$CBalance->date,$current);
                if($dateTime['days'] >= 15 OR $dateTime['months'] >= 1 OR $dateTime['years'] >= 1){
                    $newAB = $oldAB + $CBalance->balance;
                    $newCB = $oldCB - $CBalance->balance;
                    $addABalance = $this->update('users','id',$CBalance->u_id,array('a_balance' => $newAB,'c_balance' => $newCB));
                    $this->deleteData('c_balance','id',$CBalance->id);
                }
            }
        }
        }
    }
    function getAllDataAdv($table='items',$col='',$order='',$xyz='',$iaa='',$limit='', $start='',$xyz2='',$iaa2=''){
        /*
        How to use?
        getAllData(columnOrder,orderBy,firstConition,firstConitionValue,limit,start,secondConition,secondConitionValue);
        Don`t forget to change the table or make it dynamic.
        */
        $this->db->from($table);
        $this->db->limit($limit, $start);
        if($xyz !== '' OR $iaa !== ''){
        $this->db->where($xyz,$iaa);
        }
        if($xyz2 !== '' OR $iaa2 !== ''){
        $this->db->where($xyz2,$iaa2);
        }
        $this->db->order_by($col,$order);
        $q = $this->db->get(); 
        
        if($q->num_rows() > 0){
            
            return $q->result();
            
        }else{return false;}
    }
    function getAllDataCond($table='items',$xyz='',$iaa='',$xyz2='',$iaa2=''){
        /*
        How to use?
        getAllData(columnOrder,orderBy,firstConition,firstConitionValue,limit,start,secondConition,secondConitionValue);
        Don`t forget to change the table or make it dynamic.
        */
        $this->db->from($table);
        $this->db->where($xyz,$iaa);
        $this->db->where($xyz2,$iaa2);
        $q = $this->db->get(); 
        
        if($q->num_rows() > 0){
            
            return $q->result();
            
        }else{return false;}
    }
        function getByData($table,$con_col,$con){
        $q=$this->db->get_where($table,array($con_col=>$con));
        if($q->num_rows() > 0){
            
            return $q->result();
            
        }else{return false;}
    }
        public function record_count($keyword='',$table='items') {
        if($keyword !==''){
        $this->db->like('title',$keyword);
        $query  =   $this->db->get('items');
        return $query->num_rows();
        }else{
        return $this->db->count_all($table);
        }
   }
    function getAllData($table,$count = ''){
        
        $q=$this->db->get($table);
        
        if($q->num_rows() > 0){
            if($count == ''){
                return $q->result();
            }else{
                return $q->num_rows();
            }
            
            
        }else{return false;}
    }
    function getFullRequest($table,$con_col,$count=''){
        //$this->main_model->getFullRequest('Table','(Your Statements)');
        $q=$this->db->get_where($table,$con_col);
        if($q->num_rows() > 0){
            if($count==''){
                return $q->result();
            }else{
                return $q->num_rows();
            }
        }else{return false;}
    }
    function list_rule($terms=array()){
        $output = array();
        foreach($terms as $term){
          $output[] = $term;
        }
        $ttype = implode(',', $output);
        return $ttype;
    }
    function alert($title,$description,$id){
        $this->insertData('alerts',array(
            'title'=>$title,
            'description'=>$description,
            'statue'=>0,
            'u_id'=>$id
        ));
    }
    function vthumb($image=''){
        $vthumb = explode('_thumb',$image);
        return 'vthumb_'.$vthumb[0].'_thumb'.$vthumb[1];
    }
    function fullQuery($queryOrder,$count=''){
        $q = $this->db->query($queryOrder,false);
        if($q->num_rows() > 0){
            if($count==''){
                return $q->result();
            }else{
                return $q->num_rows();
            }
        }else{
            return 0;
        }
    }
    function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit) {

            $theta = $lon1 - $lon2;

            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));

            $dist = acos($dist);

             $dist = rad2deg($dist);

              $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
              return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
              } else {
                  return $miles;
                }
        }
    function search($table,$con_col,$liker,$search_item){

                 $this->db->like($liker,$search_item);
                 $query = $this->db->get_where($table,$con_col);
        if($query->num_rows() > 0){
                 return $query->result();
        }else{
            return false;
        }
  }
    function update($table,$con,$id,$data){
        $this->db->where($con,$id);
        $this->db->update($table,$data);
        return TRUE;
    }
    function deleteData($table,$col,$value){
        $this->db->where($col,$value);
        $this->db->delete($table);
    }
    function dateTime($kind='date' ,$fullTime1 ='',$fullTime2 =''){
        $now = new DateTime();
        $now->setTimezone(new DateTimezone('Africa/Cairo'));
        $dateNow = (array) $now;
        $dateTime = explode(' ',$dateNow['date']);
        if($kind=='date'){
            return $dateTime[0];
        }elseif($kind == 'current'){
                $full = explode('.',$dateNow['date']);
                return $full[0];
            }elseif($kind == 'diff'){
            // Declare and define two dates 
            $currentDTime = explode('.',$dateNow['date']);
            $date1 = strtotime($fullTime1);  
            $date2 = strtotime($fullTime2); 
            // Formulate the Difference between two dates 
            $diff = abs($date2 - $date1);  
            // To get the minutes, subtract it with years, 
            // To get the year divide the resultant date into 
            // total seconds in a year (365*60*60*24) 
            $years = floor($diff / (365*60*60*24));  


            // To get the month, subtract it with years and 
            // divide the resultant date into 
            // total seconds in a month (30*60*60*24) 
            $months = floor(($diff - $years * 365*60*60*24) 
                                           / (30*60*60*24));  


            // To get the day, subtract it with years and  
            // months and divide the resultant date into 
            // total seconds in a days (60*60*24) 
            $days = floor(($diff - $years * 365*60*60*24 -  
                         $months*30*60*60*24)/ (60*60*24)); 


            // To get the hour, subtract it with years,  
            // months & seconds and divide the resultant 
            // date into total seconds in a hours (60*60) 
            $hours = floor(($diff - $years * 365*60*60*24  
                   - $months*30*60*60*24 - $days*60*60*24) 
                                               / (60*60));  


            // To get the minutes, subtract it with years, 
            // months, seconds and hours and divide the  
            // resultant date into total seconds i.e. 60 
            $minutes = floor(($diff - $years * 365*60*60*24  
                     - $months*30*60*60*24 - $days*60*60*24  
                                      - $hours*60*60)/ 60);  
            // months, seconds, hours and minutes  
            $seconds = floor(($diff - $years * 365*60*60*24  
                     - $months*30*60*60*24 - $days*60*60*24 
                        - $hours*60*60 - $minutes*60));  
            // Print the result 
                $diffrentiation = array(
                    'years' => $years,
                    'months' => $months,
                    'days' => $days,
                    'hours' => $hours,
                    'minutes' => $minutes,
                    'seconds' => $seconds
                );
                return $diffrentiation;
            }else{
            $timer = explode(':',$dateTime[1]);
            if($timer[0] > 12){
                $hours =$timer[0]-12;
            }else{
                $hours = $timer[0];
            }
            return $hours.':'.$timer[1];
        }
    }
    function random_number($maxlength = 30) {
        $chary = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z",
                        "0", "1", "2", "3", "4", "5", "6", "7", "8", "9",
                        "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
        $return_str = "";
        for ( $x=0; $x<=$maxlength; $x++ ) {
            $return_str .= $chary[rand(0, count($chary)-1)];
        }
        return $return_str;
    }
        public function is_logged_in($accessUser = '',$logCheck = '')
  {
        if($accessUser == '' && $logCheck == ''){
            if($this->session->userdata('fb_access_token') !== ''){
                $record=$this->getByData('users','email',$this->session->userdata('userData')['email']);
                if(isset($record[0]->username)){
                    $user = (array) $record[0];
                    $this->session->set_userdata($user);
                    return 1;
                }else{
                    return 0;
                }
            }elseif($this->session->userdata('password') !== ''){
                $record=$this->getByData('users','email',$this->session->userdata('email'));
                if($record){
                    $user = (array) $record[0];
                    $this->session->set_userdata($user);
                    return 1;
                }else{
                    return 0;
                }
            }
        }elseif($accessUser == 1 && $logCheck == ''){
                //Access User Data
                $email = $this->session->userdata('email');
                $records = $this->getByData('users','email',$email);
                return $records;
            }else{
                //Access User Data
                $records = $this->getByData('users','username',$accessUser);
                if($records == TRUE){
                return $records;
                }else{
                    return 0;
                }
            }
  }
    public function is_admin_logged_in(){
        if($this->session->userdata('password') !== ''){
                $record=$this->getByData('admins','email',$this->session->userdata('email'));
                if($record){
                    return 1;
                }else{
                    return 0;
                }
            }else{
            return 0;
        }
    }
    function youtube($kind='v',$given='http://www.youtube.com/watch?v=C4kxS1ksqtw&feature=relate'){
        if($kind == 'v'){
            $url = $given;
            parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
            return $my_array_of_vars['v'];  
        }elseif($kind == 'img'){
            $image = 'https://img.youtube.com/vi/' . $given . '/mqdefault.jpg';
            return $image;
        }
    }
    function differ($differ){
        if($differ['years'] > 0){
            echo $differ['years'].' سنة ';
        }elseif($differ['days'] > 0){
            echo $differ['days'].' يوم ';
        }elseif($differ['hours'] > 0){
            echo $differ['hours'].' ساعة ';
        }elseif($differ['minutes'] > 0){
            echo $differ['minutes'].' دقيقة ';
        }elseif($differ['seconds'] > 0){
            echo $differ['seconds'].' ثانية ';
        }
        if($differ['years'] > 0 AND $differ['months'] > 0){
            echo ' و '.$differ['months'].' شهر ';
        }
    }
    public function getTickets($order_data = ''){
        $output = '';
        $num = 1;
        while($num <= $order_data['num']){
            $output .= '
        <style type="text/css">
            .paid-ticket{
                padding : 10px;
                width : 700px;
                margin : 10px auto;
                border : 1px solid #333;
                height : 270px;
                direction : rtl;
            }
            .pt-title{
                text-align : center;
                color: #e67e22;
                font-weight:bold;
            }
            .logo{
                float:right;
            }
            .qr{
                float:left;
            }
            .qr img{
                width : 90px;
            }
        </style>
        <title>تذكرة رقم '.$order_data['ticket_id'].'</title>
            <div class="paid-ticket">
                <div class="logo"><img src="https://wjhatna.com/vendor/images/logo.png"></div>
                <div class="qr"><img src="https://wjhatna.com/users/qrCode/'.$order_data['ticket_id'].'-'.$num.'.png"></div>
                <h2 class="pt-title">#TW - '.$order_data['ticket_id'].' | Ticket Price : '.$order_data['price'].' | Order Ticket No. '.$num.'</h2>
                <p><h3><b>Client Username : '.$order_data['username'].'</b></h3></p>
                <p><h3><b>Client E-Mail : '.$order_data['email'].'</b></h3></p>
                <p><h3><b>Reserved On : '.$order_data['date'].'</b></h3></p>
                <p><h3><b>Location On Google Maps : <a href="'.$order_data['google_map_link'].'">'.$order_data['google_map_link'].'</a> - Event Link : <a href="'.$order_data['event_link'].'">Here</a></b></h3></p>
            </div>
        ';
            $num++;
        }
        return $output;
    }
    
}


?>