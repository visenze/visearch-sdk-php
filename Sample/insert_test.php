
<?php

require_once '../ViSearch/insert.php';

$access_key = '******';
$secret_key = '******';

$service = new InsertService($access_key,$secret_key);

$images = array();
// images1
$images[] = array('im_name'=>'897412111','im_url'=>'http://www.elle.com.hk/var/ellehk/storage/images/fashion/street_snap/fashion-week-ss14-sneakers/style20/12207525-1-chi-HK/Style20.jpg');
// images2
$images[] = array('im_name'=>'897412112','im_url'=>'http://www.elle.com.hk/var/ellehk/storage/images/fashion/street_snap/fashion-week-ss14-sneakers/style20/12207525-1-chi-HK/Style20.jpg');
$response = $service->insert($images);
// output the response
$service->print_json($response );

// echo "\n############################################\n";
// echo "# insert status testing\n";
// echo "############################################\n";

// $response = $service->insert_status("292828618479063040");
// // output the response
// $service->print_json($response );
?>