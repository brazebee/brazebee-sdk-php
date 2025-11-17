<?php

namespace Brazebee\Events;

use GuzzleHttp\ClientInterface;
use Brazebee\Core\Client\RawClient;
use Brazebee\Events\Types\TrackEventRequest;
use Brazebee\Events\Types\TrackEventResponse;
use Brazebee\Exceptions\BrazebeeException;
use Brazebee\Exceptions\BrazebeeApiException;
use Brazebee\Core\Json\JsonApiRequest;
use Brazebee\Core\Client\HttpMethod;
use JsonException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Client\ClientExceptionInterface;

class EventsClient
{
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
     * @param RawClient $client
     * @param ?array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options
     */
    public function __construct(
        RawClient $client,
        ?array $options = null,
    ) {
        $this->client = $client;
        $this->options = $options ?? [];
    }

    /**
     * Track a customer journey event. Events are automatically linked to companies and users,
     * creating them if they don't exist.
     *
     * **Common use cases:**
     * - Track onboarding progress (e.g., "Onboarding Started", "Setup Completed")
     * - Monitor feature adoption (e.g., "Dashboard Viewed", "Report Generated")
     * - Detect expansion signals (e.g., "User Limit Reached", "Plan Upgraded")
     * - Identify churn risks (e.g., "Cancel Viewed", "Cancel Started")
     *
     * @param TrackEventRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return TrackEventResponse
     * @throws BrazebeeException
     * @throws BrazebeeApiException
     */
    public function track(TrackEventRequest $request, ?array $options = null): TrackEventResponse
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? '',
                    path: "/api/v1/track",
                    method: HttpMethod::POST,
                    body: $request,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                return TrackEventResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new BrazebeeException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if ($response === null) {
                throw new BrazebeeException(message: $e->getMessage(), previous: $e);
            }
            throw new BrazebeeApiException(
                message: "API request failed",
                statusCode: $response->getStatusCode(),
                body: $response->getBody()->getContents(),
            );
        } catch (ClientExceptionInterface $e) {
            throw new BrazebeeException(message: $e->getMessage(), previous: $e);
        }
        throw new BrazebeeApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }
}
