<?php

use BRI\Util\ExecuteCurlRequest;
use BRI\Util\GetAccessToken;
use BRI\Util\PrepareRequest;
use BRI\VirtualAccount\BrivaOnline;
use BRI\VirtualAccount\BrivaWS;

require __DIR__ . '/../vendor/autoload.php';
Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/..' . '')->load();

require __DIR__ . '/../../briapi-sdk/autoload.php';

function getCredentials(): array {
  $clientId = $_ENV['CONSUMER_KEY'] ?? null;
  $clientSecret = $_ENV['CONSUMER_SECRET'] ?? null;
  $privateKey = $_ENV['PRIVATE_KEY'] ?? null;

  if (!$clientId || !$clientSecret) {
      throw new Exception('Missing client credentials in environment variables.');
  }

  return [$clientId, $clientSecret, $privateKey];
}

function getMockAccessToken(
  string $clientId,
  string $baseUrl,
  string $privateKey
): string {
  $getAccessToken = new GetAccessToken();

  $accessToken = $getAccessToken->getMockOutbound(
    $clientId,
    $baseUrl,
    $privateKey
  );

  if (!$accessToken) {
    throw new Exception('Failed to retrieve access token.');
  }

  return $accessToken;
}

function getAccessToken(
  string $clientId,
  string $privateKey,
  string $baseUrl
): array {
  $getAccessToken = new GetAccessToken();

  [$accessToken, $timestamp] = $getAccessToken->get(
    $clientId,
    $privateKey,
    $baseUrl
  );

  return [$accessToken, $timestamp];
}


// Get current timestamp in UTC
function getTimestamp(): string {
  $date = new DateTime("now", new DateTimeZone("UTC"));
  return $date->format('Y-m-d\TH:i:s') . '.' . substr($date->format('u'), 0, 3) . 'Z';
}

// Sanitize input parameters
function sanitizeInput(array $inputs): array {
  $sanitized = [];
  foreach ($inputs as $key => $value) {
      $sanitized[$key] = filter_var($value, FILTER_SANITIZE_STRING);
      if (empty($sanitized[$key])) {
          throw new Exception("Invalid input parameter for $key");
      }
  }
  return $sanitized;
}

function fetchVAOnlineInquiry(
  string $partnerId,
  string $clientId,
  string $clientSecret,
  string $baseUrl,
  string $accessToken,
  ?string $passApp
): string {
  $executeCurlRequest = new ExecuteCurlRequest();
  $prepareRequest = new PrepareRequest();

  $brivaOnline = new BrivaOnline(
    $executeCurlRequest,
    $prepareRequest
  );

  $response = $brivaOnline->inquiry(
    $partnerId,
    $clientId,
    $clientSecret,
    $baseUrl,
    $accessToken,
    $passApp
  );

  return $response;
}

function fetchVAOnlinePayment(
  string $partnerId,
  string $clientId,
  string $clientSecret,
  string $baseUrl,
  string $accessToken,
  ?string $passApp
): string {
  $executeCurlRequest = new ExecuteCurlRequest();
  $prepareRequest = new PrepareRequest();

  $brivaOnline = new BrivaOnline(
    $executeCurlRequest,
    $prepareRequest
  );

  $response = $brivaOnline->payment(
    $partnerId,
    $clientId,
    $clientSecret,
    $baseUrl,
    $accessToken,
    $passApp
  );

  return $response;
}

function fetchVAWSCreate(
  string $clientSecret,
  string $partnerId,
  string $baseUrl,
  string $accessToken,
  string $channelId,
  string $timestamp,
  string $partnerServiceId,
  string $customerNo,
  string $virtualAccountName,
  string $total,
  string $expiredDate,
  string $trxId,
  string $description
): string {
  $executeCurlRequest = new ExecuteCurlRequest();
  $prepareRequest = new PrepareRequest();

  $brivaWs = new BrivaWS(
    $executeCurlRequest,
    $prepareRequest
  );

  $response = $brivaWs->create(
    $clientSecret,
    $partnerId,
    $baseUrl,
    $accessToken,
    $channelId,
    $timestamp,
    $partnerServiceId,
    $customerNo,
    $virtualAccountName,
    $total,
    $expiredDate,
    $trxId,
    $description // optional
  );

  return $response;
}

function fetchVAWSDelete(
  string $clientSecret,
  string $partnerId,
  string $baseUrl,
  string $accessToken,
  string $channelId,
  string $timestamp,
  string $partnerServiceId,
  string $customerNo,
  string $trxId
): string {
  $executeCurlRequest = new ExecuteCurlRequest();
  $prepareRequest = new PrepareRequest();

  $brivaWs = new BrivaWS(
    $executeCurlRequest,
    $prepareRequest
  );

  $response = $brivaWs->delete(
    $clientSecret,
    $partnerId,
    $baseUrl,
    $accessToken,
    $channelId,
    $timestamp,
    $partnerServiceId,
    $customerNo,
    $trxId
  );

  return $response;
}

