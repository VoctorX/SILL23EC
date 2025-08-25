<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $secret = "6Le3OzkqAAAAAGqGJh6dE83ex5OQXFZGWNJvI55g"; 
    $response = $_POST['g-recaptcha-response'];
    $remote_ip = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => $secret,
        'response' => $response,
        'remoteip' => $remote_ip
    ];

    $options = [
        'http' => [
            'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $resultJson = json_decode($result);

    if ($resultJson->success) {
        echo "¡Formulario enviado con éxito!";
    } else {
        echo "Error: por favor, completa el reCAPTCHA correctamente.";
    }
}
?>
