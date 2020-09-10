<?php

if (! function_exists('provinces_list')) {
    function provinces_list() {
        return Modules\Core\Entities\Province::get(['name', 'city']);
    }
}

if (! function_exists('banks_list')) {
    function banks_list() {
        return Modules\Core\Entities\Bank::pluck('name');
    }
}

if (! function_exists('occupations_list')) {
    function occupations_list() {
        return Modules\Core\Entities\Occupation::pluck('name');
    }
}

if (! function_exists('payment_methods_list')) {
    function payment_methods_list() {
        return Modules\Core\Entities\PaymentMethod::pluck('name');
    }
}
