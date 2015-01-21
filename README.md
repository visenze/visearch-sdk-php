ViSearch PHP SDK
================

##Overview

* [Setup](#setup)
* [Initialization](#initialization)
* [Inserting Images](#inserting-images)
* [Removing Images](#removing-images)
* [Searching Images](#searching-images)

##Setup

The ViSearch PHP SDK is dependent on php5.4+ and php5-curl.You may include the latest SDK into your project folder
````
require_once '../visearch-php/search.php';
```` 

##Initialization

````
$service = new SearchService($access_key,$secret_key);
````
##Inserting Images
````
$images = array();
$images[] = array('im_name'=>"",'im_url'=>"");
$response = $service->insert($images);

````

##Removing Images
````
$service = new RemoveService($access_key,$secret_key);

$response = $service->remove(array("",""));
// output the response
$service->print_json($response );
````

##Searching Images

	1. Search by id
````
$response = $service->idsearch("",true, NULL, array("price","brand"));
````
	2. Search by color
````
$response = $service->colorsearch("fa4d4d");
````
	3. Search by uploading
* image 
````
$image = new Image('test_file.png');
$response = $service->uploadsearch($image);
````
* url
````
$image = new Image('http://cdn-static.cnet.co.uk/i/product_media/40001253/image1/440x330-iphone-5-main.jpg');
$response = $service->uploadsearch($image);
````