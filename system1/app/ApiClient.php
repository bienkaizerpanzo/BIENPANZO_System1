<?php

class ApiClient
{
    public static function fetchPetTypes(): array
    {
        $url = 'http://system2-nginx/api/pet-types';

        $context = stream_context_create([
            'http' => [
                'timeout' => 5,
                'ignore_errors' => true,
            ],
        ]);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            return [];
        }

        $decoded = json_decode($response, true);

        if (!is_array($decoded)) {
            return [];
        }

        return $decoded;
    }

    public static function getPetTypeNameById(array $petTypes, int $petTypeId): string
    {
        foreach ($petTypes as $petType) {
            if ((int) ($petType['id'] ?? 0) === $petTypeId) {
                return (string) ($petType['name'] ?? '');
            }
        }

        return '';
    }
}
