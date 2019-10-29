<?php 
 class KnnAlgorithm  
 {
	 public static function classify($data_training, $data_testing, $k)
	 {
		 $distance = array();
		 foreach ($data_training as $item) {
			 $euclidean_distance = sqrt(pow(($item[0] - $data_testing[0]), 2) + pow(($item[1] - $data_testing[1]), 2));
			 array_push($distance, array('ed' => $euclidean_distance, 'class' => $item[2]));
		 }
		 array_multisort(array_column($distance, 'ed'), SORT_ASC, $distance);
		 $distance = array_slice($distance, 0, $k);
		 $class1 = 0;
		 $class0 = 0;
		 foreach ($distance as $item) {
			 if ($item['class'] == 1) {
				 $class1++;
			 } else {
				 $class0++;
			 }
		 }
		 return ($class0 > $class1 ? 0 : 1);
	 }
	 
 }

//  DATA TRAINING
 DEFINE("DATA_TRAINING", array(
	 array(25, 40000, 0),
	 array(35, 60000, 0),
	 array(45, 80000, 0),
	 array(20, 20000, 0),
	 array(35, 120000, 0),
	 array(52, 18000, 0),
	 array(23, 95000, 1),
	 array(40, 62000, 1),
	 array(60, 100000, 1),
	 array(48, 220000, 1),
	 array(33, 150000, 1)
 ));
//  data testing
 $data_testing = array(48, 142000);
//  jumlah k terdekat yang dikehendaki
 $k = 3;
 print("Berdasarkan algoritma KNN, data training yang diinput masuk ke kelas ");
 print(KnnAlgorithm::classify(DATA_TRAINING, $data_testing, $k));
 
?>