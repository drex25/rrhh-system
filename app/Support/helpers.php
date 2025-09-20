<?php

if (!function_exists('current_company')) {
    function current_company()
    {
        return app()->bound('currentCompany') ? app('currentCompany') : null;
    }
}

if (!function_exists('company_id')) {
    function company_id(): ?int
    {
        return current_company()?->id;
    }
}
