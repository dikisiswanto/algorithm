<?php 
/**
 * age (0 : <= 30, 1 : > 30 && <= 40, 2: > 40)
 * income (0: low, 1: medium, 2: height)
 * student (0: no, 1: yes)
 * credit_rating (0: fair, 1: excellent)
 * buy_computer (0: no, 1; yes)
 */
const AGE = array("<=30", "31...40", ">40");
const INCOME = array("low", "medium", "high");
const STUDENT = array("no", "yes");
const CREDIT_RATING = array("fair", "excellent");
const BUY_COMPUTER = array("no", "yes");

require_once "Utility.php";
require_once "NaiveBayesAlgorithm.php";

// ekstraksi file csv
$data_training = Utility::extract_data_csv('./dataset/data_training.csv');
// ambil baris 1 sebanyak 4 kolom pertama sebagai variabel
$var = array_slice(array_slice($data_training, 0, 1)[0], 0, 4);
// ambil baris 2 sampai baris terakhir sebagai data
$data_temp = array_slice($data_training, 1);
$data = array();

// lakukan transformasi data
foreach ($data_temp as $item ) {
	$data[] = array_replace($item, array(AGE[$item[0]], INCOME[$item[1]], STUDENT[$item[2]], CREDIT_RATING[$item[3]], BUY_COMPUTER[$item[4]]));
}

$data_testing = array("<=30", "medium", "yes", "fair");

$nb = new NaiveBayesAlgorithm($data, $var);
print_r($nb->calculate()->predict($data_testing, $var));