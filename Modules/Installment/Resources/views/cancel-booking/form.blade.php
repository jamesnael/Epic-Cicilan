<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
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
                    {{-- <v-col
                        cols="12"
                        md="4">
                        <v-text-field
                            v-model="form_data.electrical_power"
                            label="Daya Listrik (Watt)"
                            :readonly="!field_state"
                            :disabled="field_state">
                        </v-text-field>
                    </v-col> --}}
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
                            label="Principal"
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
    		
	      	<v-btn
	      		class="mt-4"
	      		outlined 
	      		:disabled="field_state"
		      	:href="redirectUri">
		      	Kembali
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