<?php
$lastInstallFilePath = "last-commit.log";
$currentCommit = trim(exec("git log -n 1 --decorate='short'"));
$shouldInstall = false;

if (file_exists($lastInstallFilePath)) {
    $shouldInstall = trim(file_get_contents($lastInstallFilePath)) != $currentCommit;
} else {
    $shouldInstall = true;
}

if (!$shouldInstall) {
    die("No updates required ... Current git version $currentCommit");
}

file_put_contents($lastInstallFilePath, $currentCommit);

exec("cp .env.prod .env");
exec("php composer.phar install");