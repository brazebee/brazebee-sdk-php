<?php

namespace Brazebee;

use Brazebee\Events\EventsClient;
use GuzzleHttp\ClientInterface;
use Brazebee\Core\Client\RawClient;

class BrazebeeClient
{
    /**
     * @var EventsClient $events
     */
    public EventsClient $events;

    /**
     * @var array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options
     */
    private array $options;

    /**
     * @var RawClient $client
     */
    private RawClient $client;

    /**
     * @param string $apiKeyAuth The apiKeyAuth to use for authentication.
     * @param ?array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options
     */
    public function __construct(
        string $apiKeyAuth,
        ?array $options = null,
    ) {
        $defaultHeaders = [
            'x-api-key' => $apiKeyAuth,
            'X-Fern-Language' => 'PHP',
            'X-Fern-SDK-Name' => 'Brazebee',
        ];

        $this->options = $options ?? [];
        $this->options['headers'] = array_merge(
            $defaultHeaders,
            $this->options['headers'] ?? [],
        );

        $this->client = new RawClient(
            options: $this->options,
        );

        $this->events = new EventsClient($this->client, $this->options);
    }
}
