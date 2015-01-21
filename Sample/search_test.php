
<?php

require_once '../ViSearch/search.php';

$access_key = '******';
$secret_key = '******';

$service = new SearchService($access_key,$secret_key);

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

?>