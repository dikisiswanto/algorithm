<?php 
	class NaiveBayesAlgorithm 
	{
		protected $data = array();
		protected $vars = array();
		protected $prob = array();

		public function __construct($data, $vars)
		{
			$this->data = $data;
			$this->vars = $vars;
		}

		protected function _get_class_values()
		{
			$target_values = array();
			foreach ($this->data as $item) {
				$target_values[] = $item[count($this->vars)];
			}
			return $target_values;
		}

		protected function _get_class_label()
		{
			return array_unique($this->_get_class_values());
		}

		public function calculate()
		{
			$count_of_class_label = array_count_values($this->_get_class_values());
			$class_prob = array();
			$amount_of_data = count($this->data);

			foreach ($count_of_class_label as $class => $amount_of_class_value) {
				$class_prob[$class]['prob'] = (double) $amount_of_class_value/$amount_of_data;
			}

			foreach ($this->vars as $var_label => $var_value) {
				foreach ($this->_get_class_label() as $class_label) {
					$case_temp = $this->_get_data_by_class_and_var($var_label, $class_label);
					$amount_of_case = array_count_values($case_temp);
					$lost = $this->_get_var_lost($var_label, array_keys($amount_of_case));

					// jika ada data vars yang hilang atau tidak ada
					// masukkan ke array amount_of_case dengan banyaknya data = 0
					if ($lost) {
						foreach ($lost as $item) {
							$amount_of_case[$item] = 0;
						}
					}

					foreach ($amount_of_case as $case => $amount) {
						if ($amount == 0)
							$prob = (double) 1 / (count($case_temp) + count($amount_of_case));
						else
							$prob = (double) $amount / count($case_temp);
						$class_prob[$class_label][$var_value][$case] = $prob;
					}
				}
			}
			$this->prob = $class_prob;
			return $this;
		}

		protected function _get_var_lost($var_label, $case)
		{
			
			$data = $this->_get_data_spesific($var_label);
			$lost = array_diff($data, $case);
			if ($lost)
				return array_values($lost);
		}

		protected function _get_data_spesific($var_label)
		{
			$data = array();
			foreach ($this->data as $item) {
				$data[] = $item[$var_label];
			}
			return array_unique($data);
		}

		protected function _get_data_by_class_and_var($var_label, $class_label)
		{
			$output = array();

			foreach ($this->data as $item) {
				if ($item[count($this->vars)] == $class_label) {
					$output[] = $item[$var_label];
				}
			}

			return $output;
		}

		public function predict(array $data)
		{
			$prediction = array();
			foreach ($this->_get_class_label() as $class_label) {
				$prob = $this->prob[$class_label]['prob'];
				foreach ($data as $key => $value) {
					$prob = $prob * $this->prob[$class_label][$this->vars[$key]][$value];
				}
				$prediction[$class_label] = (double) $prob;
			}
			arsort($prediction);
			return array_keys($prediction)[0];
		}
	}
	
?>