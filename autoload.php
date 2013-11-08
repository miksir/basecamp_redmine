<?php
spl_autoload_register(
    function($name) {
        $name = str_replace('\\', '/', $name);
        require './' . $name . '.php';
    }
);
