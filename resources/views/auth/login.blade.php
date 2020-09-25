@extends('layouts.app')

@section('content')
<login-form inline-template>
    <validation-observer ref="observer" v-slot="{ validate, reset }">
        <form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
            <v-app id="inspire" v-cloak>
                <v-main>
                    <v-container
                      class="fill-height"
                      fluid
                    >
                      <v-row
                        align="center"
                        justify="center"
                      >
                        <v-col
                          cols="12"
                          sm="8"
                          md="4"
                        >
                          <v-card class="elevation-12">
                            <v-toolbar
                              color="primary"
                              dark
                              flat
                            >
                              <v-toolbar-title>Login Form</v-toolbar-title>
                              <v-spacer></v-spacer>
                              </v-tooltip>
                            </v-toolbar>
                            <v-card-text>
                                <validation-provider v-slot="{ errors }" name="Email" rules="required">
                                    <v-text-field
                                        v-model="email"
                                        label="Email"
                                        name="email"
                                        prepend-icon="mdi-account"
                                        type="email"
                                        hint="* harus diisi"
                                        :persistent-hint="true"
                                        :counter="255"
                                        :error-messages="errors"
                                        :readonly="field_state">
                                    ></v-text-field>
                                </validation-provider>
                                <validation-provider v-slot="{ errors }" name="Password" rules="required|min:8">
                                    <v-text-field
                                        v-model="password"
                                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                        :type="show1 ? 'text' : 'password'"
                                        name="password"
                                        label="Password"
                                        hint="* harus diisi"
                                        :persistent-hint="true"
                                        :error-messages="errors"
                                        :readonly="field_state"
                                        prepend-icon="mdi-lock"
                                        :counter="8"
                                        @click:append="show1 = !show1"
                                    >
                                    </v-text-field>
                                </validation-provider>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    class="mt-4 mr-4 white--text"
                                    color="primary"
                                    type="submit"
                                    elevation="5"
                                    :disabled="field_state"
                                    :loading="field_state"
                                    @click="submit">
                                    Login
                                    <template v-slot:loader>
                                        <span class="custom-loader">
                                            <v-icon color="white">mdi-sync</v-icon>
                                        </span>
                                    </template>
                                </v-btn>
                            </v-card-actions>
                          </v-card>
                        </v-col>
                      </v-row>
                    </v-container>
                </v-main>
                <v-card>
                    <v-snackbar
                        v-model="formAlert"
                        :color="formAlertState"
                        top
                        multi-line
                        elevation="5"
                        timeout="6000"
                    >
                        @{{ formAlertText }}

                        <template v-slot:action="{ attrs }">
                            <v-btn
                                icon
                                v-bind="attrs"
                                @click="formAlert = false"
                            >
                                {{-- <v-icon>mdi-close</v-icon> --}}
                            </v-btn>
                        </template>
                    </v-snackbar>
                </v-card>
            </v-app>
        </form>
    </validation-observer>
</login-form>

@endsection
