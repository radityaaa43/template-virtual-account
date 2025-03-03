# Template-informasi-rekening-php

This is a simple template for Virtual Account SNAP BI using PHP.

module:
- [Virtual Account - Briva Online](https://developers.bri.co.id/en/snap-bi/apidocs-virtual-account-briva-online-snap-bi)
- [Virtual Account - Briva WS](https://developers.bri.co.id/en/snap-bi/apidocs-virtual-account-briva-ws-snap-bi)

## List of Content
- [Instalasi](#instalasi)
  - [Prerequisites](#prerequisites)
  - [How to Setup Project](#how-to-setup-project)
  - [Briva Online Inquiry](#briva-online-inquiry)
  - [Briva Online Payment](#briva-online-payment)
  - [Briva WS Create VA](#briva-ws-create-va)
  - [Briva WS Update VA](#briva-ws-update-va)
  - [Briva WS Update Status VA](#briva-ws-update-status-va)
  - [Briva WS Inquiry VA](#briva-ws-inquiry-va)
  - [Briva WS Delete VA](#briva-ws-delete-va)
  - [Briva WS Get Report](#briva-ws-get-report)
  - [Briva WS Inquiry Status VA](#briva-ws-inquiry-status-va)
- [How to get CONSUMER_KEY and CONSUMER_SECRET](#how-to-get-consumer_key-and-consumer_secret)
- [How to get Private Key](#how-to-get-private-key)
- [.ENV Example](#env-example)
- [Caution](#caution)
- [Disclaimer](#disclaimer)

## Instalasi

### Prerequisites
- php
- composer

### How to Setup Project

```bash
1. run command `cd template-virtual-account` to change directory
2. copy .env file by typing 'cp .env.example .env' in the terminal
3. fill the .env file with the required values
4. run composer install to install all dependencies
```

### Briva Online Inquiry
```bash
1. fill partnerId and channelId
2. fill partnerServiceId example '   55888'
3. fill customerNo by default this template give you utils that can generate customerNo
4. fill inquiryRequestId example 'e3bcb9a2-e253-40c6-aa77-d72cc138b744'
5. fill value example 100000.00
6. fill currency by default is IDR
7. fill trxDateInit by default this template give you utils that can generate it example 2021-11-25T15:01:07+07:00
8. fill sourceBankCode example 0002
9. fill passApp example 'b7aee423dc7489dfa868426e5c950c677925'
10. fill idApp example 'test'
11. run command `php src/va_online_inquiry.php serve`
```

### Briva Online Payment
```bash
1. fill partnerId and channelId
2. fill partnerServiceId example '   55888'
3. fill customerNo by default this template give you utils that can generate customerNo 
4. fill inquiryRequestId example 'e3bcb9a2-e253-40c6-aa77-d72cc138b744'
5. fill value example 100000.00
6. fill currency by default is IDR
7. fill trxDateInit by default this template give you utils that can generate it example 2021-11-25T15:01:07+07:00
8. fill sourceBankCode example 0002
9. fill passApp example 'b7aee423dc7489dfa868426e5c950c677925'
10. fill idApp example 'test'
11. run command `php src/va_online_payment.php serve`
```

### Briva WS Create VA
```bash
1. fill partnerId and channelId
2. fill partnerServiceId example '   55888'
3. fill customerNo by default this template give you utils that can generate customerNo 
4. fill virtualAccountName example John Doe
5. fill total example 10000.00
6. fill expiredDate by default this template give you utils that can generate example 2022-02-28T22:38:25+07:00
7. fill trxId is Transaction ID in Partner system example abcdefgh1234
8. fill description example 'terangkanlah'
9. run command `php src/va_ws_create_va.php serve`
```

### Briva WS Update VA
```bash
1. fill partnerId and channelId
2. fill partnerServiceId example '   55888'
3. fill customerNo by default this template give you utils that can generate customerNo example '9196308416'
4. fill virtualAccountName example John Doe
fill total example 10000.00
6. fill expiredDate by default this template give you utils that can generate example 2022-02-28T22:38:25+07:00
7. fill trxId is Transaction ID in Partner system example abcdefgh1234
8. fill description example 'terangkanlah'
9. run command `php src/va_ws_update_va.php serve`
```

### Briva WS Update Status VA
```bash
1. fill partnerId and channelId
2. fill partnerServiceId example '   55888'
3. fill customerNo by default this template give you utils that can generate customerNo example '4498466302'
4. fill virtualAccountName example John Doe
fill total example 10000.00
6. fill expiredDate by default this template give you utils that can generate example 2022-02-28T22:38:25+07:00
7. fill trxId is Transaction ID in Partner system example lvirQR
8. fill statusPaid with Y or N
9. run command `php src/va_ws_update_status_va.php serve`
```

### Briva WS Inquiry VA
```bash
1. fill partnerId and channelId
2. fill partnerServiceId example '   55888'
3. fill customerNo by default this template give you utils that can generate customerNo example '4498466302'
4. fill trxId is Transaction ID in Partner system example lvirQR
5. run command `php src/va_ws_inquiry_va.php serve`
```

### Briva WS Get Report
```bash
1. fill partnerId and channelId
2. fill partnerServiceId example '   55888'
3. fill startDate by default this template give you utils that can generate startDate example 2024-06-21
4. fill startTime example 00:00:00+07:00
5. fill endTime example 22:00:00+07:00
6. run command `php src/va_ws_get_report_va.php serve`
```

### Briva WS Delete VA
```bash
1. fill partnerId and channelId
2. fill partnerServiceId example '   55888'
3. fill customerNo by default this template give you utils that can generate customerNo example '4498466302'
4. fill total example 10000.00
5. fill trxId is Transaction ID in Partner system example lvirQR
6. run command `php src/va_ws_delete_va.php serve`
```

### Briva WS Inquiry Status VA
```bash
1. fill partnerId and channelId
2. fill partnerServiceId example '   12819'
3. fill customerNo by default this template give you utils that can generate customerNo example 801234567899
4. fill inquiryRequestId example '065ad3ca-2490-4432-8a29-0a9a7ce4904b'
6. run command `php src/va_ws_get_inquiry_status.php serve`
```

## How to get CONSUMER_KEY and CONSUMER_SECRET
1. Go to https://developers.bri.co.id/en then login
2. Click menu  My Apps
3. select app
4. copy Consumer Key and Consumer Secret

## How to get Private Key
1. Go to https://developers.bri.co.id/en then login
2. Click menu  My Apps
3. Click Manage Snap Key
4. Click Add Snap Key
5. Generate RSA key with https://cryptotools.net/rsagen (recomended)
6. Save your private key and fill your public key in Snap key then save

## .ENV Example
```bash
CONSUMER_KEY=pqYYBsSc6rHwCqp6o4R8ExmBRubEpqtY 

CONSUMER_SECRET=idbaNFh0mGSZ7xol 

PRIVATE_KEY="-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQCOkAAcgCOTpZPgmxQKovWho6G3GJmxet6kYqi1wj5jTFuB8lLe
QhppR8ppYIxdvM1mnn2MTJFpHQr1zXwshpsT5YiaFIRxN/VMUi5QPBpgO8BMCBKc
wTL6Kq1pSaeTbdRdtRYNZjidxNWyvWVVbbbVmzH6edelT03YrO/r0aUKYQIDAQAB
AoGAa5D5lIeW0GuplVpNl+z3Wzvk5Ar6xHBKF0ydsW7btf7CON1Ha44C8ZcKgdIo
dv3jGV/SqQ6I1P/l6iteWxZBYXIInrNERaA5l6afUcHES8LBWKwDr6kBpAVXaCaV
yjdzknKMbN2PBNURbL3+O4v3Al8bCp1/e9EwBd99jkSYcMECQQDaEq+Q2ybw7tKi
bW7OEe1p7kMkF73sBW4p8gHRM53WJEfDh1X9DDKsgQqpqm0RASo1kGXIM9D1i7Ip
lcxKZs+pAkEAp1tX+SjnruA1DE8U9OEe83x7U9AReepRS5G8mhv59J3zdruMLWex
jJCDvLgz07YuKIoykgnqBK34UMvBaKH3+QJBAMxQWYFkcpWljF92HCyiC0gGXY2B
WQW7CL3v6dfxfl3V3A7Ly7qsJQYOWMkhzdHyv3Mz+MicE5ka6y+fE6pZrRECQACO
gzpm8m5YfJSv5qfx38J7lYVv2b8IEoEn2PLCSRCRPfAVK6AzChonmOiVzEZWAs1L
uGNX+RlO4taR9vC8KTECQQCLe+kQ/k24bH8RC5cCmvxMaPnYN3mXIoPZYCchxjPv
UHUebON90WEIiQazoXugkCkyRVsXHnglLXUm7CpDjFXt 
-----END RSA PRIVATE KEY-----"
```

## Caution

Please delete the .env file before pushing to github or bitbucket

## Disclaimer

Please note that this project is just a template on the use of BRI-API php sdk and may have bugs or errors.
