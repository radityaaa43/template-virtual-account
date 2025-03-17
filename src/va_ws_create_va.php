<?php

require 'utils.php';

use BRI\Util\GenerateDate;
use BRI\Util\GenerateRandomString;
use BRI\Util\VarNumber;

header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Content-Security-Policy: default-src 'self'; script-src 'self';");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Referrer-Policy: no-referrer");
header("Permissions-Policy: geolocation=(), microphone=()");

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
  $customerNo = (new VarNumber())->generateVar(10); // customer no
  $virtualAccountName = ''; // virtual account name
  $total = ''; // total
  $expiredDate = (new GenerateDate())->generate('+1 days');
  $trxId = (new GenerateRandomString())->generate();
  $description = '';

  $validateInputs = sanitizeInput([
    'partnerId' => $partnerId,
    'channelId' => $channelId,
    'partnerServiceId' => $partnerServiceId,
    'customerNo' => $customerNo,
    'virtualAccountName' => $virtualAccountName,
    'total' => $total,
    'expiredDate' => $expiredDate,
    'trxId' => $trxId,
    'description' => $description
  ]);

  file_put_contents('customerNo.txt', $customerNo, LOCK_EX);
  file_put_contents('expiredDate.txt', $expiredDate, LOCK_EX);
  file_put_contents('trxId.txt', $trxId, LOCK_EX);

  $response = fetchVAWSCreate(
    $clientSecret,
    $validateInputs['partnerId'],
    $baseUrl,
    $accessToken,
    $validateInputs['channelId'],
    $timestamp,
    $validateInputs['partnerServiceId'],
    $validateInputs['customerNo'],
    $validateInputs['virtualAccountName'],
    $validateInputs['total'],
    $validateInputs['expiredDate'],
    $validateInputs['trxId'],
    $validateInputs['description']
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
