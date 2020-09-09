@extends('app')

@section('content')

@include('components.breadcrumbs')

<change-password inline-template>
    <v-card 
        elevation="4">
        <v-container fluid>
            <v-card flat>
                <validation-observer ref="observer" v-slot="{ validate, reset }">
                    <form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
                        <h3 class="mt-4">Ubah Password</h3 class="mt-4">
                        <validation-provider v-slot="{ errors }" name="Password lama" rules="required|min:8">
                            <v-text-field
                                class="mt-4"
                                v-model="old_password"
                                name="old_password"
                                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                :type="show1 ? 'text' : 'password'"
                                label="Kata Sandi Lama"
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
                        <validation-provider v-slot="{ errors }" name="Password" rules="required|min:8" vid="confirmation">
                            <v-text-field
                                class="mt-4"
                                v-model="password"
                                name="password"
                                :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                                :type="show2 ? 'text' : 'password'"
                                label="Kata Sandi Baru"
                                hint="* harus diisi"
                                :persistent-hint="true"
                                :error-messages="errors"
                                :readonly="field_state"
                                prepend-icon="mdi-lock"
                                :counter="8"
                                @click:append="show2 = !show2"
                            >
                            </v-text-field>
                        </validation-provider>
                        <validation-provider v-slot="{ errors }" name="Konfirmasi password"  rules="required|min:8|confirmed:confirmation">
                            <v-text-field
                                class="mt-4"
                                v-model="password_confirmation"
                                :append-icon="show3 ? 'mdi-eye' : 'mdi-eye-off'"
                                :type="show3 ? 'text' : 'password'"
                                label="Konfirmasi Kata Sandi"
                                hint="* harus diisi"
                                :persistent-hint="true"
                                :error-messages="errors"
                                :readonly="field_state"
                                prepend-icon="mdi-lock"
                                :counter="8"
                                name="password_confirmation"
                                @click:append="show3 = !show3"
                            >
                            </v-text-field>
                        </validation-provider>

                    <v-btn
                        class="mt-4 mr-4 white--text"
                        color="primary"
                        elevation="5"
                        :disabled="field_state"
                        :loading="field_state"
                        @click="submit">
                        Ubah Password
                        <template v-slot:loader>
                            <span class="custom-loader">
                                <v-icon color="white">mdi-sync</v-icon>
                            </span>
                        </template>
                    </v-btn>

                    <v-btn
                        class="mt-4"
                        elevation="5"
                        outlined
                        href="{{url('/')}}" 
                        >
                        kembali
                    </v-btn>
                    </form>
                </validation-observer>
            </v-card>
            <v-card>
                <v-snackbar
                    v-model="formAlert"
                    top
                    multi-line
                    :color="formAlertState"
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
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </template>
                </v-snackbar>
            </v-card>
        </v-container>
    </v-card>
</change-password>
@endsection

