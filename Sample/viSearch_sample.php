
<?php

require_once '../ViSearch/ViSearch.php';


//replace the following with your access and secret key and im_name
$access_key = getenv('ACCESS_KEY'); //ACCESS_KEY
$secret_key = getenv('SECRET_KEY'); //SECRET_KEY
$im_name = getenv('IM_NAME'); //IM_NAME

$service = new ViSearch($access_key,$secret_key);

echo "\n############################################\n";
echo "# recommendation testing\n";
echo "############################################\n";
$fl = array('im_url');
$response = $service->recommendation($im_name,true, NULL, $fl);
// output the response
$service->print_json($response );

echo "\n############################################\n";
echo "# idsearch testing\n";
echo "############################################\n";

$response = $service->search($im_name);
// output the response
$service->print_json($response);

echo "\n############################################\n";
echo "# colorsearch testing\n";
echo "############################################\n";

$response = $service->colorsearch("fa4d4d");
// output the response
$service->print_json($response );

echo "\n############################################\n";
echo "# uploadsearch testing\n";
echo "############################################\n";

$image = new Image('test_file.png');
$response = $service->uploadsearch($image);
// output the response
$service->print_json($response );


echo "\n############################################\n";
echo "# uploadsearch testing with image_url\n";
echo "############################################\n";

$image = new Image('http://cdn-static.cnet.co.uk/i/product_media/40001253/image1/440x330-iphone-5-main.jpg');
$response = $service->uploadsearch($image);
// output the response
$service->print_json($response );

echo "\n############################################\n";
echo "# discoversearch testing with image_url\n";
echo "############################################\n";

$image = new Image('http://cdn-static.cnet.co.uk/i/product_media/40001253/image1/440x330-iphone-5-main.jpg');
$response = $service->discoversearch($image);
// output the response
$service->print_json($response );

echo "\n############################################\n";
echo "# discoversearch testing local file\n";
echo "############################################\n";

$image = new Image('test_file.png');
$response = $service->discoversearch($image);
// output the response
$service->print_json($response );

echo "\n############################################\n";
echo "# insert image testing\n";
echo "############################################\n";

$images = array();
// images1
$images[] = array('im_name'=>'897412111','im_url'=>'http://www.elle.com.hk/var/ellehk/storage/images/fashion/street_snap/fashion-week-ss14-sneakers/style20/12207525-1-chi-HK/Style20.jpg');
// images2
$images[] = array('im_name'=>'897412112','im_url'=>'http://www.elle.com.hk/var/ellehk/storage/images/fashion/street_snap/fashion-week-ss14-sneakers/style20/12207525-1-chi-HK/Style20.jpg');
// $response = $service->insert($images);
// output the response
// $service->print_json($response );

echo "\n############################################\n";
echo "# update image testing\n";
echo "############################################\n";

$images = array();
// images1
$images[] = array('im_name'=>'897412111','im_url'=>'http://www.elle.com.hk/var/ellehk/storage/images/fashion/street_snap/fashion-week-ss14-sneakers/style20/12207525-1-chi-HK/Style20.jpg');
// images2
$images[] = array('im_name'=>'897412112','im_url'=>'http://www.elle.com.hk/var/ellehk/storage/images/fashion/street_snap/fashion-week-ss14-sneakers/style20/12207525-1-chi-HK/Style20.jpg');
// $response = $service->update($images);
// output the response
// $service->print_json($response );

echo "\n############################################\n";
echo "# insert status testing\n";
echo "############################################\n";

// $response = $service->insert_status("292828618479063040");
// // output the response
// $service->print_json($response );

echo "\n############################################\n";
echo "# remove image testing\n";
echo "############################################\n";

// $response = $service->remove(array("897410","897411"));
// output the response
// $service->print_json($response );
?>