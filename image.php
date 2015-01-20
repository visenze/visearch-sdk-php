<?php

class Image
{
    /// Construct an object describing an image.

    /// Arguments:
    /// `file`, the path to the image, if it is to be taken from a file. or a upload file object
    ///
    function __construct($file = '', $box = null)
    {   
        if(empty($file)) {
            throw ViSearchException("Please input a valid local image file path or http image url");
        }
        // $this->data = null;
        $this->box = $box;
        $this->local_filepath = $file;
        if( ! $this->is_http_image($file)){
            if(is_string($file) && !$this->__startsWith($file,'/') ){
                // a relative file
                $this->local_filepath = realpath(dirname($_SERVER["SCRIPT_FILENAME"])).'/'.$file;
            }else if(is_array($file) && array_key_exists('tmp_name', $file) ){
                $this->local_filepath = $file['tmp_name'];
            }
        }
    }

    ///
    /// Return a human-readable description of the object.
    ///
    function __toString()
    {
        return "Image(local_filepath=$this->local_filepath)";
    }

    function __startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }

    function get_path() 
    {
        return $this->local_filepath;
    }

    function get_box()
    {
        return $this->box;
    }

    function is_http_image() {
        if(is_string($this->local_filepath))
            return $this->__startsWith($this->local_filepath,"http://") || $this->__startsWith($this->local_filepath,"https://");
        else
            return false;
    }
}

?>