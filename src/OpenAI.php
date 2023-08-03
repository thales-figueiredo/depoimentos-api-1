<?php

namespace Alura\Pdo;


use OpenAI\Client;
use OpenAI\Factory;

final class OpenAI
{
    private static ?Client $client = null;

    /**
     * Creates a new Open AI Client with the given API token.
     */
    public static function client(string $apiKey, string $organization = null): Client
    {
        if (self::$client === null) {
            self::$client = self::factory()
                ->withApiKey($apiKey)
                ->withOrganization($organization)
                ->make();
        }

        return self::$client;
    }

    /**
     * Creates a new factory instance to configure a custom Open AI Client
     */
    public static function factory(): Factory
    {
        return new Factory();
    }

    /**
     * Makes a text completion request to the ChatGPT API.
     */
    public function complete(string $prompt, array $options = []): string
    {
        $client = self::client(''); // digite sua chave do CHAT GPT (openAI)
        $openAIResource = $client->completions();
        $options['engine'] = 'text-davinci-003';
        $response = $openAIResource->create($options);

        return $response['choices'][0]['text'];
    }

}
