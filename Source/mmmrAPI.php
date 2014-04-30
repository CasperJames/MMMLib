<?php

	//MAKE SURE WE HAVE NUMBERS AND NO STRINGS
	function checkNumeric(array $list){
		if ($list === array_filter($list, 'is_numeric'))
		{
			return True;
		}else{
			//SET RESPONSE CODE AND RETURN ERROR AS JSON
			http_response_code(500);
            return json_encode(buildErrorString(500, "Array appears to contain non numeric values"));
		}
	}

	//BUILDS AN ERROR STRING FOR JSON TO SEND BACK TO THE USER
	function buildErrorString($code, $errorMessage){
	    return array("error" => array("code" => $code, "message" => $errorMessage));
	}

	//RETURNS THE MEAN OF AN ARRAY
	function getMean(array $list){
		if(count($list)==0)
			return NULL;
		checkNumeric($list);
		$total = 0;
		foreach ($list as $number) {
		   $total += $number;
		}
		//ROUND TO 3 DECIMAL PLACES
		return(round($total/count($list),3));
	}

	//RETURNS THE MEDIAN OF AN ARRAY
	function getMedian(array $list){
		if(count($list)==0)
			return NULL;
		checkNumeric($list);
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
		    return round($median,3);
		}else{
			return round($list[0],3);
		}
	}

	//RETURNS THE MODE(S) OF AN ARRAY
	function getMode(array $list){
		if(count($list)==0)
			return NULL;
		checkNumeric($list);
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
			return(round($currentMode,3));
		//OTHERWISE WE JUST RETURN WHAT WAS GIVEN
		}else{
			return(round($list[0],3));
		}
	}

	//RANGE IS THE SPAN BETWEEN THE MAXIMUM AND MINIMUM NUMBERS IN THE SET
	function getRange ($list){
		if(count($list)==0)
			return NULL;
	    return round((max($array)-min($array)), 3);
	}

	//PROCESSES THE INCOMING JSON REQUEST
	function handleData($incomingData){

	    try{
	        $jsonObj = json_decode(($incomingData), false);
	        if(empty((array)$jsonObj)){
	        	//SET RESPONSE CODE AND RETURN ERROR AS JSON
	            http_response_code(500);
	            return json_encode(buildErrorString(500, "Array appears to be empty"));
	        }

	        if(!isset($jsonObj->numbers)){
	        	//SET RESPONSE CODE AND RETURN ERROR AS JSON
	            http_response_code(500);
	            return json_encode(buildErrorString(500, "Expected to find 'numbers': x, y, x but did not"));
	        }

	        //ASSEMBLE THE JSON OBJECT
	        $numbers = (array)$jsonObj;
	        $responseObject = array(
	        	"results" => array( 
	        		"mean" => getMean($numbers),
	            	"median" => getMedian($numbers),
	            	"mode" => getMode($numbers),
	            	"range" => getRange($numbers)
	            )
	        );

	        http_response_code(200);
	        return $responseObject;

	    //CATCH ANY EXCEPTIONS WHILE MANAGING THE DATA AND OBJECT
	    }catch(Exception $ex){
	    	//SET RESPONSE CODE AND RETURN ERROR AS JSON
	        http_response_code(500);
	        return json_encode(buildErrorString(500, "There was an error with the object"));
	    }

	}

	//CHECK THE METHOD COMING IN FROM JSON - IF POST THEN PROCEED OTHERWISE INFORM THE USER
	switch($_SERVER['REQUEST_METHOD'])
	{
	    case "POST":
	        $response = handleData($HTTP_RAW_POST_DATA);
	        break;
	    default:
	    	//SET RESPONSE CODE AND RETURN ERROR AS JSON
	        http_response_code(404);
	        $response = json_encode(buildErrorString(404,"Method " . $_SERVER['REQUEST_METHOD'] . " not available on this endpoint"));
	        break;
	}

	json_encode($response);
?>