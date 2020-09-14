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

if (! function_exists('get_next_date')) {
    function get_next_date($day = 1){
        $date = \Carbon\Carbon::now()->day($day);
        
        if($date->isPast()){
            $date->month++;
        }

        return $date->format('Y-m-d');
    }
}

if (! function_exists('get_next_month')) {
    function get_next_month($date_str='1970-01-01', $months=1){
        $date = new \DateTime($date_str);

        // We extract the day of the month as $start_day
        $start_day = $date->format('j');

        // We add 1 month to the given date
        $date->modify("+{$months} month");

        // We extract the day of the month again so we can compare
        $end_day = $date->format('j');

        if ($start_day != $end_day)
        {
            // The day of the month isn't the same anymore, so we correct the date
            $date->modify('last day of last month');
        }

        return \Carbon\Carbon::instance($date)->format('Y-m-d');
    }
}

if (! function_exists('reformatDate')) {
    function reformatDate($date) {
        $strSearch = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec',
        ];
        $strReplace = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agu',
            'Sep',
            'Okt',
            'Nov',
            'Des',
        ];
        return str_ireplace($strSearch, $strReplace, $date);
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
                        'text' => 'Sub Agent',
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
                        'icon' => 'mdi-domain',
                        'text' => 'Tipe Bangunan',
                        'uri' => route('point.index'),
                        'model' => in_array(Route::currentRouteName(), ['point.index','point.create','point.edit'])
                    ],
                    [
                        'icon' => 'mdi-wallet-giftcard',
                        'text' => 'Reward',
                        'uri' => route('reward-point.index'),
                        'model' => in_array(Route::currentRouteName(), ['reward-point.index','reward-point.create','reward-point.edit'])
                    ],
                ]
            ],
            [
                'icon' => 'mdi-home-city',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Kelola Booking',
                'model' => in_array(Route::currentRouteName(), ['client.index','client.create', 'client.edit', 'unit.index', 'unit.create', 'unit.edit', 'booking.index', 'booking.create', 'booking.edit', 'installment.index', 'installment.create', 'installment.edit']),
                'children' => [
                    [
                        'icon' => 'mdi-account-multiple',
                        'text' => 'Klien',
                        'uri' => route('client.index'),
                        'model' => in_array(Route::currentRouteName(), ['client.index','client.create','client.edit'])
                    ],
                    // [
                    //     'icon' => 'mdi-home-account',
                    //     'text' => 'Unit',
                    //     'uri' => route('unit.index'),
                    //     'model' => in_array(Route::currentRouteName(), ['unit.index','unit.create','unit.edit'])
                    // ], 
                    [
                        'icon' => 'mdi-calendar-check',
                        'text' => 'Booking',
                        'uri' => route('booking.index'),
                        'model' => in_array(Route::currentRouteName(), ['booking.index','booking.create','booking.edit'])
                    ],
                    [
                        'icon' => 'mdi-account-cash-outline',
                        'text' => 'Edit Cicilan',
                        'uri' => route('installment.index'),
                        'model' => in_array(Route::currentRouteName(), ['installment.index','installment.create','installment.edit'])
                    ]
                ]           
            ],
            [
                'icon' => 'mdi-book-multiple',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Kelola Dokumen',
                'model' => in_array(Route::currentRouteName(), ['document.index','document.create', 'document.edit', 'document-admin.index', 'document-admin.create', 'document-admin.edit']),
                'children' => [
                    [
                        'icon' => 'mdi-file-document',
                        'text' => 'Dokumen Sales',
                        'uri' => route('document.index'),
                        'model' => in_array(Route::currentRouteName(), ['document.index','document.create','document.edit'])
                    ],
                    [
                        'icon' => 'mdi-file-document-outline',
                        'text' => 'Dokumen Admin',
                        'uri' => route('document-admin.index'),
                        'model' => in_array(Route::currentRouteName(), ['document-admin.index','document-admin.create','document-admin.edit'])
                    ]
                ]           
            ],
            [  
                'icon' => 'mdi-home-currency-usd',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'SPR',
                'uri' => route('spr.index'),
                'model' => in_array(Route::currentRouteName(), ['spr.index','spr.create', 'spr.edit']),
            ],
            [
                'icon' => 'mdi-buffer',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'PPJB',
                'uri' => route('PPJB.index'),
                'model' => in_array(Route::currentRouteName(), ['PPJB.index','PPJB.create', 'PPJB.edit']),
            ],
            [
                'icon' => 'mdi-cash-multiple',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Pembayaran Cicilan',
                'uri' => route('installment-unit.index'),
                'model' => in_array(Route::currentRouteName(), ['installment-unit.index','installment-unit.create', 'installment-unit.edit']),
            ], 
            [
                'icon' => 'mdi-card-account-details-star',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Proses Akad KPR',
                'uri' => route('akad.index'),
                'model' => in_array(Route::currentRouteName(), ['akad.index','akad.create', 'akad.edit']),
            ],
            [
                'icon' => 'mdi-book',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'AJB (Akte Jual Beli)',
                'uri' => route('ajb.index'),
                'model' => in_array(Route::currentRouteName(), ['ajb.index','ajb.create', 'ajb.edit']),
            ],
            [
                'icon' => 'mdi-handshake',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Serah Terima Unit',
                'uri' => route('handover.index'),
                'model' => in_array(Route::currentRouteName(), ['handover.index','handover.create', 'handover.edit']),
            ],
            [
                'icon' => 'mdi-sale',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Komisi Sales',
                'uri' => route('salescommission.index'),
                'model' => in_array(Route::currentRouteName(), ['salescommission.index','salescommission.create', 'salescommission.edit']),
            ],
            // [
            //     'icon' => 'mdi-cash-multiple',
            //     'icon-alt' => 'mdi-chevron-down',
            //     'text' => 'Tipe Pembayaran',
            //     'uri' => route('PaymentType.index'),
            //     'model' => in_array(Route::currentRouteName(), ['PaymentType.index','PaymentType.create', 'PaymentType.edit']),
            // ],
            [
                'icon' => 'mdi-certificate',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Tukar Point',
                'uri' => route('tukar-point.index'),
                'model' => in_array(Route::currentRouteName(), ['tukar-point.index','tukar-point.create', 'tukar-point-agent.history', 'tukar-point-korut.history', 'tukar-point-korwil.history', 'tukar-point-sales.history']),
            ],
        ];
    }
}
