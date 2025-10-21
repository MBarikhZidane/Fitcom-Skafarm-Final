<?php
function timeAgo($datetime)
{
    $timestamp = strtotime($datetime);
    $difference = time() - $timestamp;

    if ($difference < 60) {
        return 'baru saja';
    } elseif ($difference < 3600) {
        return floor($difference / 60) . ' menit yang lalu';
    } elseif ($difference < 86400) {
        return floor($difference / 3600) . ' jam yang lalu';
    } elseif ($difference < 604800) {
        return floor($difference / 86400) . ' hari yang lalu';
    } elseif ($difference < 2592000) {
        return floor($difference / 604800) . ' minggu yang lalu';
    } elseif ($difference < 31536000) {
        return floor($difference / 2592000) . ' bulan yang lalu';
    } else {
        return floor($difference / 31536000) . ' tahun yang lalu';
    }
}
