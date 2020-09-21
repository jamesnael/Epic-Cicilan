<v-container fluid>
        <v-card flat>
            <validation-observer ref="observer" v-slot="{ validate, reset }">
                <form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
                    <v-card
                        elevation="5"
                        >
                        <v-card-title>
                            Informasi Data Klien
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="6">
                                    <v-text-field
                                        v-model="form_data.client_number"
                                        label="ID Klien"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="6">
                                    <v-text-field
                                        v-model="form_data.client_name"
                                        label="Nama Klien"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="6">
                                    <v-text-field
                                        v-model="form_data.client_mobile_number"
                                        label="Nomor Telepon"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="6">
                                    <v-text-field
                                        v-model="form_data.client_email"
                                        label="Alamat Email"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="6">
                                    <v-text-field
                                        v-model="form_data.client_address"
                                        label="Alamat Klien"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="6">
                                    <v-text-field
                                        v-model="form_data.sales_name"
                                        label="Nama Sales"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>

                    <v-card
                        class="mt-6"
                        elevation="5"
                        >
                        <v-card-title>
                            Informasi Data Unit
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        v-model="form_data.unit_type"
                                        label="Tipe Rumah"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        v-model="form_data.unit_block"
                                        label="Blok"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        v-model="form_data.unit_number"
                                        label="Nomor Unit"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        v-model="form_data.surface_area"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                        <template slot="label">
                                            <span v-html="'Luas Kavling (m<sup>2</sup>)'"></span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        v-model="form_data.building_area"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                        <template slot="label">
                                            <span v-html="'Luas Bangunan (m<sup>2</sup>)'"></span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        v-model="form_data.electrical_power"
                                        label="Daya Listrik (Watt)"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>

                    <v-card
                        class="mt-6"
                        elevation="5"
                        >
                        <v-card-title>
                            Informasi Data Sales
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="6">
                                    <v-text-field
                                        v-model="form_data.sales_name"
                                        label="Sales"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="6">
                                    <v-text-field
                                        v-model="form_data.agency_name"
                                        label="Sub Agent"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="6">
                                    <v-text-field
                                        v-model="form_data.regional_coordinator"
                                        label="Koordinator Wilayah"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="6">
                                    <v-text-field
                                        v-model="form_data.main_coordinator"
                                        label="Koordinator Utama"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>

                    <v-row
                        class="mt-6">
                        <v-col
                            cols="12"
                            md="6">
                            <v-card
                                elevation="5"
                                >
                                <v-card-title>
                                    Informasi Data NUP
                                </v-card-title>
                                <v-card-text>
                                    <v-row>
                                        <v-col
                                            cols="12">
                                            <v-text-field
                                                :value="number_format(form_data.nup_amount)"
                                                label="Total NUP"
                                                :readonly="!field_state"
                                                :disabled="field_state">
                                            </v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12">
                                            <v-text-field
                                                v-model="form_data.payment_method_nup"
                                                label="Metode Pembayaran"
                                                :readonly="!field_state"
                                                :disabled="field_state">
                                            </v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12">
                                            <v-text-field
                                                :value="reformatDateTime(form_data.nup_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
                                                label="Tanggal Pembayaran"
                                                :readonly="!field_state"
                                                :disabled="field_state">
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>                        
                        </v-col>
                        <v-col
                            cols="12"
                            md="6">
                            <v-card
                                elevation="5"
                                >
                                <v-card-title>
                                    Informasi Data UTJ
                                </v-card-title>
                                <v-card-text>
                                    <v-row>
                                        <v-col
                                            cols="12">
                                            <v-text-field
                                                :value="number_format(form_data.utj_amount)"
                                                label="Total UTJ"
                                                :readonly="!field_state"
                                                :disabled="field_state">
                                            </v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12">
                                            <v-text-field
                                                v-model="form_data.payment_method_utj"
                                                label="Metode Pembayaran"
                                                :readonly="!field_state"
                                                :disabled="field_state">
                                            </v-text-field>
                                        </v-col>
                                        <v-col
                                            cols="12">
                                            <v-text-field
                                                :value="reformatDateTime(form_data.utj_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
                                                label="Tanggal Pembayaran"
                                                :readonly="!field_state"
                                                :disabled="field_state">
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>

                    <v-card
                        class="mt-6"
                        elevation="5"
                        >
                        <v-card-title>
                            Informasi Pembayaran
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        v-model="form_data.payment_type"
                                        label="Tipe Pembayaran"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        :value="number_format(form_data.total_amount)"
                                        label="Total Harga"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        :value="number_format(form_data.first_payment)"
                                        label="Pembayaran Pertama"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        :value="number_format(form_data.principal)"
                                        label="Total cicilan yang harus dibayar"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        :value="number_format(form_data.installment)"
                                        label="Cicilan per Bulan"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                                <v-col
                                    cols="12"
                                    md="4">
                                    <v-text-field
                                        v-model="form_data.installment_time"
                                        label="Lama Cicilan"
                                        :readonly="!field_state"
                                        :disabled="field_state">
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>

                    <v-card
                      class="mt-6"
                      elevation="5"
                      >
                      <v-card-title>
                        Data Cicilan Unit
                      </v-card-title>
                      <v-card-text>
                        <v-data-table
                            :headers='@json($table_headers)'
                            :items="form_data.payments"
                            :items-per-page="1000"
                            hide-default-footer
                        >
                        @foreach ($table_headers as $element)
                          <template v-slot:header.{{$element['value']}}="{ header }">
                              <strong>@{{ header.text.toUpperCase() }}</strong>
                          </template>
                        @endforeach
                        <template v-slot:no-data>
                            Tidak ada data ditemukan.
                        </template>
                        <template v-slot:no-results>
                            Tidak ada data ditemukan.
                        </template>
                        <template v-slot:item.due_date="{ item }">
                            <v-text-field
                                v-if="item.payment == 'Akad Kredit'"
                                :readonly="!field_state"
                                :disabled="field_state"
                            ></v-text-field>
                            <v-menu
                                v-else
                                v-model="menu[item]"
                                :close-on-content-click="true"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="290px">
                                <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    :value="reformatDateTime(item.due_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                ></v-text-field>
                                </template>
                                <v-date-picker v-model="item.due_date" @input="menu[item] = false"></v-date-picker>
                            </v-menu>
                        </template>
                        <template v-slot:item.installment="{ item }">
                            <v-text-field
                                v-if="item.payment == 'Uang Tanda Jadi'"
                                :value="item.installment"
                                :hint="'Rp ' + item.installment ? moneyFormat(item.installment) : 0"
                                :persistent-hint="true"
                                :readonly="!field_state"
                                :disabled="field_state"
                            ></v-text-field>
                            <v-text-field
                                v-else-if="item.payment == 'Akad Kredit'"
                                :hint="'Rp ' + item.installment ? moneyFormat(item.installment) : 0"
                                :persistent-hint="true"
                                :value="item.credit"
                                :readonly="!field_state"
                                :disabled="field_state"
                            ></v-text-field>
                            <v-text-field
                                v-else
                                v-model="item.installment"
                                :hint="'Rp ' + item.installment ? moneyFormat(item.installment) : 0"
                                :persistent-hint="true"
                                name="amount"
                                label=""
                                :disabled="field_state"
                                @input="regenerateInstallment()">
                            </v-text-field>
                        </template>
                        <template v-slot:item.credit="{ item }">
                          @{{number_format(item.credit)}}
                        </template>
                        </v-data-table>
                      </v-card-text>
                    </v-card>


                    {{-- <h3 class="mt-4 mb-3">Data Cicilan Unit</h3>
                    <v-simple-table>
                        <template v-slot:default>
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Pembayaran</th>
                                        <th class="text-center">Tgl Jatuh Tempo</th>
                                        <th class="text-center">Total Angsuran</th>
                                        <th class="text-center">Sisa Angsuran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(payment, idx) in unit_installments">
                                        <td class="text-center">@{{idx + 1}}</td>
                                        <td class="text-center">@{{payment.payment}}</td>
                                        <td class="text-center">
                                            <v-text-field
                                                v-if="idx == 0 || payment.payment == 'Akad Kredit'"
                                                :readonly="!field_state"
                                                :disabled="field_state"
                                            ></v-text-field>
                                            <v-menu
                                                v-else
                                                v-model="menu[idx]"
                                                :close-on-content-click="true"
                                                :nudge-right="40"
                                                transition="scale-transition"
                                                offset-y
                                                min-width="290px"
                                            >
                                                <template v-slot:activator="{ on, attrs }">
                                                <v-text-field
                                                        :value="reformatDateTime(payment.due_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
                                                        readonly
                                                        v-bind="attrs"
                                                        v-on="on"
                                                ></v-text-field>
                                                </template>
                                                <v-date-picker v-model="payment.due_date" @input="menu[idx] = false"></v-date-picker>
                                            </v-menu>
                                        </td>
                                        <td>
                                            <v-text-field
                                                v-if="idx == 0"
                                                :value="payment.installment"
                                                :hint="'Rp ' + payment.installment ? moneyFormat(payment.installment) : 0"
                                                :persistent-hint="true"
                                                :readonly="!field_state"
                                                :disabled="field_state"
                                            ></v-text-field>
                                            <v-text-field
                                                v-else-if="payment.payment == 'Akad Kredit'"
                                                :hint="'Rp ' + payment.installment ? moneyFormat(payment.installment) : 0"
                                                :persistent-hint="true"
                                                :value="payment.credit"
                                                :readonly="!field_state"
                                                :disabled="field_state"
                                            ></v-text-field>
                                            <v-text-field
                                                v-else
                                                v-model="payment.installment"
                                                :hint="'Rp ' + payment.installment ? moneyFormat(payment.installment) : 0"
                                                :persistent-hint="true"
                                                name="amount"
                                                label=""
                                                :disabled="field_state"
                                                @input="regenerateInstallment()">
                                            </v-text-field>
                                        </td>
                                        <td class="text-center">@{{moneyFormat(payment.credit)}}</td>
                                    </tr>
                                </tbody>
                            </template>
                    </v-simple-table> --}}

                    
                <v-btn
                class="mt-4"
                outlined 
                :href="redirectUri"
                :disabled="field_state">
                    Kembali
                </v-btn>
                <v-btn
                    class="mt-4 mr-4 white--text"
                    color="primary"
                        elevation="5"
                    :disabled="field_state"
                    :loading="field_state"
                    @click="updateInstallment">
                    Update Cicilan
                    <template v-slot:loader>
                        <span class="custom-loader">
                            <v-icon color="white">mdi-sync</v-icon>
                        </span>
                    </template>
                    </v-btn>
                </form>
            </validation-observer>
        </v-card>

        <v-snackbar
                v-model="formAlert"
                top
                multi-line
                :color="formAlertState"
                elevation="5"
                timeout="6000"
        >
            @{{ formAlertText }}
        </v-snackbar>
</v-container>