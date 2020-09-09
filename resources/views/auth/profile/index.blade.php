@extends('app')

@section('content')

@include('components.breadcrumbs')

<profile-user inline-template>
    <v-card 
        elevation="4">
        <v-container fluid>
            <v-card flat>
                <h3 class="mt-4">Profile Pengguna</h3 class="mt-4">
                <v-text-field
                    class="mt-4"
                    label="Nama"
                    prepend-icon="mdi-account"
                    value="{{\Auth::user()->full_name}}"
                    readonly
                >
                </v-text-field>
                <v-text-field
                    class="mt-4"
                    label="Email"
                    prepend-icon="mdi-mail"
                    value="{{\Auth::user()->email}}"
                    readonly
                >
                </v-text-field>
                <v-text-field
                    class="mt-4"
                    label="Nomor Handphone"
                    prepend-icon="mdi-phone"
                    value="{{\Auth::user()->phone_number}}"
                    readonly
                >
                </v-text-field>

                <v-btn
                    class="mt-4"
                    outlined
                    href="{{url('/')}}" 
                    >
                    kembali
                </v-btn>
            </v-card>
        </v-container>
    </v-card>
</profile-user>
    
@endsection

