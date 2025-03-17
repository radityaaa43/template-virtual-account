<?php

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

  // Validate required files
  $requiredFiles = ['customerNo.txt', 'expiredDate.txt', 'trxId.txt'];
  foreach ($requiredFiles as $file) {
    if (!file_exists($file)) {
      throw new Exception("Required file $file is missing.");
    }
  }

  // change variables accordingly
  $partnerId = ''; //partner id
  $channelId = ''; // channel id

  $partnerServiceId = ''; // partner service id
  $customerNo = trim(file_get_contents('customerNo.txt')); //(new VarNumber())->generateVar(10); // customer no
  $virtualAccountName = ''; // virtual account name
  $total = 0; // total
  $expiredDate = trim(file_get_contents('expiredDate.txt')); //(new GenerateDate())->generate('+1 days');
  $trxId = trim(file_get_contents('trxId.txt')); //(new GenerateRandomString())->generate();
  $description = '';

  // Validate inputs
  if (!is_numeric((int) $customerNo) || strlen((int) $customerNo) !== 10) {
    throw new Exception('Invalid customer number');
  }

  $validateInputs = sanitizeInput([
    'partnerId' => $partnerId,
    'channelId' => $channelId,
    'partnerServiceId' => $partnerServiceId,
    'customerNo' => (string) $customerNo,
    'virtualAccountName' => $virtualAccountName,
    'total' => (string) $total,
    'expiredDate' => $expiredDate,
    'trxId' => $trxId,
    'description' => $description
  ]);

  $response = fetchVAWSUpdateVa(
    $clientSecret, 
    $validateInputs['partnerId'],
    $baseUrl,
    $accessToken, 
    $validateInputs['channelId'],
    $timestamp,
    $validateInputs['partnerServiceId'],
    (int) $validateInputs['customerNo'],
    $validateInputs['virtualAccountName'],
    $validateInputs['total'],
    $validateInputs['expiredDate'],
    $validateInputs['trxId'],
    $validateInputs['description'] // optional
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
