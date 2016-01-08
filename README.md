#ViSearch PHP SDK
[![Build Status](https://travis-ci.org/visenze/visearch-sdk-php.svg?branch=master)](https://travis-ci.org/visenze/visearch-sdk-php)

----
##Table of Contents
 1. [Overview](#1-overview)
 2. [Setup](#2-setup)
 3. [Initialization](#3-initialization)
 4. [Indexing Images](#4-indexing-images)
	  - 4.1 [Indexing Your First Images](#41-indexing-your-first-images)
	  - 4.2 [Image with Metadata](#42-image-with-metadata)
	  - 4.3 [Updating Images](#43-updating-images)
	  - 4.4 [Removing Images](#44-removing-images)
 5. [Searching Images](#5-searching-images)
	  - 5.1 [Pre-indexed Search](#51-pre-indexed-search)
	  - 5.2 [Color Search](#52-color-search)
	  - 5.3 [Upload Search](#53-upload-search)
	    - 5.3.1 [Selection Box](#531-selection-box)
	    - 5.3.2 [Resizing Settings](#532-resizing-settings)
 6. [Search Results](#6-search-results)
 7. [Advanced Search Parameters](#7-advanced-search-parameters)
	  - 7.1 [Retrieving Metadata](#71-retrieving-metadata)
	  - 7.2 [Filtering Results](#72-filtering-results)
	  - 7.3 [Result Score](#73-result-score)
	  - 7.4 [Automatic Object Recognition Beta](#74-automatic-object-recognition-beta)
 8. [Code Samples](#8-code-samples)
 ----

##1. Overview
ViSearch is an API that provides accurate, reliable and scalable image search. ViSearch API provides endpoints that let developers index their images and perform image searches efficiently. ViSearch API can be easily integrated into your web and mobile applications. More details about ViSearch API can be found in the [documentation](http://www.visenze.com/docs/overview/introduction).

The ViSearch PHP SDK is an open source software for easy integration of ViSearch Search API with your application server. It provides three search methods based on the ViSearch Search API - pre-indexed search, color search and upload search. The ViSearch PHP SDK also provides an easy integration of the ViSearch Data API which includes data inserting and data removing. For source code and references, visit the github [repository](https://github.com/visenze/visearch-sdk-php).

 Current stable version: 1.0.0
 
 Minimum requirement: php5 and php5-curl

##2. Setup
You can get the source code of the SDK and demos from the [Github repo](https://github.com/visenze/visearch-sdk-php).

Download the [ViSearch SDK](https://github.com/visenze/visearch-sdk-php) and place the ViSearch to your project directory.

Include ViSearch API into your project.

````
//To Include ViSearch API
require_once 'pathTo/ViSearch/viSearch.php';
````

##3. Initialization
To start using ViSearch API, initialize ViSearch client with your ViSearch API credentials. Your credentials can be found in [ViSearch Dashboard](https://dashboard.visenze.com):

````
//To Use ViSearch API
$service = new ViSearch($access_key,$secret_key);

````
##4. Indexing Images


###4.1 Indexing Your First Images

Built for scalability, ViSearch API enables fast and accurate searches on high volume of images. Before making your first image search, you need to prepare a list of images and index them into ViSearch by calling the /insert endpoint. Each image must have a unique identifier and a publicly downloadable URL. ViSearch will parallelly fetch your images from the given URLs, and index the downloaded for searching. After the image indexes are built, you can start searching for [similar images using the unique identifier] (https://github.com/visenze/visearch-sdk-java/blob/master/README.md#51-pre-indexed-search), [using a color] (https://github.com/visenze/visearch-sdk-java/blob/master/README.md#52-color-search), or [using another image] (https://github.com/visenze/visearch-sdk-java/blob/master/README.md#53-upload-search).

To index your images, prepare a list of Images and call the /insert endpoint. 

````

// the list of images to be indexed
$images = array();
// the unique identifier of the image 'im_name', the publicly downloadable url of the image 'im_url'
$images[] = array('im_name'=>'red_dress','im_url'=>'http://mydomain.com/images/red_dress.jpg');
$images[] = array('im_name'=>'blue_dress','im_url'=>'http://mydomain.com/images/blue_dress.jpg');
// calls the /insert endpoint to index the image
$response = $service->insert($images);
````
 > Each ```insert``` call to ViSearch accepts a maximum of 100 images. We recommend indexing your images in batches of 100 for optimized image indexing speed.


###4.2 Image with Metadata

Images usually come with descriptive text or numeric values as metadata, for example:
title, description, category, brand, and price of an online shop listing image
caption, tags, geo-coordinates of a photo.

ViSearch combines the power of text search with image search. You can index your images with metadata, and leverage text based query and filtering for even more accurate image search results, for example:
limit results within a price range
limit results to certain tags, and some keywords in the captions
For detailed reference for result filtering, see [Advanced Search Parameters](https://github.com/visenze/visearch-sdk-php/blob/master/README.md#7-advanced-search-parameters).

To index your images with metadata, first you need to configure the metadata schema in ViSearch Dashboard (link to). You can add and remove metadata keys, and modify the metadata types to suit your needs.

Let's assume you have the following metadata schema configured:

| Name | Type | Searchable |
| ---- | ---- | ---------- |
| title | string | true |
| description | text | true |
| price | float | true |

Then index your image with title, decription, and price:

````
$images[] = array('im_name'=>'blue_dress','im_url'=>'http://mydomain.com/images/blue_dress.jpg','title'=>'Blue Dress', 'description'=>'A blue dress', 'price'=> 100.0f);
// calls the /insert endpoint to index the image
$response = $service->insert($images);
`````
Metadata keys are case-sensitive, and metadata without a matching key in the schema will not be processed by ViSearch. Make sure to configure metadata schema for all of your metadata keys.

###4.3 Updating Images

If you need to update an image or its metadata, call the ```insert``` endpoint with the same unique identifier of the image. ViSearch will fetch the image from the updated URL and index the new image, and replace the metadata of the image if provided.

````
$images[] = array('im_name'=>'blue_dress','im_url'=>'http://mydomain.com/images/blue_dress.jpg','title'=>'Blue Dress', 'description'=>'A blue dress', 'price'=> 100.0f);
// calls the /insert endpoint to index the image
$response = $service->update($images);
`````

 > Each ```insert``` call to ViSearch accepts a maximum of 100 images. We recommend updating your images in batches of 100 for optimized image indexing speed.

###4.4 Removing Images

In case you decide to remove some of the indexed images, you can call the /remove endpoint with the list of unique identifier of the indexed images. ViSearch will then remove the specified images from the index. You will not be able to perform pre-indexed search on this image, and the image will not be found in any search result.

````
$response = $service->remove(array("red_dress","blue_dress"));
````

> We recommend calling ```remove``` in batches of 100 images for optimized image indexing speed.

##5. Searching Images

###5.1 Pre-indexed Search
Pre-index search is to search similar images based on the your indexed image by its unique identifier (im_name). It  should be a valid ID that is used to index your images in the database.

````
$service = new ViSearch($access_key,$secret_key);
$service->idsearch("blue_dress");
````

###5.2 Color Search
Color search is to search images with similar color by providing a color code. The color code should be in Hexadecimal and passed to the colorsearch service.

````
$service->colorsearch("fa4d4d");
````

###5.3 Upload Search
Upload search is used to search similar images by uploading an image or providing an image url. `Image` class is used to perform the image encoding and resizing. You should construct the `Image` object and pass it to uploadsearch to start a search.

Using an image from a local file path

````
$image = new Image(imagePath);
$response = $service->uploadsearch($image);
````

Alternatively, you can pass an image url directly to uploadsearch to start the search.

````
$image = new Image('http://mydomain.com/images/red_dress.jpg');
$response = $service->uploadsearch($image);
````

####5.3.1 Selection Box

If the object you wish to search for takes up only a small portion of your image, or other irrelevant objects exists in the same image, chances are the search result could become inaccurate. Use the Box parameter to refine the search area of the image to improve accuracy. Noted that the box coordinated is setted with respect to the original size of the image passed, it will be automatically scaled to fit the resized image for uploading:

```
$image = new Image(imagePath);
// create the box to refine the area on the searching image
// Box(x1, y1, x2, y2) where (0,0) is the top-left corner
// of the image, (x1, y1) is the top-left corner of the box,
// and (x2, y2) is the bottom-right corner of the box.
$box = new Box(0,0,10,10);
$image->set_box($box);
```
####5.3.2 Resizing Settings
When performing upload search, you may notice the increased search latency with increased image file size. This is due to the increased time spent in network transferring your images to the ViSearch server, and the increased time for processing larger image files in ViSearch. 

To reduce upload search latency, by default the uploadSearch method makes a copy of your image file and resizes the copy to 512x512 pixels if both of the original dimensions exceed 512 pixels. This is the optimized size to lower search latency while not sacrificing search accuracy for general use cases:

````
$resizeSettings = new ResizeSettings();
//default resize setting, set the image size to 512 x 512 with jpeg 75 quality
$image = new Image(imagePath, $resizeSettings);
````

If your image contains fine details such as textile patterns and textures, you can use a higer quality image for search to get better search result:

````
//for images with fine details, use HIGH resize settings 1024 x 1024 and jpeg 90 quality
$image = new Image(imagePath, $resizeSettings->getHigh());
````

Or, provide the customized resize settings:

````
//resize the image to 800 by 800 area using jpeg 80 quality
$image = new Image(imagePath, new ResizeSettings(800, 800, 80));
````

##6. Search Results

ViSearch returns a maximum number of 1000 most relevant image search results. You can provide pagination parameters to control the paging of the image search results.

Pagination parameters:

| Name | Type | Description |
| ---- | ---- | ----------- |
| page | Integer | Optional parameter to specify the page of results. The first page of result is 1. Defaults to 1. |
| limit | Integer | Optional parameter to specify the result per page limit. Defaults to 10. |

````
$page = 1;
$limit = 25;
$response = $service->uploadsearch($image, $page, $limit);
````


##7. Advanced Search Parameters

###7.1 Retrieving Metadata

To retrieve metadata of your image results, provide the list of metadata keys for the metadata value to be returned in the `fl` (field list) property:

````
$fl = array("price","brand","title","im_url");
$response = $service->uploadsearch($image, $page, $limit, $fl);
````

To retrieve all metadata of your image results, specify ```get_all_fl``` parameter and set it to ```True```:

```
$get_all_fl = True
$fq = array();
$response = $service->uploadsearch($image, $page, $limit, $fl, $fq, $get_all_fl);
```

 > Only metadata of type string, int, and float can be retrieved from ViSearch. Metadata of type text is not available for retrieval.

###7.2 Filtering Results

To filter search results based on metadata values, provide a map of metadata key to filter value in the `fq` (filter query) property:

````
$fq = array("im_cate" => "bags");
$response = $service->uploadsearch($image, $page, $limit, $fl, $fq);
````

Querying syntax for each metadata type is listed in the following table:

Type | FQ
--- | ---
string | Metadata value must be exactly matched with the query value, e.g. "Vintage Wingtips" would not match "vintage wingtips" or "vintage"
text | Metadata value will be indexed using full-text-search engine and supports fuzzy text matching, e.g. "A pair of high quality leather wingtips" would match any word in the phrase
int | Metadata value can be either: <ul><li>exactly matched with the query value</li><li>matched with a ranged query ```minValue,maxValue```, e.g. int value ```1, 99```, and ```199``` would match ranged query ```0,199``` but would not match ranged query ```200,300```</li></ul>
float | Metadata value can be either <ul><li>exactly matched with the query value</li><li>matched with a ranged query ```minValue,maxValue```, e.g. float value ```1.0, 99.99```, and ```199.99``` would match ranged query ```0.0,199.99``` but would not match ranged query 200.0,300.0</li></ul>

###7.3 Result Score

ViSearch image search results are ranked in descending order i.e. from the highest scores to the lowest, ranging from 1.0 to 0.0. By default, the score for each image result is not returned. You can turn on the ```score``` property to retrieve the scores for each image result:

````
$score = true;
$response = $service->uploadsearch($image, $page, $limit, $fl, $fq, $get_all_fl, $score);
````

If you need to restrict search results from a minimum score to a maximum score, specify the ```score_min``` and/or ```score_max``` parameters:

Name | Type | Description
---- | ---- | -----------
score_min | Float | Minimum score for the image results. Default is 0.0.
score_max | Float | Maximum score for the image results. Default is 1.0.

````
$score_min = 0.5;
$score_max = 0.8;
$response = $service->uploadsearch($image, $page, $limit, $fl, $fq, $get_all_fl, $score, $score_max, $score_min);
````
###7.4 Automatic Object Recognition Beta
With Automatic Object Recognition, ViSearch /uploadsearch API is smart to detect the objects present in the query image and suggest the best matched product type to run the search on. 

You can turn on the feature in upload search by setting the API parameter "detection=all". We are now able to detect various types of fashion items, including `Top`, `Dress`, `Bottom`, `Shoe`, `Bag`, `Watch` and `Indian Ethnic Wear`. The list is ever-expanding as we explore this feature for other categories. 

Notice: This feature is currently available for fashion application type only. You will need to make sure your app type is configurated as "fashion" on [ViSenze dashboard](https://developers.visenze.com/setup/#Choose-Your-Application-Type). 

```
$detection = 'all';
$response = $service->uploadsearch($image, $page, $limit, $fl, $fq, $get_all_fl, $score, $score_max, $score_min, $detection);
```

You could also recognize objects from a paticular type on the uploaded query image through configuring the detection parameter to a specific product type as "detection={type}". Our API will run the search within that product type.

Sample request to detect `bag` in an uploaded image:

```
$detection = 'bag';
$response = $service->uploadsearch($image, $page, $limit, $fl, $fq, $get_all_fl, $score, $score_max, $score_min, $detection);
```

The detected product types are listed in `product_types` together with the match score and box area of the detected object. Multiple objects can be detected from the query image and they are ranked from the highest score to lowest. The full list of supported product types by our API will also be returned in `product_types_list`. 

##8. Code Samples

Example code of the ViSearch PHP SDK can be found in [visearch-php-example](https://github.com/visenze/visearch-sdk-php).
