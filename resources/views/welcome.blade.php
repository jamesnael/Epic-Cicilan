<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ mix('public/css/app.css') }}?t={{date('Ymd')}}" rel="stylesheet">
    </head>
    <body>
        <div id="page-content">
            <example-component inline-template>
                <v-app id="sandbox">
                    <v-navigation-drawer
                      v-model="primaryDrawer.model"
                      :clipped="primaryDrawer.clipped"
                      :floating="primaryDrawer.floating"
                      :mini-variant="primaryDrawer.mini"
                      :permanent="primaryDrawer.type === 'permanent'"
                      :temporary="primaryDrawer.type === 'temporary'"
                      app
                      overflow
                    ></v-navigation-drawer>

                    <v-app-bar
                      :clipped-left="primaryDrawer.clipped"
                      app
                    >
                      <v-app-bar-nav-icon
                        v-if="primaryDrawer.type !== 'permanent'"
                        @click.stop="primaryDrawer.model = !primaryDrawer.model"
                      ></v-app-bar-nav-icon>
                      <v-toolbar-title>Vuetify</v-toolbar-title>
                    </v-app-bar>

                    <v-main>
                      <v-container fluid>
                        @yield('content')
                      </v-container>
                    </v-main>

                    <v-footer
                      :inset="footer.inset"
                      app
                    >
                      <span class="px-4">&copy; @{{ new Date().getFullYear() }}</span>
                    </v-footer>
                  </v-app>
            </example-component>
        </div>

        <script src="{{ mix('public/js/app.js') }}?t={{date('Ymd')}}"></script>
    </body>
</html>
