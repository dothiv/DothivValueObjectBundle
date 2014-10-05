<?php

spl_autoload_register(function ($class) {
    if (strpos($class, 'Dothiv') === 0) {
        $parts = explode('\\', $class);
        array_shift($parts);
        require_once __DIR__ . '/../Dothiv/' . join(DIRECTORY_SEPARATOR, $parts) . '.php';
        return true;
    }
    return false;
});
