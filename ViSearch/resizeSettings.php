<?php
class ResizeSettings
{
    function __construct($width = 512, $height = 512, $quality =75)
    {
        $this->width = $width;
        $this->height = $height;
        if ($quality > 100) {
            $quality = 100;
        }
        if ($quality < 0) {
            $quality = 0;
        }
        $this->quality = $quality;
    }
    public function getStandard(){
        return new ResizeSettings(512,512,75);
    }
    public function getHigh(){
        return new ResizeSettings(1024,1024,75);
    }
}
?>