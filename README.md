# Brazebee PHP SDK

Official PHP SDK for tracking customer journey events with Brazebee.

## Installation

```bash
composer require brazebee/sdk
```

## Requirements

- PHP 8.1 or higher
- Guzzle HTTP client

## Quick Start

```php
<?php

require_once 'vendor/autoload.php';

use Brazebee\BrazebeeClient;

// Initialize the client
$client = new BrazebeeClient([
    'apiKey' => 'your_api_key_here',
    'environment' => 'https://your-app.com' // Your Brazebee API URL
]);

// Track an event
$client->events->track([
    'company' => [
        'id' => 'acme_corp',
        'name' => 'Acme Corporation',
        'stripe_customer_id' => 'cus_abc123'
    ],
    'user' => [
        'id' => 'user_123',
        'email' => 'john@acme.com',
        'name' => 'John Doe'
    ],
    'event_key' => 'feature_used',
    'data' => [
        'feature' => 'export',
        'format' => 'csv'
    ]
]);
```

## Usage

### Track User Events

Track events with user context:

```php
$client->events->track([
    'company' => [
        'id' => 'acme_corp',
        'name' => 'Acme Corporation'
    ],
    'user' => [
        'id' => 'user_123',
        'email' => 'john@acme.com',
        'name' => 'John Doe'
    ],
    'event_key' => 'onboarding_completed',
    'data' => [
        'steps_completed' => 5,
        'time_taken_seconds' => 180
    ]
]);
```

### Track System Events

Track company-level events without a specific user:

```php
$client->events->track([
    'company' => [
        'id' => 'acme_corp',
        'name' => 'Acme Corporation'
    ],
    'event_key' => 'plan_upgraded',
    'data' => [
        'from_plan' => 'starter',
        'to_plan' => 'professional',
        'mrr_change' => 50
    ]
]);
```

### Custom Fields

Both `company` and `user` objects support custom fields:

```php
$client->events->track([
    'company' => [
        'id' => 'acme_corp',
        'name' => 'Acme Corporation',
        // Custom fields
        'industry' => 'technology',
        'size' => 'enterprise',
        'plan' => 'professional',
        'mrr' => 500
    ],
    'user' => [
        'id' => 'user_123',
        'email' => 'john@acme.com',
        'name' => 'John Doe',
        // Custom fields
        'role' => 'admin',
        'signup_date' => '2024-01-15'
    ],
    'event_key' => 'feature_used'
]);
```

## Configuration

```php
$client = new BrazebeeClient([
    'apiKey' => 'your_api_key_here',      // Required: Your Brazebee API key
    'environment' => 'https://your-app.com', // Required: Your API base URL
    'timeout' => 60                        // Optional: Request timeout in seconds (default: 60)
]);
```

## Error Handling

```php
use Brazebee\Exceptions\BrazebeeApiException;

try {
    $client->events->track([
        'company' => ['id' => 'acme_corp', 'name' => 'Acme'],
        'event_key' => 'feature_used'
    ]);
} catch (BrazebeeApiException $e) {
    echo "API Error: " . $e->getMessage();
    echo "Status Code: " . $e->getStatusCode();
    echo "Response: " . $e->getBody();
}
```

## API Reference

For detailed API documentation, visit: https://brazebee.com/docs

## Support

- **Documentation**: https://brazebee.com/docs
- **Email**: dev@brazebee.com
- **GitHub**: https://github.com/brazebee/brazebee-sdk-php

## License

Apache-2.0

