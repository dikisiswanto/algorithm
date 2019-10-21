<?php 
	class Utility  
	{
		
		public static function extract_data_csv($filename) {
			$file = fopen($filename, "r");
			while(($data = fgetcsv($file)) !== false){
				$output[] = $data;
			}
			fclose($file);
			return $output;
		}
	}
	