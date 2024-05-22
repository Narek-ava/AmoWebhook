<?php

$request_body = file_get_contents('php://input');

$decoded_request_body = urldecode($request_body);

parse_str($decoded_request_body, $data);

$json_data = json_encode($data);

$log_file = 'amoWebhook.log';
$data = json_decode($json_data,true);
file_put_contents($log_file, $json_data . PHP_EOL, FILE_APPEND);

$url = 'https://avarazmik.amocrm.ru/api/v4/leads/'.$data['leads']['add'][0]['id'].'/notes';

$data = [
    [
        "entity_id" => $data['leads']['add'][0]['id'],
        "note_type" => "geolocation",
        "params" => [
            "text" => $data['leads']['add'][0]['name'],
            "address" => "ул. Пушкина, дом Колотушкина, квартира Вольнова",
            "longitude" => "53.714816",
            "latitude" => "91.423146"
        ]
    ]
];

$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjFmZmFiYTM4YzdiODUxMWRkZGU3MDQ0YzhkNDdhNTBlMmIwZDliOGEzNGMwMzQ2MTY4Y2E1NmFjMjA5ZTgxNDExZGVhOGI3ZjkxMmMzMmYzIn0.eyJhdWQiOiIyNzY3MjBmMS1jNDYyLTQxYTUtOGVjMi05NzkzMzZlNmJhZjEiLCJqdGkiOiIxZmZhYmEzOGM3Yjg1MTFkZGRlNzA0NGM4ZDQ3YTUwZTJiMGQ5YjhhMzRjMDM0NjE2OGNhNTZhYzIwOWU4MTQxMWRlYThiN2Y5MTJjMzJmMyIsImlhdCI6MTcxNjM3NTAzMiwibmJmIjoxNzE2Mzc1MDMyLCJleHAiOjE3MTcxMTM2MDAsInN1YiI6IjExMDcwNTA2IiwiZ3JhbnRfdHlwZSI6IiIsImFjY291bnRfaWQiOjMxNzYwNDA2LCJiYXNlX2RvbWFpbiI6ImFtb2NybS5ydSIsInZlcnNpb24iOjIsInNjb3BlcyI6WyJjcm0iLCJmaWxlcyIsImZpbGVzX2RlbGV0ZSIsIm5vdGlmaWNhdGlvbnMiLCJwdXNoX25vdGlmaWNhdGlvbnMiXSwiaGFzaF91dWlkIjoiZmU4ZjI0ZmUtMTE2OC00YzEzLWJiYjYtZmFlMDg5YzcwZDNjIn0.kwOYP9puHrAwbGylMLWO-ggE8aXtEH--RLREN1onAIM9OOxJu5qz4qoFbLSzJ33q3pWp0lfDWqhnCyXXU6WVpRJakauki_dmSRpnccFVhWeLZuxkme8nxsytGNM5g4Gv9vWNp73gX2LYl4gQCZUm2pRPTCklnxv9tdBSksn5IZ9nAxprFBPwoIIoDafb2i3YyPksLaLWhJa_B6pye-FJDUsN5yIEZwvPN-Lb0mtbh4OWrSmJFOR965ADTLmsuHBBgblTYJt34vNvrKIEyco1O_MbrA9QaJywR2ui177DcucuhctK7cMYTzoZXVG5E2lS5e6XKkBmS95CTHtdonjb1g',
    'Cookie: session_id=ghmqife1bi5tsudsqelf41cn0c; user_lang=ru'
];

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => $headers,
]);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    echo 'Response: ' . $response;
}

curl_close($ch);




