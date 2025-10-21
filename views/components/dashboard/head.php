<?php
session_start();

function getInitials($name)
{
    $words = explode(" ", trim($name));
    $initials = "";

    foreach ($words as $w) {
        if ($w !== "") {
            $initials .= strtoupper($w[0]);
        }
    }

    return $initials ?: "U";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Smart Farm Dashboard</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>