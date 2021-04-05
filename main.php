<?php

  function getDataWithCurl($url) {
		$curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache"
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
  	$responseObject = (object) [
    	'response' => $response,
      'error' => $err,
    ];
  	return $responseObject;
	}

  function getDataFromApi() {
    $response = getDataWithCurl('https://justbookr.com/api/v1/books');
    $response = json_decode($response->response, true);
  	$imageUrls = [];
  	foreach ($response['data'] as $book) {
      array_push($imageUrls, $book['image-url']);
    }
    return $imageUrls;
  }

	function validateImageUrl($imageUrl) {
    $response = getDataWithCurl($imageUrl);
    if ($response->response && !$response->error) {
      return true;
    }
    return false;
  }

	function setNewUrl() {

  }

$imageUrl = getDataFromApi();

// https://pictures.abebooks.com/isbn/9780273790037-usXXX.jpg
// https://justbookr.com/api/v1/books
$result = validateImageUrl('https://pictures.abebooks.com/isbn/9780273790037-us.jpg');
var_dump($result);
