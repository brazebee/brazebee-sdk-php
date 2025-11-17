<?php

namespace Brazebee\Events\Types;

use Brazebee\Core\Json\JsonSerializableType;
use Brazebee\Core\Json\JsonProperty;
use Brazebee\Core\Types\ArrayType;
use DateTime;
use Brazebee\Core\Types\Date;

/**
 * Request to track a customer journey event
 */
class TrackEventRequest extends JsonSerializableType
{
    /**
     * @var CompanyInfo $company Company information
     */
    #[JsonProperty('company')]
    public CompanyInfo $company;

    /**
     * @var ?UserInfo $user User information (optional for system events)
     */
    #[JsonProperty('user')]
    public ?UserInfo $user;

    /**
     * Event key matching a configured event setting. Common examples:
     * - onboarding_started, onboarding_completed
     * - home_viewed, dashboard_viewed
     * - feature_action_completed
     * - plan_upgraded, plan_downgraded
     *
     * @var string $eventKey
     */
    #[JsonProperty('event_key')]
    public string $eventKey;

    /**
     * @var ?array<string, mixed> $data Event-specific data and properties
     */
    #[JsonProperty('data'), ArrayType(['string' => 'mixed'])]
    public ?array $data;

    /**
     * @var ?DateTime $timestamp Event timestamp in ISO 8601 format. Defaults to current time if not provided.
     */
    #[JsonProperty('timestamp'), Date(Date::TYPE_DATETIME)]
    public ?DateTime $timestamp;

    /**
     * @param array{
     *   company: CompanyInfo,
     *   eventKey: string,
     *   user?: ?UserInfo,
     *   data?: ?array<string, mixed>,
     *   timestamp?: ?DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->company = $values['company'];
        $this->user = $values['user'] ?? null;
        $this->eventKey = $values['eventKey'];
        $this->data = $values['data'] ?? null;
        $this->timestamp = $values['timestamp'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
