<v-container fluid>
    <v-card flat>
      <validation-observer ref="observer" v-slot="{ validate, reset }">
        <form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
          <h3>Informasi Data Klien</h3>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  v-model="form_data.client_name"
                  name="client_name"
                  label="Nama Klien"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  v-model="form_data.client_number"
                  label="ID Klien"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  v-model="form_data.client_mobile_number"
                  name="client_name"
                  label="Nomor Handphone"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  v-model="form_data.client_phone_number"
                  label="Nomor Telepon"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  v-model="form_data.client_email"
                  label="Email"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
                <v-col
                cols="12"
                md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  v-model="form_data.client_address"
                  label="Alamat Klien"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          

          <h3 class="mt-4">Informasi Data Unit</h3>
          <validation-provider v-slot="{ errors }" name="Tipe rumah" rules="required|max:255">
            <v-text-field
              v-model="form_data.unit_type"
              name="unit_type"
              label="Tipe Rumah"
              :persistent-hint="true"
              :error-messages="errors"
              readonly>
            </v-text-field>
          </validation-provider>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Blok" rules="required|max:255">
                <v-text-field
                  v-model="form_data.unit_block"
                  name="unit_block"
                  label="Blok"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Nomor unit" rules="required|max:255">
                <v-text-field
                  v-model="form_data.unit_number"
                  name="unit_number"
                  label="Nomor Unit"
                  :persistent-hint="true"
                  :error-messages="errors"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Luas kavling" rules="required|numeric|min:0">
                <v-text-field
                  v-model="form_data.surface_area"
                  name="surface_area"
                  label="Luas Kavling (m2)"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Luas bangunan" rules="required|numeric|min:0">
                <v-text-field
                  v-model="form_data.building_area"
                  name="building_area"
                  label="Luas Bangunan (m2)"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Daya listrik" rules="required|numeric|min:0">
                <v-text-field
                  v-model="form_data.electrical_power"
                  name="electrical_power"
                  label="Daya Listrik (Watt)"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Point" rules="required|numeric|min:0">
                <v-text-field
                  v-model="form_data.points"
                  name="points"
                  label="Point"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Closing fee" rules="required|numeric|min:0">
                <v-text-field
                  v-model="form_data.closing_fee"
                  name="closing_fee"
                  label="Closing Fee"
                  readonly>
                </v-text-field>

              </validation-provider>
            </v-col>
          </v-row>

          <h3 class="mt-6">Informasi Pembayaran</h3>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Metode Pembayaran" rules="required">
                <v-text-field
                  v-model="form_data.payment_method"
                  name="payment_method"
                  label="Metode Pembayaran"
                  :persistent-hint="true"
                  :error-messages="errors"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Tipe pembayaran" rules="required">
                <v-text-field
                  v-model="form_data.payment_type" 
                  label="Tipe Pembayaran"
                  name="payment_type"
                  :persistent-hint="true"
                  :error-messages="errors"
                  readonly
                    ></v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          <v-row>
            <v-col
            cols="12"
            md="6">
              <validation-provider v-slot="{ errors }" name="Total harga" rules="required|numeric|min:0">
                <v-text-field
                  v-model="form_data.total_amount"
                  name="total_amount"
                  label="Total Harga"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Pembayaran pertama" rules="required|numeric|min:0">
                <v-text-field
                  v-model="form_data.first_payment"
                  name="first_payment"
                  label="Pembayaran Pertama"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Principal" rules="required|numeric|min:0">
                <v-text-field
                  v-model="form_data.principal"
                  name="principal"
                  label="Principal"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Cicilan per bulan" rules="required|numeric|min:0">
                <v-text-field
                  v-model="form_data.installment"
                  name="installment"
                  label="Cicilan Per Bulan"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>

          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Tanggal jatuh tempo" rules="required|numeric|min:1">
                <v-text-field
                  v-model="form_data.due_date"
                  name="due_date"
                  label="Tanggal Jatuh Tempo"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Lama cicilan" rules="required|numeric|min:0">
                <v-text-field
                  v-model="form_data.installment_time"
                  name="installment_time"
                  label="Lama Cicilan"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>

          <v-row>
            
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Total DP" rules="required|numeric|min:0">
                <v-text-field
                  v-if="payment_type == 'KPR/KPA'"
                  v-model="form_data.dp_amount"
                  name="dp_amount"
                  label="Total DP"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Kredit" rules="required|numeric|min:0">
                <v-text-field
                  v-if="payment_type == 'KPR/KPA'"
                  v-model="form_data.credits"
                  name="credits"
                  label="Kredit"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>

          <h3 class="mt-4">Data NUP & UTJ</h3>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Total NUP" rules="required|numeric|min:0">
                <v-text-field
                  class="mt-4"
                  v-model="form_data.nup_amount"
                  name="nup_amount"
                  label="Total NUP"
                  :persistent-hint="true"
                  :error-messages="errors"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Metode pembayaran NUP" rules="required">
                <v-text-field
                  class="mt-4"
                  v-model="form_data.payment_method_nup"
                  name="payment_method_nup"
                  label="Metode Pembayaran NUP"
                  :persistent-hint="true"
                  :error-messages="errors"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  class="mt-4"
                  :value="reformatDateTime(form_data.nup_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
                  name="nup_amount"
                  label="Tanggal pembayaran NUP"
                  :persistent-hint="true"
                  :error-messages="errors"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
                cols="12"
                md="6">
              <validation-provider v-slot="{ errors }" name="Total UTJ" rules="required|numeric|min:0">
                <v-text-field
                  class="mt-4"
                  v-model="form_data.utj_amount"
                  name="utj_amount"
                  label="Total UTJ"
                  :persistent-hint="true"
                  :error-messages="errors"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="Metode pembayaran UTJ" rules="required">
                <v-text-field
                  class="mt-4"
                  v-model="form_data.payment_method_utj"
                  name="payment_method_utj"
                  label="Metode Pembayaran UTJ"
                  :persistent-hint="true"
                  :error-messages="errors"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
             <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  class="mt-4"
                  :value="reformatDateTime(form_data.utj_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
                  name="nup_amount"
                  label="Tanggal Pembayaran UTJ"
                  :persistent-hint="true"
                  :error-messages="errors"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          <v-row>
            <v-col
                cols="12"
                md="6">
              <validation-provider v-slot="{ errors }" name="Nama bank" rules="required">
                <v-text-field
                  v-model="form_data.bank_name"
                  name="bank_name"
                  label="Nama Bank"
                  :persistent-hint="true"
                  :error-messages="errors"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
                <v-col
                cols="12"
                md="6">
              <validation-provider v-slot="{ errors }" name="Nomor rekening" rules="required|numeric">
                <v-text-field
                  v-model="form_data.card_number"
                  name="card_number"
                  label="Nomor Rekening"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          
          <h3>Data Sales</h3>
          <v-row>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  v-model="form_data.sales_name"
                  label="Nama Sales"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
            <v-col
              cols="12"
              md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  v-model="form_data.agency_name"
                  label="Nama Sub Agent"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>
          <v-row>
            <v-col
                cols="12"
                md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  v-model="form_data.main_coordinator"
                  label="Koordinator Utama"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
                <v-col
                cols="12"
                md="6">
              <validation-provider v-slot="{ errors }" name="" rules="">
                <v-text-field
                  v-model="form_data.regional_coordinator"
                  label="Koordinator Wilayah"
                  readonly>
                </v-text-field>
              </validation-provider>
            </v-col>
          </v-row>

          <h3 class="mt-4 mb-3">Data Cicilan Unit</h3>
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
                                <v-menu
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
                            <td v-if="idx == 0">@{{payment.installment}}</td>
                              <td v-else>
                                <v-text-field
                                  v-model="payment.installment"
                                  name="amount"
                                  label=""
                                  :disabled="field_state"
                                  @input="regenerateInstallment()">
                                </v-text-field>
                              </td>
                              <td class="text-center">@{{payment.credit}}</td>
                              
                          </tr>
                  </tbody>
                </template>
            </v-simple-table>
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