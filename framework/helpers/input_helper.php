<?php

function deepslashes($data) {
    if (empty($data)) {
        return $data;
    }
    return is_array($data) ? array_map('deepslashes',$data) : addslashes($data);
}

function deepspecialchars($data)
{
    if (empty($data)) {
        return $data;
    }
    return is_array($data) ? array_map('deepspecialchars', $data) : htmlspecialchars($data);
}