# Netflex API Client

## Setup
`composer require netflex/api`

## Usage

```php
use Netflex\API;

API::setCredentials($publicKey, $privateKey);
$client = API::getClient();
```
