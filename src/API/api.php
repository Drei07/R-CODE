<?php

include_once __DIR__.'/../../database/dbconfig2.php';

$pdoQuery = "SELECT * FROM google_recaptcha_api LIMIT 1";
$pdoResult = $pdoConnect->prepare($pdoQuery);
$pdoExec = $pdoResult->execute(array());
$google = $pdoResult->fetch(PDO::FETCH_ASSOC);


//google recaptcha v3 API
$SiteKEY =  $google['site_key'];
$SiteSECRETKEY =  $google['site_secret_key'];

//google maps API
$pdoQuery = "SELECT * FROM google_maps LIMIT 1";
$pdoResult2 = $pdoConnect->prepare($pdoQuery);
$pdoExec = $pdoResult2->execute(array());
$google_maps = $pdoResult2->fetch(PDO::FETCH_ASSOC);

$GoogleAPI = $google_maps['API_key'];


?>