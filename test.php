<?php
require_once "src/SearchEngine.php";

use SearchEngine\SearchEngine;

$rq = new SearchEngine();

$rq->setEngine('google.com');

$res = $rq->search(array('Flipcart'));

echo '<pre>';
print_r($res);
?>