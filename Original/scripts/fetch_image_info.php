<?php
$url = 'http://127.0.0.1:8000/storage/items/GQdSVMDHIAAonH5hrJg58h8kMKgI4qr0cPh0c4Vi.jpg';
$ctx = stream_context_create(['http' => ['timeout' => 5]]);
$headers = @get_headers($url, 1);
$content = @file_get_contents($url, false, $ctx);
$preview = $content !== false ? base64_encode(substr($content, 0, 1024)) : null;
$result = [
    'url' => $url,
    'headers' => $headers,
    'preview_base64' => $preview,
    'content_length' => $content !== false ? strlen($content) : null,
];
echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
