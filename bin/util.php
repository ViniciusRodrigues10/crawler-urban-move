<?php

/**
 * Function to add data to the CSV file if it doesn't already exist.
 *
 * @param string $csvFileName CSV file name.
 * @param string $url Page URL.
 * @param string $auctionData1 First auction data.
 * @param string $auctionData2 Second auction data.
 */
function addDataToCSV($csvFileName, $url, $auctionData1, $auctionData2)
{
    if (!dataAlreadyExistsInCSV($csvFileName, $url, $auctionData1, $auctionData2)) {
        $csvFile = fopen($csvFileName, 'a');
        fputcsv($csvFile, [$url, $auctionData1, $auctionData2]);
        fclose($csvFile);
    }
}

/**
 * Function to check if the data already exists in the CSV file.
 *
 * @param string $csvFileName CSV file name.
 * @param string $url Page URL.
 * @param string $auctionData1 First auction data.
 * @param string $auctionData2 Second auction data.
 *
 * @return bool Returns true if the data already exists, false otherwise.
 */
function dataAlreadyExistsInCSV($csvFileName, $url, $auctionData1, $auctionData2)
{
    if (file_exists($csvFileName)) {
        $csvFile = fopen($csvFileName, 'r');
        while (($row = fgetcsv($csvFile)) !== false) {
            if ($row[0] == $url && $row[1] == $auctionData1 && $row[2] == $auctionData2) {
                fclose($csvFile);
                return true;
            }
        }
        fclose($csvFile);
    }
    return false;
}

/**
 * Function to extract data from a page.
 *
 * @param string $url Page URL.
 * @param string $csvFileName CSV file name.
 * @param string $logFileName Log file name.
 */
function extractDataFromPage($url, $csvFileName, $logFileName)
{
    if ($url == 'https://amleiloeiro.com.br/leilao/114/leilao-das-varas-criminais') {
        $logMessage = "Ignoring specific page: $url\n";
        echo $logMessage;
        file_put_contents($logFileName, $logMessage, FILE_APPEND);
        return;
    }

    $dom = getDOMDocument($url);
    $auctionElements = $dom->getElementsByTagName('span');
    $auctionData1 = $auctionData2 = '';

    foreach ($auctionElements as $auctionElement) {
        if ($auctionElement->getAttribute('class') == 'block') {
            $auctionText = trim($auctionElement->textContent);
            if (strpos($auctionText, '1º. LEILÃO') !== false) {
                $auctionData1 = $auctionText;
            } elseif (strpos($auctionText, '2º. LEILÃO') !== false) {
                $auctionData2 = $auctionText;
            }
        }
    }

    $logMessage = "Auction Data: $auctionData1\nAuction Data: $auctionData2\n";
    echo $logMessage;
    file_put_contents($logFileName, $logMessage, FILE_APPEND);

    addDataToCSV($csvFileName, $url, $auctionData1, $auctionData2);

    unset($dom);
}

/**
 * Function to process the links on the page.
 *
 * @param string $url Page URL.
 * @param string $csvFileName CSV file name.
 * @param string $logFileName Log file name.
 */
function processLinks($url, $csvFileName, $logFileName)
{
    $dom = getDOMDocument($url);
    $xpath = new DOMXPath($dom);
    $links = $xpath->query("//a[contains(@class, 'font-bold text-site-box-titulo dark:text-site-box-titulo-dark') and starts-with(@href, 'https://amleiloeiro.com.br/')]");

    foreach ($links as $link) {
        $href = $link->getAttribute('href');
        $logMessage = "Lot Link: $href\n";
        echo $logMessage;
        file_put_contents($logFileName, $logMessage, FILE_APPEND);

        extractDataFromPage($href, $csvFileName, $logFileName);

        $moreLinksOnPage = $xpath->query("//a[starts-with(@href, '$href')]");
        
        if ($moreLinksOnPage->length > 1) {
            processLinks($href, $csvFileName, $logFileName);
        } else {
            $logMessage = "No more similar links on the page. Processing data from the current page...\n";
            echo $logMessage;
            file_put_contents($logFileName, $logMessage, FILE_APPEND);
        }
    }

    unset($dom);
}

/**
 * Function to get the DOMDocument object from HTML content.
 *
 * @param string $url Page URL.
 *
 * @return DOMDocument Returns the DOMDocument object.
 */
function getDOMDocument($url)
{
    $html = getHTMLContent($url);
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_use_internal_errors(false);

    return $dom;
}

/**
 * Function to get the HTML content from a URL using cURL.
 *
 * @param string $url Page URL.
 *
 * @return string Returns the HTML content.
 */
function getHTMLContent($url)
{
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);

    $html = curl_exec($curl);

    if ($html === false) {
        $errorMessage = 'Error fetching HTML content from the page: ' . curl_error($curl) . "\n";
        echo $errorMessage;
        file_put_contents($logFileName, $errorMessage, FILE_APPEND);
        die($errorMessage);
    }

    curl_close($curl);

    return $html;
}

?>
