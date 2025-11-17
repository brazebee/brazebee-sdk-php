<?php

namespace Brazebee\Events\Types;

use Brazebee\Core\Json\JsonSerializableType;
use Brazebee\Core\Json\JsonProperty;
use DateTime;
use Brazebee\Core\Types\Date;

/**
 * Response after successfully tracking an event
 */
class TrackEventResponse extends JsonSerializableType
{
    /**
     * @var bool $success Whether the event was successfully tracked
     */
    #[JsonProperty('success')]
    public bool $success;

    /**
     * @var string $eventKey The event key that was tracked
     */
    #[JsonProperty('event_key')]
    public string $eventKey;

    /**
     * @var DateTime $acceptedAt Timestamp when the event was accepted by Brazebee
     */
    #[JsonProperty('accepted_at'), Date(Date::TYPE_DATETIME)]
    public DateTime $acceptedAt;

    /**
     * @param array{
     *   success: bool,
     *   eventKey: string,
     *   acceptedAt: DateTime,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->success = $values['success'];
        $this->eventKey = $values['eventKey'];
        $this->acceptedAt = $values['acceptedAt'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
