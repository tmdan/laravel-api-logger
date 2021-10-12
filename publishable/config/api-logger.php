<?php

return [
    'enabled' => boolval($_SERVER['API_LOGGER_ENABLED'] ?? env('API_LOGGER_ENABLED', false)),
];
