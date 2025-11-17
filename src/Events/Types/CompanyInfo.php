<?php

namespace Brazebee\Events\Types;

use Brazebee\Core\Json\JsonSerializableType;
use Brazebee\Core\Json\JsonProperty;

/**
 * Company information. Additional custom fields are supported and will be stored.
 * Common additional fields: industry, size, plan, mrr, signup_date
 */
class CompanyInfo extends JsonSerializableType
{
    /**
     * @var string $id Unique identifier for the company in your system
     */
    #[JsonProperty('id')]
    public string $id;

    /**
     * @var string $name Company name
     */
    #[JsonProperty('name')]
    public string $name;

    /**
     * @var ?string $stripeCustomerId Stripe customer ID if applicable
     */
    #[JsonProperty('stripe_customer_id')]
    public ?string $stripeCustomerId;

    /**
     * @param array{
     *   id: string,
     *   name: string,
     *   stripeCustomerId?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->name = $values['name'];
        $this->stripeCustomerId = $values['stripeCustomerId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
