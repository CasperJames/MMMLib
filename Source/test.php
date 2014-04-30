<?php
	include "mmmLib.php";

	$lib = new MMMCalc();
	$testData = array(0,4,2,3,1,5,9,6,6);
	try {
		$testMean = $lib->getMean($testData);
		$testMode = $lib->getMode($testData);
		$testMedian = $lib->getMedian($testData);
	} catch (Exception $e) {
		echo $e->getMessage();
	}

	echo("<br /><br />MEAN<br />");
	echo($testMean);

	echo("<br /><br />MODE<br />");
	echo($testMode);

	echo("<br /><br />MEDIAN<br />");
	echo($testMedian);
?>