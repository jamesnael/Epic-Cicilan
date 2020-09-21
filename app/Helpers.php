<?php 

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

if (! function_exists('is_allowed')) {
    function is_allowed($route_name = '')
    {
        return in_array($route_name, \Auth::user()->user_access?: []);
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
                'icon' => 'mdi-account-multiple',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Kelola User',
                'model' => in_array(Route::currentRouteName(), ['users.index','users.create','users.edit','role.index','role.create','role.edit','reward-point.index']),
                'show' => Auth::user()->is_admin || in_array('users.index', Auth::user()->user_access?: []) || in_array('role.index', Auth::user()->user_access?: []),
                'children' => [
                    [
                        'icon' => 'mdi-badge-account',
                        'text' => 'User',
                        'uri' => route('users.index'),
                        'model' => in_array(Route::currentRouteName(), ['users.index','users.create','users.edit']),
                        'show' => Auth::user()->is_admin || in_array('users.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-clipboard-account',
                        'text' => 'Hak Akses User',
                        'uri' => route('role.index'),
                        'model' => in_array(Route::currentRouteName(), ['role.index','role.create','role.edit']),
                        'show' => Auth::user()->is_admin || in_array('role.index', Auth::user()->user_access?: [])
                    ],
                ]
            ],
            [
                'icon' => 'mdi-account-group',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Kelola Sales',
                'model' => in_array(Route::currentRouteName(), ['commission.index','commission.create','commission.edit','main-coordinator.index','main-coordinator.create','main-coordinator.edit','regional-coordinator.index','regional-coordinator.create','regional-coordinator.edit','sales.index','sales.create','sales.edit','agencies.index','agencies.create','agencies.edit']),
                'show' => Auth::user()->is_admin || in_array('commission.index', Auth::user()->user_access?: []) || in_array('main-coordinator.index', Auth::user()->user_access?: []) || in_array('regional-coordinator.index', Auth::user()->user_access?: []) || in_array('agencies.index', Auth::user()->user_access?: []) || in_array('sales.index', Auth::user()->user_access?: []),
                'children' => [
                   
                    [
                        'icon' => 'mdi-account-cash',
                        'text' => 'Komisi',
                        'uri' => route('commission.index'),
                        'model' => in_array(Route::currentRouteName(), ['commission.index','commission.create','commission.edit']),
                        'show' => Auth::user()->is_admin || in_array('commission.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-account-network',
                        'text' => 'Koordinator Utama',
                        'uri' => route('main-coordinator.index'),
                        'model' => in_array(Route::currentRouteName(), ['main-coordinator.index','main-coordinator.create','main-coordinator.edit']),
                        'show' => Auth::user()->is_admin || in_array('main-coordinator.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-account-supervisor-circle',
                        'text' => 'Koordinator Wilayah',
                        'uri' => route('regional-coordinator.index'),
                        'model' => in_array(Route::currentRouteName(), ['regional-coordinator.index','regional-coordinator.create','regional-coordinator.edit']),
                        'show' => Auth::user()->is_admin || in_array('regional-coordinator.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-contacts',
                        'text' => 'Sub Agent',
                        'uri' => route('agencies.index'),
                        'model' => in_array(Route::currentRouteName(), ['agencies.index','agencies.create','agencies.edit']),
                        'show' => Auth::user()->is_admin || in_array('agencies.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-account-tie',
                        'text' => 'Sales',
                        'uri' => route('sales.index'),
                        'model' => in_array(Route::currentRouteName(), ['sales.index','sales.create','sales.edit']),
                        'show' => Auth::user()->is_admin || in_array('sales.index', Auth::user()->user_access?: [])
                    ],
                ],
            ],
            [
                'icon' => 'mdi-gift',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Kelola Reward',
                'model' => in_array(Route::currentRouteName(), ['reward-category.index','reward-category.create','reward-category.edit','reward-point.index','reward-point.create','reward-point.edit']),
                'show' => Auth::user()->is_admin || in_array('reward-category.index', Auth::user()->user_access?: []) || in_array('reward-point.index', Auth::user()->user_access?: []),
                'children' => [
                    [
                        'icon' => 'mdi-certificate',
                        'text' => 'Kategori Reward',
                        'uri' => route('reward-category.index'),
                        'model' => in_array(Route::currentRouteName(), ['reward-category.index','reward-category.create','reward-category.edit']),
                        'show' => Auth::user()->is_admin || in_array('reward-category.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-wallet-giftcard',
                        'text' => 'Reward',
                        'uri' => route('reward-point.index'),
                        'model' => in_array(Route::currentRouteName(), ['reward-point.index','reward-point.create','reward-point.edit']),
                        'show' => Auth::user()->is_admin || in_array('reward-point.index', Auth::user()->user_access?: [])
                    ],
                ]
            ],
            [
                'icon' => 'mdi-home-city',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Kelola Booking',
                'model' => in_array(Route::currentRouteName(), ['tipe-program.index','tipe-program.create','tipe-program.edit','client.index','client.create', 'client.edit', 'unit.index', 'unit.create', 'unit.edit', 'booking.index', 'booking.create', 'booking.edit', 'cancel-booking.index', 'cancel-booking.create', 'cancel-booking.edit', 'installment.index', 'installment.create', 'installment.edit', 'point.index', 'point.create', 'point.edit']),
                'show' => Auth::user()->is_admin || in_array('tipe-program.index', Auth::user()->user_access?: []) || in_array('point.index', Auth::user()->user_access?: []) || in_array('client.index', Auth::user()->user_access?: []) || in_array('booking.index', Auth::user()->user_access?: []) || in_array('installment.index', Auth::user()->user_access?: []) || in_array('cancel-booking.index', Auth::user()->user_access?: []),
                'children' => [
                    [
                        'icon' => 'mdi-trophy-award',
                        'text' => 'Tipe Program',
                        'uri' => route('tipe-program.index'),
                        'model' => in_array(Route::currentRouteName(), ['tipe-program.index','tipe-program.create','tipe-program.edit']),
                        'show' => Auth::user()->is_admin || in_array('tipe-program.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-domain',
                        'text' => 'Tipe Unit',
                        'uri' => route('point.index'),
                        'model' => in_array(Route::currentRouteName(), ['point.index','point.create','point.edit']),
                        'show' => Auth::user()->is_admin || in_array('point.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-account-multiple',
                        'text' => 'Klien',
                        'uri' => route('client.index'),
                        'model' => in_array(Route::currentRouteName(), ['client.index','client.create','client.edit']),
                        'show' => Auth::user()->is_admin || in_array('client.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-calendar-check',
                        'text' => 'Booking',
                        'uri' => route('booking.index'),
                        'model' => in_array(Route::currentRouteName(), ['booking.index','booking.create','booking.edit']),
                        'show' => Auth::user()->is_admin || in_array('booking.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-account-cash-outline',
                        'text' => 'Cicilan',
                        'uri' => route('installment.index'),
                        'model' => in_array(Route::currentRouteName(), ['installment.index','installment.create','installment.edit']),
                        'show' => Auth::user()->is_admin || in_array('installment.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-table-cancel',
                        'text' => 'Cancel Booking',
                        'uri' => route('cancel-booking.index'),
                        'model' => in_array(Route::currentRouteName(), ['cancel-booking.index','cancel-booking.create','cancel-booking.edit']),
                        'show' => Auth::user()->is_admin || in_array('cancel-booking.index', Auth::user()->user_access?: [])
                    ],
                ]           
            ],
            [
                'icon' => 'mdi-book-multiple',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Kelola Dokumen',
                'model' => in_array(Route::currentRouteName(), ['document.index','document.create', 'document.edit', 'document-admin.index', 'document-admin.create', 'document-admin.edit']),
                'show' => Auth::user()->is_admin || in_array('document.index', Auth::user()->user_access?: []) || in_array('document-admin.index', Auth::user()->user_access?: []),
                'children' => [
                    [
                        'icon' => 'mdi-file-document',
                        'text' => 'Dokumen Sales',
                        'uri' => route('document.index'),
                        'model' => in_array(Route::currentRouteName(), ['document.index','document.create','document.edit']),
                        'show' => Auth::user()->is_admin || in_array('document.index', Auth::user()->user_access?: [])
                    ],
                    [
                        'icon' => 'mdi-file-document-outline',
                        'text' => 'Dokumen Admin',
                        'uri' => route('document-admin.index'),
                        'model' => in_array(Route::currentRouteName(), ['document-admin.index','document-admin.create','document-admin.edit']),
                        'show' => Auth::user()->is_admin || in_array('document-admin.index', Auth::user()->user_access?: [])
                    ]
                ]           
            ],
            [  
                'icon' => 'mdi-home-currency-usd',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'SPR',
                'uri' => route('spr.index'),
                'model' => in_array(Route::currentRouteName(), ['spr.index','spr.create', 'spr.edit']),
                'show' => Auth::user()->is_admin || in_array('spr.index', Auth::user()->user_access?: [])
            ],
            [
                'icon' => 'mdi-buffer',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'PPJB',
                'uri' => route('PPJB.index'),
                'model' => in_array(Route::currentRouteName(), ['PPJB.index','PPJB.create', 'PPJB.edit']),
                'show' => Auth::user()->is_admin || in_array('PPJB.index', Auth::user()->user_access?: [])
            ],
            [
                'icon' => 'mdi-cash-multiple',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Pembayaran Cicilan',
                'uri' => route('installment-unit.index'),
                'model' => in_array(Route::currentRouteName(), ['installment-unit.index','installment-unit.create', 'installment-unit.edit']),
                'show' => Auth::user()->is_admin || in_array('installment-unit.index', Auth::user()->user_access?: [])
            ], 
            [
                'icon' => 'mdi-card-account-details-star',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Proses Akad KPR',
                'uri' => route('akad.index'),
                'model' => in_array(Route::currentRouteName(), ['akad.index','akad.create', 'akad.edit']),
                'show' => Auth::user()->is_admin || in_array('akad.index', Auth::user()->user_access?: [])
            ],
            [
                'icon' => 'mdi-book',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'AJB (Akte Jual Beli)',
                'uri' => route('ajb.index'),
                'model' => in_array(Route::currentRouteName(), ['ajb.index','ajb.create', 'ajb.edit']),
                'show' => Auth::user()->is_admin || in_array('ajb.index', Auth::user()->user_access?: [])
            ],
            [
                'icon' => 'mdi-handshake',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Serah Terima Unit',
                'uri' => route('handover.index'),
                'model' => in_array(Route::currentRouteName(), ['handover.index','handover.create', 'handover.edit']),
                'show' => Auth::user()->is_admin || in_array('handover.index', Auth::user()->user_access?: [])
            ],
            [
                'icon' => 'mdi-sale',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Komisi Sales',
                'uri' => route('salescommission.index'),
                'model' => in_array(Route::currentRouteName(), ['salescommission.index','salescommission.create', 'salescommission.edit']),
                'show' => Auth::user()->is_admin || in_array('salescommission.index', Auth::user()->user_access?: [])
            ],
            [
                'icon' => 'mdi-certificate',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Tukar Point',
                'uri' => route('tukar-point.index'),
                'model' => in_array(Route::currentRouteName(), ['tukar-point.index','tukar-point-sales.create', 'tukar-point-agency.create', 'tukar-point-korwil.create', 'tukar-point-korut.create', 'tukar-point-agent.history', 'tukar-point-korut.history', 'tukar-point-korwil.history', 'tukar-point-sales.history']),
                'show' => Auth::user()->is_admin || in_array('tukar-point.index', Auth::user()->user_access?: [])
            ],
            [
                'icon' => 'mdi-file-chart',
                'icon-alt' => 'mdi-chevron-down',
                'text' => 'Laporan',
                'uri' => route('report.create'),
                'model' => in_array(Route::currentRouteName(), ['report.index','report.create']),
            ],
        ];
    }
}
