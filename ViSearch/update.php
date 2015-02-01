<?php

require_once 'base_request.php';


class UpdateService extends ViSearchBaseRequest
{
    //
    // constructor for UpdateService
    //   
    function __construct($access_key=NULL, $secret_key=NULL)
    {
        parent::__construct($access_key, $secret_key);
    }
   
    /**
     * insert images
     * @$images is an array list of array
     *  array(
     *      array("im_name"=>"xxxx1","im_url"=>"xxxx1"),
     *      array("im_name"=>"xxxx2","im_url"=>"xxxx2"),
     *      array("im_name"=>"xxxx3","im_url"=>"xxxx3"),
     *      array("im_name"=>"xxxx4","im_url"=>"xxxx4")
     *  );
     */
    function update($images=array()){
        $i=0;
        $params = array();
        foreach ($images as $image) {
            foreach ($image as $key => $value) {
                $param_key = $key."[".$i."]";
                $params[$param_key] = $value;
            }
           $i++;
        }
        return $this->post('insert', $params);
    }

    /**
     * Insert Status
     * This API is for retrieving the insert processing status for an insert transaction.
     */
    function insert_status($trans_id=''){
        return $this->get('insert/status/'.$trans_id);
    }
}
?>
