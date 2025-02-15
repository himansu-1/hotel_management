<?php
function hasAccess($section)
{
    if (!isset($_COOKIE['permissions'])) {
        return false;
    }

    $permissions = json_decode($_COOKIE['permissions'], true);
    return isset($permissions[$section]) && $permissions[$section] === 1;
}

// Function to check if the user has access to ANY of the given sections
function hasAnyAccess(...$sections)
{
    if (!isset($_COOKIE['permissions'])) {
        return false;
    }

    $permissions = json_decode($_COOKIE['permissions'], true);

    foreach ($sections as $section) {
        if (isset($permissions[$section]) && $permissions[$section] === 1) {
            return true; // Return true if at least one permission is found
        }
    }
    return false; // Return false if none of the permissions are found
}
