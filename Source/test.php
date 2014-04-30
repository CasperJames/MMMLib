<?php
	include "mmmLib.php";

	$lib = new MMMCalc();
	$testData = array(0,4,2,4,1);
	$testMean = $lib->getMean($testData);
	$testMode = $lib->getMode($testData);
	$testMedian = $lib->getMedian($testData);

	echo("<br /><br />MEAN<br />");
	echo($testMean);

	echo("<br /><br />MODE<br />");
	echo($testMode);

	echo("<br /><br />MEDIAN<br />");
	echo($testMedian);
?>