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
use Brazebee\Events\Types\TrackEventRequest;
use Brazebee\Events\Types\CompanyInfo;
use Brazebee\Events\Types\UserInfo;

// Initialize the client
$client = new BrazebeeClient(
    'your_api_key_here',
    ['baseUrl' => 'https://your-app.com']
);

// Track an event
$request = new TrackEventRequest([
    'company' => new CompanyInfo([
        'id' => 'acme_corp',
        'name' => 'Acme Corporation',
        'paymentProvider' => 'stripe',
        'paymentProviderId' => 'cus_abc123',
        'crmProvider' => 'salesforce',
        'crmProviderId' => 'acct_456'
    ]),
    'user' => new UserInfo([
        'id' => 'user_123',
        'email' => 'john@acme.com',
        'name' => 'John Doe'
    ]),
    'eventKey' => 'feature_used',
    'data' => [
        'feature' => 'export',
        'format' => 'csv'
    ]
]);

$client->events->track($request);
```

## Usage

### Track User Events

Track events with user context:

```php
use Brazebee\Events\Types\{TrackEventRequest, CompanyInfo, UserInfo};

$request = new TrackEventRequest([
    'company' => new CompanyInfo([
        'id' => 'acme_corp',
        'name' => 'Acme Corporation'
    ]),
    'user' => new UserInfo([
        'id' => 'user_123',
        'email' => 'john@acme.com',
        'name' => 'John Doe'
    ]),
    'eventKey' => 'onboarding_completed',
    'data' => [
        'steps_completed' => 5,
        'time_taken_seconds' => 180
    ]
]);

$client->events->track($request);
```

### Track Company-Level Events (Without User)

Track company-level events without a specific user (system events):

```php
use Brazebee\Events\Types\{TrackEventRequest, CompanyInfo};

$request = new TrackEventRequest([
    'company' => new CompanyInfo([
        'id' => 'acme_corp',
        'name' => 'Acme Corporation'
    ]),
    // No user parameter - this is a company/system event
    'eventKey' => 'plan_upgraded',
    'data' => [
        'from_plan' => 'starter',
        'to_plan' => 'professional',
        'mrr_change' => 50
    ]
]);

$client->events->track($request);
```

### Custom Data Fields

Add custom fields to the `data` parameter:

```php
use Brazebee\Events\Types\{TrackEventRequest, CompanyInfo, UserInfo};

$request = new TrackEventRequest([
    'company' => new CompanyInfo([
        'id' => 'acme_corp',
        'name' => 'Acme Corporation'
    ]),
    'user' => new UserInfo([
        'id' => 'user_123',
        'email' => 'john@acme.com',
        'name' => 'John Doe'
    ]),
    'eventKey' => 'feature_used',
    'data' => [
        // Standard fields
        'feature' => 'export',
        'format' => 'csv',
        
        // Custom fields (any data you want to track)
        'company_plan' => 'enterprise',
        'user_role' => 'admin',
        'records_exported' => 1500,
        'processing_time_ms' => 250
    ]
]);

$client->events->track($request);
```

## Multi-Tenant Usage

Track events for multiple companies with a single API key:

```php
use Brazebee\BrazebeeClient;
use Brazebee\Events\Types\{TrackEventRequest, CompanyInfo, UserInfo};

// Your organization uses one API key for all client companies
$client = new BrazebeeClient(
    'your_api_key_here',
    ['baseUrl' => 'https://your-app.com']
);

// Track event for Company A
$request = new TrackEventRequest([
    'company' => new CompanyInfo([
        'id' => 'company_a',
        'name' => 'Company A Inc'
    ]),
    'user' => new UserInfo(['id' => 'user_from_company_a']),
    'eventKey' => 'feature_used',
    'data' => ['feature' => 'export']
]);
$client->events->track($request);

// Track event for Company B
$request = new TrackEventRequest([
    'company' => new CompanyInfo([
        'id' => 'company_b',
        'name' => 'Company B Corp'
    ]),
    'user' => new UserInfo(['id' => 'user_from_company_b']),
    'eventKey' => 'feature_used',
    'data' => ['feature' => 'import']
]);
$client->events->track($request);
```

## Configuration

```php
$client = new BrazebeeClient(
    'your_api_key_here',                      // Required: Your Brazebee API key (string)
    [
        'baseUrl' => 'https://your-app.com',  // Required: Your API base URL
        'timeout' => 60                       // Optional: Request timeout in seconds (default: 60)
    ]
);
```

## Error Handling

```php
use Brazebee\BrazebeeClient;
use Brazebee\Events\Types\{TrackEventRequest, CompanyInfo};
use Brazebee\Exceptions\BrazebeeApiException;

$client = new BrazebeeClient(
    'your_api_key_here',
    ['baseUrl' => 'https://your-app.com']
);

try {
    $request = new TrackEventRequest([
        'company' => new CompanyInfo([
            'id' => 'acme_corp',
            'name' => 'Acme Corporation'
        ]),
        'eventKey' => 'feature_used'
    ]);
    
    $client->events->track($request);
    
} catch (BrazebeeApiException $e) {
    echo "API Error: " . $e->getMessage() . "\n";
    echo "Status Code: " . $e->getCode() . "\n";        // Use getCode(), not getStatusCode()
    echo "Response: " . json_encode($e->getBody()) . "\n";
}
```

## Type Reference

### Required Types

```php
use Brazebee\BrazebeeClient;
use Brazebee\Events\Types\TrackEventRequest;
use Brazebee\Events\Types\CompanyInfo;
use Brazebee\Events\Types\UserInfo;
use Brazebee\Exceptions\BrazebeeApiException;
```

### CompanyInfo

Required fields:
- `id` (string) - Unique identifier for the company
- `name` (string) - Company name

Optional fields:
- `paymentProvider` (string) - Payment provider (e.g., `stripe`, `paddle`, `chargebee`, `custom`)
- `paymentProviderId` (string) - Customer ID in the payment provider system
- `crmProvider` (string) - CRM platform name (e.g., `salesforce`, `hubspot`)
- `crmProviderId` (string) - Account/Company ID in the CRM

### UserInfo

Required fields:
- `id` (string) - Unique identifier for the user

Optional fields:
- `email` (string) - User email address
- `name` (string) - User full name

### TrackEventRequest

Required fields:
- `company` (CompanyInfo) - Company information
- `eventKey` (string) - Event key to track

Optional fields:
- `user` (UserInfo) - User information (optional for company/system events)
- `data` (array) - Custom event data
- `timestamp` (DateTime) - Event timestamp (defaults to current time)

## API Reference

For detailed API documentation, visit: https://brazebee.com/docs

## Support

- **Documentation**: https://brazebee.com/docs
- **Email**: dev@brazebee.com
- **GitHub**: https://github.com/brazebee/brazebee-sdk-php

## License

Apache-2.0

