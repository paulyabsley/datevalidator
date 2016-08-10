<?php
require_once('datevalidator.class.php');

$dateString = "03/12/1999";
$result = DateValidator::validateHistoricalDate($dateString);
if (!$result->isValid()) {
    $message = $result->getMessage();
}
var_dump($message);