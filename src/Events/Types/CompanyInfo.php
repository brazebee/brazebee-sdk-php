<?php

namespace Brazebee\Events\Types;

use Brazebee\Core\Json\JsonSerializableType;
use Brazebee\Core\Json\JsonProperty;

/**
 * Company information. The company will be created if it doesn't exist, or updated with new data.
 *
 * Payment Provider Fields:
 * - payment_provider and payment_provider_id are automatically stored in the company record
 * - No manual mapping needed - pass them in your events and they'll be available in the dashboard
 * - Supports: Stripe, Paddle, Chargebee, or custom values
 *
 * CRM Provider Fields:
 * - crm_provider and crm_provider_id are automatically stored in the company record
 * - Enables easy synchronization with your CRM without manual mapping
 * - Supports: Salesforce, HubSpot, Pipedrive, or custom values
 *
 * Additional Fields:
 * You can include any custom fields which will be stored in the company record:
 * industry, size, plan, mrr, signup_date, location, etc.
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
     * Payment provider used by this company (e.g., 'stripe', 'paddle', 'chargebee').
     * This field is automatically stored and can be used for segmentation and analytics.
     *
     * @var ?string $paymentProvider
     */
    #[JsonProperty('payment_provider')]
    public ?string $paymentProvider;

    /**
     * Customer ID in the payment provider system (e.g., Stripe customer ID 'cus_abc123').
     * This field is automatically stored and linked to the company for easy identification.
     *
     * @var ?string $paymentProviderId
     */
    #[JsonProperty('payment_provider_id')]
    public ?string $paymentProviderId;

    /**
     * CRM system used to manage this company (e.g., 'salesforce', 'hubspot', 'pipedrive').
     * This field is automatically stored and can be used for segmentation and analytics.
     *
     * @var ?string $crmProvider
     */
    #[JsonProperty('crm_provider')]
    public ?string $crmProvider;

    /**
     * Account/Company ID in the CRM system (e.g., Salesforce Account ID, HubSpot Company ID).
     * This field is automatically stored and linked to the company for easy CRM synchronization.
     *
     * @var ?string $crmProviderId
     */
    #[JsonProperty('crm_provider_id')]
    public ?string $crmProviderId;

    /**
     * @param array{
     *   id: string,
     *   name: string,
     *   paymentProvider?: ?string,
     *   paymentProviderId?: ?string,
     *   crmProvider?: ?string,
     *   crmProviderId?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->name = $values['name'];
        $this->paymentProvider = $values['paymentProvider'] ?? null;
        $this->paymentProviderId = $values['paymentProviderId'] ?? null;
        $this->crmProvider = $values['crmProvider'] ?? null;
        $this->crmProviderId = $values['crmProviderId'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
