<?php
function hasAccess($section) {
    if (!isset($_COOKIE['permissions'])) {
        return false;
    }

    $permissions = json_decode($_COOKIE['permissions'], true);
    return isset($permissions[$section]) && $permissions[$section] === true;
}
?>
