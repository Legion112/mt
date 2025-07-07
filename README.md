### Setting up via docker
```bash
docker compose up -d
```
Need to install composer dependencies
```bash 
docker compose exec php-fpm composer install 
```


## Installation
Set following env variables in .env.local and .env.test.local 
```dotenv
SHIFT4_USER=sk_test_TOKEN
OPPWA_TOKEN=token
```


## Command usage 
```bash
bin/console app:create-charge -h
```
```
Usage:
  app:create-charge <provider> <card-number> <card-exp-month> <card-exp-year> <card-cvv> <amount> <currency>

Arguments:
  provider              Provider name: "Shift4" or "ACI"
  card-number           Card number example: 4242424242424242
  card-exp-month        Month of expiration from 1-12
  card-exp-year         Year of expiration example: 2026
  card-cvv              CVC/CVV example: 466
  amount                Amount: 10.00 or 1000 for 10 EUR
  currency              Currency
```
```bash
docker compose exec php-fpm bin/console app:create-charge -vvv Shift4 4242424242424242 11 2026 466 10.00 EUR
```
Example output:
```json
{
  "transactionId": "char_zv5BkYUFWIwGm7tJrdVLmKMz",
  "createdAt": "2025-07-06T09:59:15+00:00",
  "amount": {
    "amount": "10",
    "currency": "EUR"
  },
  "cardBin": "424242"
}
```
To make a request
```curl
curl -X POST --location "http://localhost:8000/charge/Shift4" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{
            "amount": {
                "amount": "1000",
                "currency": {
                  "code": "EUR"
                }
            },
            "card": {
              "number": "4242424242424242",
              "expiration": {
                "month": "01",
                "year": 2026
              },
              "cvv": "012"
            }
        }'
```


### Running test
Test make real request to external system and needs setting up keys 
```bash
touch .env.test.local
```
Add there keys 
```dotenv
SHIFT4_USER=
OPPWA_TOKEN=
```
Test execution
```bash
docker compose exec php-fpm vendor/bin/phpunit
```
### Static code analyzer 
```dotenv
docker compose exec php-fpm vendor/bin/psalm
```


### Clean up
```bash
docker compose down
```