<?php
//*** START - Security ***// 
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function tokenGenerator($length = 50) {
    return bin2hex(random_bytes($length));
}

// Esto para sanitizar un array de datos
function sanitizeInputArray($inputArray) {
    $sanitizedArray = [];
    foreach ($inputArray as $key => $value) {
        $sanitizedArray[$key] = sanitizeInput($value);
    }
    return $sanitizedArray;
}

//*** END - Security ***// 

//*** START - AJAX Functions ***//
function jsonResponse($status, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => $status,
        'message' => $message,
        'data' => $data
    ]);
    exit();
}

//*** END - AJAX Functions ***//

//*** START - Date Format ***//
function diffDate($start_date, $end_date) {
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $diff = $start->diff($end);
    return $diff->days;
}

function formatDate($date, $format = 'Y-m-d H:i:s') {
    return date($format, strtotime($date));
}

function calculateAge($birthDate) {
    $today = new DateTime();
    $birthdate = new DateTime($birthDate);
    $age = $today->diff($birthdate);
    return $age->y;
}

//*** END - Date Format ***// 
