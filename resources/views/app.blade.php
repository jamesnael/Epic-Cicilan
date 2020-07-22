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
			<base-layout inline-template
				:items='@json(aside_menu())'>
				<v-app id="content">
				    <v-navigation-drawer
				        v-model="drawer"
				        :clipped="$vuetify.breakpoint.lgAndUp"
				        app
				    >
				        <v-list dense shaped>
				            <template v-for="item in items">
				            	<v-list-group
					            	v-if="item.children"
				            	    :key="item.text"
				            	    v-model="item.model"
				            	    :prepend-icon="item.icon"
				            	    no-action
				            	>
				            	    <template v-slot:activator>
				            	        <v-list-item-content>
				            	            <v-list-item-title v-text="item.text"></v-list-item-title>
				            	        </v-list-item-content>
				            	    </template>

				            	    <v-list-item
				            	        v-for="(child, i) in item.children"
				            	        :key="i"
				                        v-model="child.model"
				                        link
				                        :href="child.uri"
				                        color="primary"
				                        class="pl-7"
				            	    >
				            	        <v-list-item-action v-if="child.icon" class="mr-5">
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
				                    :href="item.uri"
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
		
		<script src="{{ mix('public/js/app.js') }}?t={{date('Ymd')}}"></script>
		@yield('scripts')
	</body>
</html>