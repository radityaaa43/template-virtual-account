<?php

require 'utils.php';

header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("Content-Security-Policy: default-src 'self'; script-src 'self';");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("Referrer-Policy: no-referrer");

// url path values
$baseUrl = 'https://api.bridex.qore.page/mock'; //base url

try {
  list($clientId, $clientSecret, $privateKey) = getCredentials();

  $accessToken = getMockAccessToken(
    $clientId,
    $baseUrl,
    $privateKey
  );

  $partnerId = '';
  $passApp = '';

  $validateInputs = sanitizeInput([
    'partnerId' => $partnerId,
    'passApp' => $passApp
  ]);

  $response = fetchVAOnlineInquiry(
    $validateInputs['partnerId'],
    $clientId,
    $clientSecret,
    $baseUrl,
    $accessToken,
    $validateInputs['passApp']
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
