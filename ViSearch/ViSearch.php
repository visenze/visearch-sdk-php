<?php

require_once 'base_request.php';


class ViSearch extends ViSearchBaseRequest
{
    //
    // constructor for SearchService
    //
    function __construct($access_key=NULL, $secret_key=NULL)
    {
        parent::__construct($access_key, $secret_key);
    }
   
    /**
     * idsearch
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
    function idsearch($im_name=NULL, $page=1, $limit=30, $fl=array(), $fq=array(), $score=false, $score_max=1, $score_min=0, $get_all_fl=false){
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
    function colorsearch($color=NULL,$page=1, $limit=30, $fl=array(), $fq=array(), $score=false, $score_max=1, $score_min=0, $get_all_fl=false){
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
    function uploadsearch($image=NULL, $page=1, $limit=30, $fl=array(), $fq=array(), $score=false, $score_max=1, $score_min=0, $get_all_fl=false){
       if (!gettype($image) == 'object' || !get_class($image) == 'Image')
        throw new ViSearchException('Need to pass a image object');

        $params = array(
            'score'=> $score,
            'page'=> $page,
            'limit' => $limit,
            'fq' => $fq,
            'fl' => $fl,
            'score_max'=>$score_max,
            'score_min'=>$score_min,
            'get_all_fl'=>$get_all_fl
        );
        $box = $image->get_box();
        if(!empty($box)){
            $params["box"] = $image->get_box_parse();
        }
        if($image -> is_http_image()){
            $params["im_url"]= $image->get_path();
            return $this->get('uploadsearch', $params);
        }else {
            $params['image'] = "@{$image->local_filepath}";
            return $this->post_multipart('uploadsearch', $params);
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
    /**
     * Insert Status
     * This API is for retrieving the insert processing status for an insert transaction.
     */
    function insert_status($trans_id=''){
        return $this->get('insert/status/'.$trans_id);
    }
}
?>