function fetchVAWSGetInquiryStatusVa(
  string $clientSecret, 
  string $partnerId, 
  string $baseUrl,
  string $accessToken, 
  string $channelId,
  string $timestamp,
  string $partnerServiceId,
  int $customerNo,
  string $inquiryRequestId,
): string {
  $executeCurlRequest = new ExecuteCurlRequest();
  $prepareRequest = new PrepareRequest();

  $brivaWs = new BrivaWS(
    $executeCurlRequest,
    $prepareRequest
  );

  /**
   * Briva WS - Inquiry Status VA
   */
  $response = $brivaWs->inquiryStatus(
    $clientSecret, 
    $partnerId, 
    $baseUrl,
    $accessToken, 
    $channelId,
    $timestamp,
    $partnerServiceId,
    $customerNo,
    $inquiryRequestId,
  );

  return $response;
}

function fetchVAWSGetReportVa(
  string $clientSecret, 
  string $partnerId, 
  string $baseUrl,
  string $accessToken,
  string $channelId,
  string $timestamp,
  string $partnerServiceId,
  string $startDate,
  string $startTime,
  string $endTime
): string {
  $executeCurlRequest = new ExecuteCurlRequest();
  $prepareRequest = new PrepareRequest();

  $brivaWs = new BrivaWS(
    $executeCurlRequest,
    $prepareRequest
  );

  /**
   * Briva WS - Get Report VA
   */
  $response = $brivaWs->getReport(
    $clientSecret, 
    $partnerId, 
    $baseUrl,
    $accessToken,
    $channelId,
    $timestamp,
    $partnerServiceId,
    $startDate,
    $startTime,
    $endTime
  );

  return $response;
}

function fetchVAWSInquiryVa(
  string $clientSecret,
  string $partnerId,
  string $baseUrl,
  string $accessToken,
  string $channelId,
  string $timestamp,
  string $partnerServiceId,
  string $customerNo,
  string $trxId
): string {
  $executeCurlRequest = new ExecuteCurlRequest();
  $prepareRequest = new PrepareRequest();

  $brivaWs = new BrivaWS(
    $executeCurlRequest,
    $prepareRequest
  );

  /**
   * Briva WS - Inquiry VA
   */
  $response = $brivaWs->inquiry(
    $clientSecret,
    $partnerId,
    $baseUrl,
    $accessToken,
    $channelId,
    $timestamp,
    $partnerServiceId,
    $customerNo,
    $trxId
  );

  return $response;
}

function fetchVAWSUpdateStatusVa(
  string $clientSecret,
  string $partnerId,
  string $baseUrl,
  string $accessToken,
  string $channelId,
  string $timestamp,
  string $partnerServiceId,
  int $customerNo,
  string $trxId,
  string $paidStatus
): string {
  $executeCurlRequest = new ExecuteCurlRequest();
  $prepareRequest = new PrepareRequest();

  $brivaWs = new BrivaWS(
    $executeCurlRequest,
    $prepareRequest
  );

  /**
   * Briva WS - Update Status VA
   */
  $response = $brivaWs->updateStatus(
    $clientSecret,
    $partnerId,
    $baseUrl,
    $accessToken,
    $channelId,
    $timestamp,
    $partnerServiceId,
    $customerNo,
    $trxId,
    $paidStatus
  );

  return $response;
}

function fetchVAWSUpdateVa(
  string $clientSecret,
  string $partnerId,
  string $baseUrl,
  string $accessToken,
  string $channelId,
  string $timestamp,
  string $partnerServiceId,
  int $customerNo,
  string $virtualAccountName,
  string $total,
  string $expiredDate,
  string $trxId,
  ?string $description
): string {
  $executeCurlRequest = new ExecuteCurlRequest();
  $prepareRequest = new PrepareRequest();

  $brivaWs = new BrivaWS(
    $executeCurlRequest,
    $prepareRequest
  );

  /**
   * Briva WS - Update VA
   */
  $response = $brivaWs->update(
    $clientSecret, 
    $partnerId, 
    $baseUrl,
    $accessToken, 
    $channelId,
    $timestamp,
    $partnerServiceId,
    $customerNo,
    $virtualAccountName,
    $total,
    $expiredDate,
    $trxId,
    $description // optional
  );

  return $response;
}
