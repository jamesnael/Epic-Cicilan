<?php 

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

if (! function_exists('format_money')) {
    function format_money($value=0)
    {
        return number_format($value, 0, ',', '.');
    }
}

if (! function_exists('clean_string')) {
    function clean_string($string)
    {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        $string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.

        return str_replace('=', '', $string);
    }
}

if (! function_exists('trim_string')) {
    function trim_string($string, $length = 30, $suffix = '...')
    {
        if (strlen($string) > $length) {

            // truncate string
            $stringCut = substr($string, 0, $length);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
            $string .= $suffix;
        }
        return $string;
    }
}

if (! function_exists('response_json')) {
    function response_json($success = false, $error = null, $message = '', $data = null, $filter = null)
    {
        $response = [
            'success' => $success,
            'error' => $error,
            'message' => $message
        ];

        if ($data) {
            $response['data'] = $data;
        }
        
        if ($filter) {
            $response['filter'] = $filter;
        }

        return response()->json($response);
    }
}

if (! function_exists('uniqidReal')) {
    function uniqidReal($lenght = 13) {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
        return strtoupper(substr(bin2hex($bytes), 0, $lenght));
    }
}

if (! function_exists('get_available_routes')) {
    function get_available_routes() {
        \Artisan::call('route:list --json');
        $routes = json_decode(\Artisan::output(), true);
        $collection = collect($routes);
        $filtered = $collection->transform(function($item) {
            return collect($item)->only(['method', 'uri', 'name']);
        })
        ->filter(function($item, $key) {
            $available_method = ["GET|HEAD", "POST", "PUT|PATCH", "DELETE"];
            $unavailable_name = ["underconstruction", "debugbar", "ignition"];
            $unavailable_uri = ["register", "logout", "password/", "login", "fallbackPlaceholder", "table"];

            if (! Str::contains($item['name'], $unavailable_name) &&
                Str::contains($item['method'], $available_method) &&
                !Str::contains($item['uri'], $unavailable_uri) &&
                $item['name']
                ) {
                return $item;
            }
            return;
        });

        return $routes = array_values($filtered->all());
    }
}

if (! function_exists('aside_menu')) {
    function aside_menu()
    {
        return [
            [
                'icon' => 'mdi-contacts',
                'text' => 'Agensi',
                'uri' => route('agencies.index'),
                'model' => in_array(Route::currentRouteName(), ['agencies.index','agencies.create','agencies.edit'])
            ],
            [
                'icon' => 'mdi-badge-account',
                'text' => 'User',
                'uri' => route('users.index'),
                'model' => in_array(Route::currentRouteName(), ['users.index','users.create','users.edit'])
            ],
            [
                'icon' => 'mdi-account-tie',
                'text' => 'Sales',
                'uri' => route('sales.index'),
                'model' => in_array(Route::currentRouteName(), ['sales.index','sales.create','sales.edit'])
            ],
            [
                'icon' => 'mdi-gift',
                'text' => 'Kategori Reward',
                'uri' => route('sales.index'),
                'model' => in_array(Route::currentRouteName(), ['reward-category.index','reward-category.create','reward-category.edit'])
            ]

            // { icon: 'mdi-contacts', text: 'Contacts' },
            // { icon: 'mdi-history', text: 'Frequently contacted', model: true },
            // { icon: 'mdi-content-copy', text: 'Duplicates' },
            // {
            //     icon: 'mdi-chevron-up',
            //     'icon-alt': 'mdi-chevron-down',
            //     text: 'Labels',
            //     model: true,
            //     children: [
            //         { icon: 'mdi-plus', text: 'Create label', model: false },
            //         { icon: 'mdi-plus', text: 'Create label', model: true },
            //     ],
            // },
            // {
            //     icon: 'mdi-chevron-up',
            //     'icon-alt': 'mdi-chevron-down',
            //     text: 'Labels',
            //     model: false,
            //     children: [
            //         { icon: 'mdi-plus', text: 'Create label', model: false },
            //     ],
            // },
            // { icon: 'mdi-cog', text: 'Settings' },
            // { icon: 'mdi-message', text: 'Send feedback' },
            // { icon: 'mdi-help-circle', text: 'Help' },
            // { icon: 'mdi-cellphone-link', text: 'App downloads' },
            // { icon: 'mdi-keyboard', text: 'Go to the old version' },
        ];
    }
}
