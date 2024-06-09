<?php

function setHttpResponseCode($status)
{

    if ($status != 'error') {
        http_response_code(200);
    } else {
        http_response_code(404);
    }
}