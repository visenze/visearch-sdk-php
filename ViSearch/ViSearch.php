<?php

require_once 'base_request.php';


class ViSearch extends ViSearchBaseRequest
{
    //
    // constructor for SearchService
    //
    function __construct($access_key=NULL, $secret_key=NULL, $endpoint=NULL)
    {
        parent::__construct($access_key, $secret_key, $endpoint);
    }

    /**
     * recommendation
     * @$im_name, The image name of the image to search against the image collection.
     * @$score, If the value is true, the scores for each returned image will be included in the response.
     * @$fq, The metadata fields to filter the results. Only fields marked with ‘searchable’ in ViSearch Dashboard can be used as filters.
     *      this parameter should be like this:
     *      array(
     *           "brand" => "my_brand",
     *           "price" => "0,199"
     *      )
     * @$fl, The metadata fields to be returned. The values are returned in the value_map property of the results.
     *      this parameter should be like this:
     *      array(
     *           "brand",
     *           "price"
     *      ) 
     * @$page, The result page number.
     * @$limit, The number of results returned per page. The maximum number of results returned from the API is 1000.
     * @get_all_fl, If the value is true, All field list will be returned in the query
    */
    function recommendation($im_name=NULL, $page=1, $limit=30, $fl=array(), $fq=array(), $get_all_fl=false, $score=false, $score_max=1, $score_min=0){
        $params = array(
            'im_name' => $im_name,
            'score'=> $score,
            'page'=> $page,
            'limit' => $limit,
            'fq' => $fq,
            'fl' => $fl,
            'score_max'=>$score_max,
            'score_min'=>$score_min,
            'get_all_fl'=>$get_all_fl
        );
        return $this->get('recommendation', $params);
    }
   
    /**
     * search
     * @$im_name, The image name of the image to search against the image collection.
     * @$score, If the value is true, the scores for each returned image will be included in the response.
     * @$fq, The metadata fields to filter the results. Only fields marked with ‘searchable’ in ViSearch Dashboard can be used as filters.
     *      this parameter should be like this:
     *      array(
     *           "brand" => "my_brand",
     *           "price" => "0,199"
     *      )
     * @$fl, The metadata fields to be returned. The values are returned in the value_map property of the results.
     *      this parameter should be like this:
     *      array(
     *           "brand",
     *           "price"
     *      ) 
     * @$page, The result page number.
     * @$limit, The number of results returned per page. The maximum number of results returned from the API is 1000.
     * @get_all_fl, If the value is true, All field list will be returned in the query
     */
    function search($im_name=NULL, $page=1, $limit=30, $fl=array(), $fq=array(), $get_all_fl=false, $score=false, $score_max=1, $score_min=0){
        $params = array(
            'im_name' => $im_name,
            'score'=> $score,
            'page'=> $page,
            'limit' => $limit,
            'fq' => $fq,
            'fl' => $fl,
            'score_max'=>$score_max,
            'score_min'=>$score_min,
            'get_all_fl'=>$get_all_fl
        );
        return $this->get('search', $params);
    }

    /**
     * colorsearch
     * @$color, The 6 character hex color..
     * @$score, If the value is true, the scores for each returned image will be included in the response.
     * @$fq, The metadata fields to filter the results. Only fields marked with ‘searchable’ in ViSearch Dashboard can be used as filters.
     *      this parameter should be like this:
     *      array(
     *           "brand" => "my_brand",
     *           "price" => "0,199"
     *      )
     * @$fl, The metadata fields to be returned. The values are returned in the value_map property of the results.
     *      this parameter should be like this:
     *      array(
     *           "brand",
     *           "price"
     *      ) 
     * @$page, The result page number.
     * @$limit, The number of results returned per page. The maximum number of results returned from the API is 1000.
     * @get_all_fl, If the value is true, All field list will be returned in the query
     */
    function colorsearch($color=NULL,$page=1, $limit=30, $fl=array(), $fq=array(), $get_all_fl=false, $score=false, $score_max=1, $score_min=0){
        $params = array(
            'color' => $color,
            'score'=> $score,
            'page'=> $page,
            'limit' => $limit,
            'fq' => $fq,
            'fl' => $fl,
            'score_max'=>$score_max,
            'score_min'=>$score_min,
            'get_all_fl'=>$get_all_fl
        );
        return $this->get('colorsearch', $params);
    }

