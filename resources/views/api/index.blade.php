<?php
header('Content-Type: application/json ;charset=utf-8');

$arr = array('ClientAccessKey' => 'caa9c811f58e25c93e90906e5bd553c8eb9cd11b', 'ClientSecretKey' => '527ef84f78b418c64589894df6420422333664ee');
echo json_encode($arr);

