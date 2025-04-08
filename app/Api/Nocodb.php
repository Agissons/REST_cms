<?php

namespace App\Api;

use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Throwable;

class Nocodb
{
    private $baseUrl = null;
    private $apikey = null;


    public function __construct()
    {
        $this->apikey = config('actionnetwork.apikey');
        $this->baseUrl = config('actionnetwork.baseUrl');
    }

    public function login($email, $password)
    {
        // TODO: login with Oauth
    }

    private function request(): PendingRequest
    {
        return Http::withHeader('xc-token', $this->apikey)
            ->acceptJson()
            ->baseUrl($this->baseUrl);
    }

    public function getEvents(int $limit = null): array
    {
        $response = $this->request()->get("/events", [
            'limit' => $limit,
            'start_date' => Carbon::now()->format('Y-m-d'),
        ]);
        if (is_null($response->json())) {
            return [];
        }
        $events = $response->json()['_embedded']['osdi:events'] ?? [];
        $events = array_filter($events, fn ($e) => (Carbon::now()->lt(Carbon::parse($e['end_date']))) && ($e['status'] == 'confirmed')  && ($e['visibility'] == "public"));
        usort($events, fn ($e1, $e2) => Carbon::parse($e1['start_date'])->lt(Carbon::parse($e2['start_date'])) ? -1 : 1);
        return $events;
    }


    public function getEvent(string $eventId): array|null
    {
        $response = $this->request()->get("/events/" . $eventId);
        return $response->json() ?? null;
    }

    public function getForms(): array
    {
        $response = $this->request()->get("/forms");

        if ($response->json() === null) {
            return [];
        }

        $forms = $response->json()['_embedded']['osdi:forms'] ?? [];

        return $forms;
    }

    public function getForm(string $formId): array|null
    {
        $formId = substr($formId, 15);
        $response = $this->request()->get("/forms/" . $formId);

        return $response->json() ?? null;
    }

    public function createSubmisson(string $petitionId, string $personRef): array
    {
        $submission = [
            "osdi:person" => [
                'href' => $personRef
            ]
        ];

        $petitionId = substr($petitionId, 15);
        $response = $this->request()->post("/forms/" . $petitionId . "/submissions/", ['_links' => $submission]);

        if ($response->json() === null) {
            return [];
        }

        return $response->json();
    }

    public function unsubscribe(string $email) //: bool
    {
        $people = [
            "email_addresses" => [['address' => $email, "status" => "unsubscribed"]]
        ];
        $response = $this->request()->post("/people", ['person' => $people]);
        try {
            return $response->json();
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function createPerson(array $people, array $tags = null): array|null
    {
        $response = $this->request()->post("/people", ['person' => $people, 'add_tags' => $tags]);
        try {
            return $response->json();
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function matchSubmisson(string $petitionId, string $personRef): bool
    {
        $petitionId = substr($petitionId, 15);

        $response = $this->request()->get($personRef . "/submissions");
        $data = $response !== null ? $response->json() : [];

        if (!is_null($data)) {
            foreach ($data['_embedded']['osdi:submissions'] as $submission) {
                if ($submission["action_network:form_id"] == $petitionId) {
                    return true;
                }
            }
        }

        return false;
    }

    public function matchPeople(string $email): array|null
    {
        $response = $this->request()->get("/people?filter=email_address eq '" . $email . "'");
        $data = $response !== null ? $response->json() : [];
        return $data['_embedded']['osdi:people'] ?? null;
    }
}
