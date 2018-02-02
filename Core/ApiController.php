<?php

namespace App\Core;

class ApiController extends Controller {
    /** Render Custom Full Error in API format.
     * @param $message
     * @param null $errorStatusCode
     * @return string
     */
    function renderFullError($message, $errorStatusCode = null)
    {
        //Send response code via Header.
        if (is_numeric($errorStatusCode))
            http_response_code($errorStatusCode);

        return json_encode(['error' => ['code' => $errorStatusCode, 'message' => $message]]);
    }
}