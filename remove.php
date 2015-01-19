<?php

require_once 'base_request.php';


class RemoveService extends ViSearchBaseRequest
{
    //
    // constructor for RemoveService
    //   
    function __construct($access_key=NULL, $secret_key=NULL)
    {
        parent::__construct($access_key, $secret_key);
    }
   
    /**
     * This API is for removing images from the image collection.
     * @$im_names, image names list.
     *      this parameter should be like this:
     *      array(
     *           "xxxxxx1",
     *           "xxxxxx2"
     *      ) 
     */
    function remove($im_names=array()){
        $params = array();
        $i=0;
        foreach ($im_names as $im_name) {
           $key = "im_names[".$i."]";
           $params[$key]=$im_name;
           $i++;
        }
        
        return $this->post('remove', $params);
    }
}
?>
