<?php

namespace Brazebee\Events\Types;

use Brazebee\Core\Json\JsonSerializableType;
use Brazebee\Core\Json\JsonProperty;

/**
 * User information. Optional for system events. Additional custom fields are supported.
 * Common additional fields: role, signup_date, last_login
 */
class UserInfo extends JsonSerializableType
{
    /**
     * @var string $id Unique identifier for the user in your system
     */
    #[JsonProperty('id')]
    public string $id;

    /**
     * @var ?string $email User email address
     */
    #[JsonProperty('email')]
    public ?string $email;

    /**
     * @var ?string $name User full name
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @param array{
     *   id: string,
     *   email?: ?string,
     *   name?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->email = $values['email'] ?? null;
        $this->name = $values['name'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
