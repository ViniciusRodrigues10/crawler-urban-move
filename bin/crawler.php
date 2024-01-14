<?php

require_once('util.php');

/**
 * URL of the page to be processed.
 * @var string
 */
$url = 'https://amleiloeiro.com.br/';

/**
 * Name of the CSV file to store auction data.
 * @var string
 */
$csvFileName = 'auction_data.csv'; 

/**
 * Name of the log file to record messages.
 * @var string
 */
$logFileName = 'log_auctions.txt';


/**
 * Process links on the specified page.
 *
 * @param string $url Page URL.
 * @param string $csvFileName CSV file name.
 * @param string $logFileName Log file name.
 */
processLinks($url, $csvFileName, $logFileName);

?>
