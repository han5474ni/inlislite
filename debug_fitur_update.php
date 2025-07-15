<?php
// Test script to debug fitur update functionality
// This should be removed after debugging

// Test the update functionality
$postData = [
    'title' => 'Updated Test Feature',
    'description' => 'This is an updated test feature description',
    'icon' => 'bi-star',
    'color' => 'blue',
    'type' => 'feature'
];

// Test with item ID 1 (Katalogisasi)
$url = 'http://localhost:8080/admin/fitur/update/1';

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'X-Requested-With: XMLHttpRequest'
]);

// Execute the request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

// Close cURL
curl_close($ch);

// Output results
echo "HTTP Code: " . $httpCode . "\n";
echo "Error: " . ($error ?: 'None') . "\n";
echo "Response: " . $response . "\n";

// Try to decode JSON response
$jsonResponse = json_decode($response, true);
if ($jsonResponse) {
    echo "\nParsed Response:\n";
    echo "Success: " . ($jsonResponse['success'] ? 'true' : 'false') . "\n";
    echo "Message: " . ($jsonResponse['message'] ?? 'No message') . "\n";
    if (isset($jsonResponse['errors'])) {
        echo "Errors: " . print_r($jsonResponse['errors'], true) . "\n";
    }
} else {
    echo "\nFailed to parse JSON response\n";
}
?>
