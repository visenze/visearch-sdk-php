
<?php

require_once '../ViSearch/remove.php';

$access_key = '******';
$secret_key = '******';

$service = new RemoveService($access_key,$secret_key);

$response = $service->remove(array("897410","897411"));
// output the response
$service->print_json($response );

?>