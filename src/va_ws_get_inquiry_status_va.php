<?php

use BRI\Util\GenerateRandomString;
use BRI\Util\VarNumber;

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

  $partnerServiceId = 'akllsklas'; // partner service id
  $customerNo = (new VarNumber())->generateVar(10); // customer no
  $inquiryRequestId = (new GenerateRandomString())->generate(5);

  $validateInputs = sanitizeInput([
    'partnerId' => $partnerId,
    'channelId' => $channelId,
    'partnerServiceId' => $partnerServiceId,
    'customerNo' => (string) $customerNo,
    'inquiryRequestId' => $inquiryRequestId
  ]);

  $response = fetchVAWSGetInquiryStatusVa(
    $clientSecret, 
    $validateInputs['partnerId'], 
    $baseUrl,
    $accessToken, 
    $validateInputs['channelId'],
    $timestamp,
    $validateInputs['partnerServiceId'],
    (int) $validateInputs['customerNo'],
    $validateInputs['inquiryRequestId']
  );

  echo htmlspecialchars($response, ENT_QUOTES, 'UTF-8');
} catch (InvalidArgumentException $e) {
  error_log("Invalid argument: " . $e->getMessage());
} catch (RuntimeException $e) {
  error_log("Runtime exception: " . $e->getMessage());
} catch (Exception $e) {
  error_log("Unexpected error: " . $e->getMessage());
  exit(1);
}
