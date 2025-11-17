<?php

namespace Brazebee\Events\Types;

use Brazebee\Core\Json\JsonSerializableType;
use Brazebee\Core\Json\JsonProperty;
use Brazebee\Core\Types\ArrayType;

/**
 * Error response
 */
class ErrorResponse extends JsonSerializableType
{
    /**
     * @var string $error Human-readable error message
     */
    #[JsonProperty('error')]
    public string $error;

    /**
     * @var ?string $code Machine-readable error code
     */
    #[JsonProperty('code')]
    public ?string $code;

    /**
     * @var ?array<string, mixed> $details Additional error details
     */
    #[JsonProperty('details'), ArrayType(['string' => 'mixed'])]
    public ?array $details;

    /**
     * @param array{
     *   error: string,
     *   code?: ?string,
     *   details?: ?array<string, mixed>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->error = $values['error'];
        $this->code = $values['code'] ?? null;
        $this->details = $values['details'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
