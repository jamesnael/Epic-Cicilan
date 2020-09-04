<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="/assets/media/logos/favicon.ico" />

        <link href="{{ mix('public/css/app.css') }}?t={{date('Ymd')}}" rel="stylesheet">
        @yield('styles')
    </head>
    <body>
        
        <div id="page-content">
            <base-layout inline-template>
                <v-app id="content">
                    <v-app-bar
                        :clipped-left="$vuetify.breakpoint.lgAndUp"
                        app
                        color="blue darken-3"
                        dark
                    >
                        <v-toolbar-title
                            style="width: 300px"
                            class="ml-0 pl-4"
                        >
                            <span class="hidden-sm-and-down">{{ config('app.name', 'Laravel') }}</span>
                        </v-toolbar-title>
                    </v-app-bar>
                    <v-main>
                        <v-container
                            fluid
                        >
                            @yield('content')
                        </v-container>
                    </v-main>
                </v-app>
            </base-layout>
        </div>
        
        <script src="{{ mix('public/js/app.js') }}?t={{date('Ymd')}}"></script>
        @yield('scripts')
    </body>
</html>