    /**
     * uploadsearch
     * @$image, 
     *      query image object, it must be a Image object.
     * @$score, If the value is true, the scores for each returned image will be included in the response.
     * @$fq, The metadata fields to filter the results. Only fields marked with ‘searchable’ in ViSearch Dashboard can be used as filters.
     *      this parameter should be like this:
     *      array(
     *           "brand" => "my_brand",
     *           "price" => "0,199"
     *      )
     * @$fl, The metadata fields to be returned. The values are returned in the value_map property of the results.
     *      this parameter should be like this:
     *      array(
     *           "brand",
     *           "price"
     *      ) 
     * @$page, The result page number.
     * @$limit, The number of results returned per page. The maximum number of results returned from the API is 1000.
     * @get_all_fl, If the value is true, All field list will be returned in the query
     */
    function uploadsearch($image=NULL, $page=1, $limit=30, $fl=array(), $fq=array(), $get_all_fl=false, $score=false, $score_max=1, $score_min=0, $detection=NULL){
       if (!gettype($image) == 'object' || !get_class($image) == 'Image')
        throw new ViSearchException('Need to pass a image object');

        if(!$image->is_valid_image())
            throw new ViSearchException("Please input a valid local image file path or http image url or im_id");

        $params = array(
            'score'=> $score,
            'page'=> $page,
            'limit' => $limit,
            'fq' => $fq,
            'fl' => $fl,
            'score_max'=>$score_max,
            'score_min'=>$score_min,
            'get_all_fl'=>$get_all_fl,
            'detection'=>$detection
        );

        $box = $image->get_box();
        if(!empty($box)){
            $params["box"] = $image->get_box_parse();
        }

        $im_id = $image->get_im_id();

        if(!empty($im_id)) {
            $params["im_id"] = $im_id;
            return $this->post_multipart('uploadsearch', $params);
        } else if ($image -> is_http_image()){
            $params["im_url"]= $image->get_path();
            return $this->post_multipart('uploadsearch', $params);
        }else {
            if (class_exists('CURLFile')) {
                $params['image'] = new CURLFile(realpath($image->local_filepath));
            } else {
                $params['image'] = "@{$image->local_filepath}";
            }
            return $this->post_multipart('uploadsearch', $params);
        }
    }

    /**
     * discover search
     * @$image, 
     *      query image object, it must be a Image object.
     * @$score, If the value is true, the scores for each returned image will be included in the response.
     * @$fq, The metadata fields to filter the results. Only fields marked with ‘searchable’ in ViSearch Dashboard can be used as filters.
     *      this parameter should be like this:
     *      array(
     *           "brand" => "my_brand",
     *           "price" => "0,199"
     *      )
     * @$fl, The metadata fields to be returned. The values are returned in the value_map property of the results.
     *      this parameter should be like this:
     *      array(
     *           "brand",
     *           "price"
     *      ) 
     * @$page, The result page number.
     * @$limit, The number of results returned per page. The maximum number of results returned from the API is 1000.
     * @get_all_fl, If the value is true, All field list will be returned in the query
     */
    function discoversearch($image=NULL, $page=1, $limit=30, $fl=array(), $fq=array(), $get_all_fl=false, $score=false, $score_max=1, $score_min=0, $detection=NULL){
       if (!gettype($image) == 'object' || !get_class($image) == 'Image')
        throw new ViSearchException('Need to pass a image object');

        if(!$image->is_valid_image())
            throw new ViSearchException("Please input a valid local image file path or http image url or im_id");

        $params = array(
            'score'=> $score,
            'page'=> $page,
            'limit' => $limit,
            'fq' => $fq,
            'fl' => $fl,
            'score_max'=>$score_max,
            'score_min'=>$score_min,
            'get_all_fl'=>$get_all_fl,
            'detection'=>$detection
        );

        $box = $image->get_box();
        if(!empty($box)){
            $params["box"] = $image->get_box_parse();
        }

        $im_id = $image->get_im_id();

        if(!empty($im_id)) {
            $params["im_id"] = $im_id;
            return $this->post_multipart('discoversearch', $params);
        } else if ($image -> is_http_image()){
            $params["im_url"]= $image->get_path();
            return $this->post_multipart('discoversearch', $params);
        }else {
            if (class_exists('CURLFile')) {
                $params['image'] = new CURLFile(realpath($image->local_filepath));
            } else {
                $params['image'] = "@{$image->local_filepath}";
            }
            return $this->post_multipart('discoversearch', $params);
        }
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
    function insert($images=array()){
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
     * update images
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
     * This API is for removing images from the image collection.
     * @$image_names, list of im_name.
     *      this parameter should be like this:
     *      array(
     *           "xxxxxx1",
     *           "xxxxxx2"
     *      )
     */
    function remove($image_names=array()){
        $params = array();
        $i=0;
        foreach ($image_names as $im_name) {
           $key = "im_name[".$i."]";
           $params[$key]=$im_name;
           $i++;
        }

        return $this->post('remove', $params);
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
