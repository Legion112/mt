## Installation
Set following env variables 
```dotenv
SHIFT4_USER=sk_test_TOKEN
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
bin/console app:create-charge -vvv Shift4 4242424242424242 11 2026 466 10.00 EUR
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
