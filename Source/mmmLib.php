<?php
	/*
		This library will take an array of numbers and return a 
		resultset of the mean, median, and mode of the numbers.

		Caleb J. Hess
	*/

	class MMMCalc{

	    private static function checkNumeric(array $list){
			if ($list === array_filter($list, 'is_numeric'))
			{
				return True;
			}else{
				throw new Exception("The array contained values we were not expecting!");
			}
		}

		//RETURNS THE MEAN OF AN ARRAY
		public function getMean(array $list){
			if(count($list)==0)
				return NULL;
			$isNumeric = self::checkNumeric($list);
			$total = 0;
			foreach ($list as $number) {
			   $total += $number;
			}
			//ROUND TO 3 DECIMAL PLACES
			return(round($total/count($list),3));
		}

		//RETURNS THE MEDIAN OF AN ARRAY
		public function getMedian(array $list){
			if(count($list)==0)
				return NULL;
			$isNumeric = self::checkNumeric($list);
			//LETS MAKE SURE THAT OUR LIST OF NUMBERS IS LONGER THAN 1
			if(count($list)>1){
			    sort($list, SORT_NUMERIC);
			    //GET OUR CENTER POINT
			    $centerPoint = count($list) / 2;
			    //ASSIGN THE MEDIAN
			    if (count($list) % 2 == 0){
			        $median = ($median + $list[$centerPoint - 1]) / 2;
			    }else{
			    	$median = $list[$centerPoint];
			    }
			    return $median;
			}else{
				return $list[0];
			}
		}

		//RETURNS THE MODE OF AN ARRAY
		public function getMode(array $list){
			if(count($list)==0)
				return NULL;
			$isNumeric = self::checkNumeric($list);
			//LETS MAKE SURE THAT OUR LIST OF NUMBERS IS LONGER THAN 1
			if(count($list)>1){	
				//CAST THE NUMBERS TO A STRING REPRESENTATION SO WE CAN USE ARRAY_COUNT_VALUES IN CASE OF DOUBLES OR FLOATS
				$values = array_map('strval', $list);
				//COUNT NUMBER OF OCCURRENCES
				$values = array_count_values($values); 

				//HOLDER VARIABLES
				$currentMode;
				$currentCount;

				//CHECK TO SEE IF WE HAVE A CURRENT MODE AND COMPARE
				foreach ($values as $number => $count) { 
					if($count>1){
						if(!isset($currentCount) || $count > $currentCount){
							$currentMode = $number;
							$currentCount = $count;
						}elseif($count == $currentCount){
							$currentMode = $currentMode . ', ' . $number;
						}
					} 
				}
				//IF OUR CURRENT HOLDER IS STILL EMPTY RETURN NULL
				if(!isset($currentMode)){
					$currentMode = NULL;
				}
				return($currentMode);
			//OTHERWISE WE JUST RETURN WHAT WAS GIVEN
			}else{
				return($list[0]);
			}
		}
	}
?>