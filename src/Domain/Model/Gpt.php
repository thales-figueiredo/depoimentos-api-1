<?php

namespace Alura\Pdo\Domain\Model;

class Gpt
{
private string $openAIKey;

public function __construct(string $openAIKey)
{
$this->openAIKey = $openAIKey;
}

public function complete(string $prompt, array $options = []): array
{
$url = 'https://api.openai.com/v1/engines/text-davinci-002/completions';

$headers = [
'Content-Type: application/json',
'Authorization: Bearer ' . $this->openAIKey,
];

$data = [
'prompt' => $prompt,
'max_tokens' => $options['max_tokens'] ?? 200,
'temperature' => $options['temperature'] ?? 0.7,
'stop' => $options['stop'] ?? ['\n'],
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

return json_decode($response, true);
}
}
