<?php

namespace Brazebee\Events\Types;

use Brazebee\Core\Json\JsonSerializableType;
use Brazebee\Core\Json\JsonProperty;

/**
 * User information. Optional for system events.
 *
 * **Naming Options:**
 * - Provide `name` if you have the full name
 * - Provide `first_name` and `last_name` if you have separated names
 * - Or provide all three for maximum flexibility
 *
 * **Additional Fields:**
 * You can include any custom fields: role, plan, signup_date, last_login, etc.
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
     * @var ?string $name User full name (e.g., "John Doe")
     */
    #[JsonProperty('name')]
    public ?string $name;

    /**
     * @var ?string $firstName User first name (e.g., "John")
     */
    #[JsonProperty('first_name')]
    public ?string $firstName;

    /**
     * @var ?string $lastName User last name (e.g., "Doe")
     */
    #[JsonProperty('last_name')]
    public ?string $lastName;

    /**
     * @param array{
     *   id: string,
     *   email?: ?string,
     *   name?: ?string,
     *   firstName?: ?string,
     *   lastName?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->email = $values['email'] ?? null;
        $this->name = $values['name'] ?? null;
        $this->firstName = $values['firstName'] ?? null;
        $this->lastName = $values['lastName'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
