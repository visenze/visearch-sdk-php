
<?php

require_once '../ViSearch/ViSearch.php';

$access_key = '******';
$secret_key = '******';

$service = new ViSearch($access_key,$secret_key);

echo "\n############################################\n";
echo "# idsearch testing\n";
echo "############################################\n";

$response = $service->idsearch("theoutnet.com-354490",true, NULL, array("price","brand"));
// output the response
$service->print_json($response );



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
echo "# insert image testing\n";
echo "############################################\n";

$images = array();
// images1
$images[] = array('im_name'=>'897412111','im_url'=>'http://www.elle.com.hk/var/ellehk/storage/images/fashion/street_snap/fashion-week-ss14-sneakers/style20/12207525-1-chi-HK/Style20.jpg');
// images2
$images[] = array('im_name'=>'897412112','im_url'=>'http://www.elle.com.hk/var/ellehk/storage/images/fashion/street_snap/fashion-week-ss14-sneakers/style20/12207525-1-chi-HK/Style20.jpg');
$response = $service->insert($images);
// output the response
$service->print_json($response );

echo "\n############################################\n";
echo "# update image testing\n";
echo "############################################\n";

$images = array();
// images1
$images[] = array('im_name'=>'897412111','im_url'=>'http://www.elle.com.hk/var/ellehk/storage/images/fashion/street_snap/fashion-week-ss14-sneakers/style20/12207525-1-chi-HK/Style20.jpg');
// images2
$images[] = array('im_name'=>'897412112','im_url'=>'http://www.elle.com.hk/var/ellehk/storage/images/fashion/street_snap/fashion-week-ss14-sneakers/style20/12207525-1-chi-HK/Style20.jpg');
$response = $service->update($images);
// output the response
$service->print_json($response );

echo "\n############################################\n";
echo "# insert status testing\n";
echo "############################################\n";

// $response = $service->insert_status("292828618479063040");
// // output the response
// $service->print_json($response );

echo "\n############################################\n";
echo "# remove image testing\n";
echo "############################################\n";

$response = $service->remove(array("897410","897411"));
// output the response
$service->print_json($response );
?>