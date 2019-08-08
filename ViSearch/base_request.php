<?php

// include Requests library
require_once 'library/Requests.php';
require_once 'image.php';

// make sure Requests can load internal classes
Requests::register_autoloader();
 
class ViSearchBaseRequest
{
    
    const HOST_API_URL='https://visearch.visenze.com';
    const SDK_VERSION='visearch-php-sdk/1.2.1';

    function __construct($access_key=NULL, $secret_key=NULL, $endpoint=NULL)
    {
        $this->access_key =$access_key;
        $this->secret_key =$secret_key;
        if ($endpoint != NULL) {
            $this->endpoint = $endpoint;
        }else {
            $this->endpoint = self::HOST_API_URL;        
        }
    }

    /**
     * post a post request.
     */
    protected function post($method, $params=array(), $headers= array(), $options= array())
    {
        # construct the query URL.
        $url = $this->endpoint . "/" . $method ;

        $auth_head = $this->get_auth_header($this->access_key,$this->secret_key);
        if(!$headers){
            $headers = array();
        }
        if(!$options){
            $options = array();
        }
        // set timeout
        $options['timeout'] = 10*60; 
        $options['useragent'] = self::SDK_VERSION;

        $headers['Authorization']=$auth_head;
        $headers['X-Requested-With']=self::SDK_VERSION;

        $response = Requests::post($url, $headers, $params, $options);

        # Handle any HTTP errors.
        if ($response->status_code != 200)
            throw new ViSearchException("HTTP failure, status code $response->status_code");

        # get the response as an object.
        $response_json = json_decode($response->body);

        return $response_json;
    }

    /**
     * post a GET request.
     */
    protected function get($method, $params=array(), $headers= array(), $options= array())
    {
        # construct the query URL.
        $url = $this->endpoint . "/" . $method ;

        $auth_head = $this->get_auth_header($this->access_key,$this->secret_key);
        if(!$headers){
            $headers = array();
        }
        if(!$options){
            $options = array();
        }
        // set timeout
        $params['timeout'] = 10*60;

        $headers['Authorization']=$auth_head;
        $headers['X-Requested-With']=self::SDK_VERSION;
        // build query url.
        $url = $this->build_http_parameters($url,$params);

        // echo "$url";
        $response = Requests::get($url, $headers, $params, $options);
        // echo $response->body;
        # Handle any HTTP errors.
        if ($response->status_code != 200)
            throw new ViSearchException("HTTP failure, status code $response->status_code");

        # get the response as an object.
        $response_json = json_decode($response->body);

        return $response_json;
    }

    /**
     * got not working when use Requests library to post file, so here we change to use local curl package.
     * so 
     */
    protected function post_multipart($method, $params=array(), $headers= array(), $options= array()){
        $url = $this->endpoint . "/" . $method ;

        $auth_head = $this->get_auth_header($this->access_key,$this->secret_key);
        if(!$headers){
            $headers = array();
        }

        $image_param = null;
        if(!empty($params['image'])) {
            $image_param = array('image' => $params['image']);
            unset($params['image']);    
        }
        
        $url = $this->build_http_parameters($url,$params);

        $headers[0]='Authorization: '.$auth_head;
        $headers[1]='X-Requested-With: '.self::SDK_VERSION;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        if($image_param != null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $image_param);    
        }
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT,600);
        $result = curl_exec($ch);
        curl_close($ch);
        $response_json = json_decode($result);
        return $response_json;
    }

    protected function get_auth_header($access_token=NULL, $secret_key=NULL)
    {
        $pair = $access_token.':'.$secret_key;
        $base64String = base64_encode($pair);
        return 'Basic '.$base64String;
    }

    // check if PHP array is associative or sequential?
    protected function is_assoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    protected function ensure_multipart_parameters($params=array()) {
        foreach ($params as $key => $value) {
            if(is_bool($value)){
                $bool_res = ($value) ? 'true' : 'false';
                $params["$key"]=$bool_res;
            }
            if(is_array($value)){
                $is_assoc = $this->is_assoc($value);
                $numItems = count($value);
                $i = 0;
                $fls = "";
                foreach ($value as $p_key=>$p_val) {
                    if(is_array($p_val)){
                       continue;
                    }
                    if($is_assoc){
                        $fls.= $p_key.':'.$p_val;
                    }else{
                        $fls.= $p_val;
                    }
                    if(++$i < $numItems) {
                        $fls.= ',';
                    }
                }
                $fls = rtrim($fls, ",");
                $params["$key"]= $fls;
            }
        }
        return $params;
    }

    protected function build_http_parameters($base_url='', $params=array())
    {
        $query_string = $base_url;
        if (strpos($query_string,'?') == false) {
            $query_string .= '?';
        }
        foreach ($params as $key => $value) {
            if(is_array($value)){
                if($key == 'fl'){
                    foreach ($value as $value_child) {
                         $query_string .= $key . '=' . $value_child . '&';
                    }
                }else if($key=='fq'){
                    foreach ($value as $fq_key => $fq_value) {
                         $query_string .= $key . '=' . $fq_key . ':' . $fq_value . '&';
                    }
                }
            }else if(is_bool($value)){
                $bool_res = ($value) ? 'true' : 'false';
                $query_string .= $key . '=' . $bool_res . '&';
            }else{
                $query_string .= $key . '=' . $value . '&';
            }
        }
        return $query_string;
    }

    /**
     * print json string out
     */
    function print_json($data)
    {
        if(is_string($data)){
            $data = json_decode($data);
        }
        $json_string = json_encode($data, JSON_PRETTY_PRINT);
        echo $json_string;
    }

}
?>
