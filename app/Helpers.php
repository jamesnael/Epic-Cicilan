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
                'icon' => 'mdi-badge-account',
                'text' => 'User',
                'uri' => route('users.index'),
                'model' => in_array(Route::currentRouteName(), ['users.index','users.create','users.edit'])
            ],
            [
                'icon' => 'mdi-account-group',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Kelola Sales',
                'model' => in_array(Route::currentRouteName(), ['commission.index','commission.create','commission.edit','main-coordinator.index','main-coordinator.create','main-coordinator.edit','regional-coordinator.index','regional-coordinator.create','regional-coordinator.edit','sales.index','sales.create','sales.edit','agencies.index','agencies.create','agencies.edit']),
                'children' => [
                    [
                        'icon' => 'mdi-account-cash',
                        'text' => 'Komisi',
                        'uri' => route('commission.index'),
                        'model' => in_array(Route::currentRouteName(), ['commission.index','commission.create','commission.edit'])
                    ],
                    [
                        'icon' => 'mdi-account-network',
                        'text' => 'Koordinator Utama',
                        'uri' => route('main-coordinator.index'),
                        'model' => in_array(Route::currentRouteName(), ['main-coordinator.index','main-coordinator.create','main-coordinator.edit'])
                    ],
                    [
                        'icon' => 'mdi-account-supervisor-circle',
                        'text' => 'Koordinator Wilayah',
                        'uri' => route('regional-coordinator.index'),
                        'model' => in_array(Route::currentRouteName(), ['regional-coordinator.index','regional-coordinator.create','regional-coordinator.edit'])
                    ],
                    [
                        'icon' => 'mdi-contacts',
                        'text' => 'Agensi',
                        'uri' => route('agencies.index'),
                        'model' => in_array(Route::currentRouteName(), ['agencies.index','agencies.create','agencies.edit'])
                    ],
                    [
                        'icon' => 'mdi-account-tie',
                        'text' => 'Sales',
                        'uri' => route('sales.index'),
                        'model' => in_array(Route::currentRouteName(), ['sales.index','sales.create','sales.edit'])
                    ],
                ],
            ],
            [
                'icon' => 'mdi-gift',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Kelola Reward',
                'model' => in_array(Route::currentRouteName(), ['reward-category.index','reward-category.create','reward-category.edit','point.index','point.create','point.edit','reward-point.index','reward-point.create','reward-point.edit']),
                'children' => [
                    [
                        'icon' => 'mdi-certificate',
                        'text' => 'Kategori Reward',
                        'uri' => route('reward-category.index'),
                        'model' => in_array(Route::currentRouteName(), ['reward-category.index','reward-category.create','reward-category.edit'])
                    ],
                    [
                        'icon' => 'mdi-numeric-0-circle-outline',
                        'text' => 'Point',
                        'uri' => route('point.index'),
                        'model' => in_array(Route::currentRouteName(), ['point.index','point.create','point.edit'])
                    ],
                    [
                        'icon' => 'mdi-wallet-giftcard',
                        'text' => 'Reward Point',
                        'uri' => route('reward-point.index'),
                        'model' => in_array(Route::currentRouteName(), ['reward-point.index','reward-point.create','reward-point.edit'])
                    ],
                ]
            ],
            [
                'icon' => 'mdi-account-multiple',
                'text' => 'Klien',
                'uri' => route('client.index'),
                'model' => in_array(Route::currentRouteName(), ['client.index','client.create','client.edit'])
            ],
            [
                'icon' => 'mdi-calendar-check',
                'text' => 'Booking',
                'uri' => route('booking.index'),
                'model' => in_array(Route::currentRouteName(), ['booking.index','booking.create','booking.edit'])
            ],            
        ];
    }
}
