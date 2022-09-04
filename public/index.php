<?php
$dirs = scandir("./");

$supportedLanguages = array_filter($dirs, function ($dir) {
    return ($dir != "." && $dir != ".." && strlen($dir) == 2);
});

$userLanguage = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)) : "de";
$redirectLanguage = (in_array($userLanguage, $supportedLanguages)) ? $userLanguage : "de";

header("Location: ./" . $redirectLanguage . "/", true, 302);
