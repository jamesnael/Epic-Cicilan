<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8" />
		<title>{{ config('app.name', 'Laravel') }}</title>
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
		@yield('styles')
		<link rel="shortcut icon" href="/assets/media/logos/favicon.ico" />

		<link href="{{ mix('public/css/app.css') }}?t={{date('Ymd')}}" rel="stylesheet">
	</head>
	<body>
		
		<div id="page-content">
			<base-layout inline-template>
				<v-app id="content">
				    <v-navigation-drawer
				        v-model="drawer"
				        :clipped="$vuetify.breakpoint.lgAndUp"
				        app
				    >
				        <v-list dense>
				            <template v-for="item in items">
				                <v-row
				                    v-if="item.heading"
				                    :key="item.heading"
				                    align="center"
				                >
				                    <v-col cols="6">
				                        <v-subheader v-if="item.heading">
				                            @{{ item.heading }}
				                        </v-subheader>
				                    </v-col>
				                    <v-col
				                        cols="6"
				                        class="text-center"
				                    >
				                        <a
				                            href="#!"
				                            class="body-2 black--text"
				                        >EDIT</a>
				                    </v-col>
				                </v-row>
				                <v-list-group
				                    v-else-if="item.children"
				                    :key="item.text"
				                    v-model="item.model"
				                    :prepend-icon="item.model ? item.icon : item['icon-alt']"
				                    append-icon=""
				                >
				                    <template v-slot:activator>
				                        <v-list-item-content>
				                            <v-list-item-title>
				                                @{{ item.text }}
				                            </v-list-item-title>
				                        </v-list-item-content>
				                    </template>
				                    <v-list-item
				                        v-for="(child, i) in item.children"
				                        :key="i"
				                        v-model="child.model"
				                        link
				                        color="primary"
				                    >
				                        <v-list-item-action v-if="child.icon">
				                            <v-icon>@{{ child.icon }}</v-icon>
				                        </v-list-item-action>
				                        <v-list-item-content>
				                            <v-list-item-title>
				                                @{{ child.text }}
				                            </v-list-item-title>
				                        </v-list-item-content>
				                    </v-list-item>
				                </v-list-group>
				                <v-list-item
				                    v-else
				                    :key="item.text"
				                    v-model="item.model"
				                    link
				                    color="primary"
				                >
				                    <v-list-item-action>
				                        <v-icon>@{{ item.icon }}</v-icon>
				                    </v-list-item-action>
				                    <v-list-item-content>
				                        <v-list-item-title>
				                            @{{ item.text }}
				                        </v-list-item-title>
				                    </v-list-item-content>
				                </v-list-item>
				            </template>
				        </v-list>
				    </v-navigation-drawer>

				    <v-app-bar
				        :clipped-left="$vuetify.breakpoint.lgAndUp"
				        app
				        color="blue darken-3"
				        dark
				    >
				        <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
				        <v-toolbar-title
				            style="width: 300px"
				            class="ml-0 pl-4"
				        >
				            <span class="hidden-sm-and-down">{{ config('app.name', 'Laravel') }}</span>
				        </v-toolbar-title>
				        <v-spacer></v-spacer>
				        <v-btn icon>
				            <v-icon>mdi-bell</v-icon>
				        </v-btn>
				        <v-btn
				            icon
				            large
				        >
				            <v-avatar
				                size="32px"
				                item
				            >
				                <v-img
				                    src="https://cdn.vuetifyjs.com/images/logos/logo.svg"
				                    alt="Vuetify"
				                ></v-img></v-avatar>
				        </v-btn>
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
		
		@yield('scripts')
		<script src="{{ mix('public/js/app.js') }}?t={{date('Ymd')}}"></script>
	</body>
</html>