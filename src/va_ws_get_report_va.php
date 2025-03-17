<?php

use BRI\Util\GenerateDate;

require 'utils.php';

header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Content-Security-Policy: default-src 'self'; script-src 'self';");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Referrer-Policy: no-referrer");

// url path values
$baseUrl = 'https://sandbox.partner.api.bri.co.id'; //base url

try {
  list($clientId, $clientSecret, $privateKey) = getCredentials();

  list($accessToken, $timestamp) = getAccessToken(
    $clientId,
    $privateKey,
    $baseUrl
  );

  // change variables accordingly
  $partnerId = ''; //partner id
  $channelId = ''; // channel id

  $partnerServiceId = ''; // partner service id
  $startDate = ''; //(new GenerateDate())->generate(null, 'Y-m-d');
  $startTime = ''; // format H:i:sP
  $endTime = ''; // format H:i:sP

  // Validate startDate
  $startDateObj = DateTime::createFromFormat('Y-m-d', $startDate);
  if (!$startDateObj || $startDateObj->format('Y-m-d') !== $startDate) {
      throw new Exception("Invalid startDate format. Expected format: Y-m-d");
  }

  // Validate startTime
  $startTimeObj = DateTime::createFromFormat('H:i:sP', $startTime);
  if (!$startTimeObj || $startTimeObj->format('H:i:sP') !== $startTime) {
      throw new Exception("Invalid startTime format. Expected format: H:i:sP");
  }

  // Validate endTime
  $endTimeObj = DateTime::createFromFormat('H:i:sP', $endTime);
  if (!$endTimeObj || $endTimeObj->format('H:i:sP') !== $endTime) {
      throw new Exception("Invalid endTime format. Expected format: H:i:sP");
  }

  $validateInputs = sanitizeInput([
    'partnerId' => $partnerId,
    'channelId' => $channelId,
    'partnerServiceId' => $partnerServiceId,
    'startDate' => $startDate,
    'startTime' => $startTime,
    'endTime' => $endTime
  ]);

  $response = fetchVAWSGetReportVa(
    $clientSecret, 
    $validateInputs['partnerId'], 
    $baseUrl,
    $accessToken,
    $validateInputs['channelId'],
    $timestamp,
    $validateInputs['partnerServiceId'],
    $validateInputs['startDate'],
    $validateInputs['startTime'],
    $validateInputs['endTime']
  );

  echo $response;
} catch (InvalidArgumentException $e) {
  error_log("Invalid argument: " . $e->getMessage());
} catch (RuntimeException $e) {
  error_log("Runtime exception: " . $e->getMessage());
} catch (Exception $e) {
  error_log("Unexpected error: " . $e->getMessage());
  exit(1);
}
