<?php

require_once 'base_request.php';


class SearchService extends ViSearchBaseRequest
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
     * @$qinfo, If true, query information will be returned.
     */
    function idsearch($im_name=NULL,$score=false, $fq=array(), $fl=array(), $page=1, $limit=30, $qinfo=false){
        $params = array(
            'im_name' => $im_name,
            'score'=> $score,
            'page'=> $page,
            'limit' => $limit,
            'qinfo' => $qinfo,
            'fq' => $fq,
            'fl' => $fl
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
     * @$qinfo, If true, query information will be returned.
     */
    function colorsearch($color=NULL,$score=false, $fq=array(), $fl=array(), $page=1, $limit=30, $qinfo=false){
        $params = array(
            'color' => $color,
            'score'=> $score,
            'page'=> $page,
            'limit' => $limit,
            'qinfo' => $qinfo,
            'fq' => $fq,
            'fl' => $fl
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
     * @$qinfo, If true, query information will be returned.
     */
    function uploadsearch($image=NULL, $box=NULL, $score=false, $fq=array(), $fl=array(), $page=1, $limit=30, $qinfo=false){
       if (!gettype($image) == 'object' || !get_class($image) == 'Image')
        throw new ViSearchException('Need to pass a image object');

        $params = array(
            'score'=> $score,
            'page'=> $page,
            'limit' => $limit,
            'qinfo' => $qinfo,
            'fq' => $fq,
            'fl' => $fl
        );
        if(!empty($image->get_box())){
            $params["box"] = $image->get_box();
        }
        if($image -> is_http_image()){
            $params["im_url"]= $image->get_path();
            return $this->get('uploadsearch', $params);
        }else {
            $params['image'] = "@{$image->local_filepath}";
            return $this->post_multipart('uploadsearch', $params);
        }
    }
}
?>
