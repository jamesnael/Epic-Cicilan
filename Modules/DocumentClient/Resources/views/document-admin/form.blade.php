<v-container fluid>
    <v-card flat>
      <validation-observer ref="observer" v-slot="{ validate, reset }">
        <form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
          <validation-provider v-slot="{ errors }" name="" rules="">
            <v-text-field
              class="mt-4"
              v-model="form_data.client_name"
              label="Nama Klien"
              name="client_name"
              :persistent-hint="true"
              :error-messages="errors"
              :readonly="!field_state"
              :disabled="field_state">
            </v-text-field>
          </validation-provider>
          <validation-provider v-slot="{ errors }" name="" rules="">
            <v-text-field
              class="mt-4"
              v-model="form_data.client_profession"
              label="Pekerjaan"
              name="client_profesion"
              :persistent-hint="true"
              :error-messages="errors"
              :readonly="!field_state"
              :disabled="field_state">
            </v-text-field>
          </validation-provider>
          <validation-provider v-slot="{ errors }" name="" rules="">
            <v-text-field
              class="mt-4"
              v-model="form_data.unit_name"
              label="Unit yang di beli"
              name="unit_name"
              :persistent-hint="true"
              :error-messages="errors"
              :readonly="!field_state"
              :disabled="field_state">
            </v-text-field>
          </validation-provider>
          <validation-provider v-slot="{ errors }" name="" rules="">
            <v-text-field
              class="mt-4"
              v-model="form_data.unit_price"
              label="Harga Unit"
              name="unit_price"
              :persistent-hint="true"
              :error-messages="errors"
              :readonly="!field_state"
              :disabled="field_state">
            </v-text-field>
          </validation-provider>
          <validation-provider v-slot="{ errors }" name="Tanggal pengajuan" rules="required">
              <v-menu
                v-model="menu2"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  class="mt-4"
                  :value="reformatDateTime(form_data.submission_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
                  label="Tanggal Pengajuan"
                  v-bind="attrs"
                  v-on="on"
                  hint="* harus diisi"
                  :persistent-hint="true"
                  :error-messages="errors"
                  :readonly="!field_state"
                  :disabled="field_state">
                ></v-text-field>
                </template>
                <v-date-picker name="submission_date" v-model="form_data.submission_date" @input="menu2 = false" :disabled="field_state"></v-date-picker>
              </v-menu>
          <h3 class="mt-4">Upload Dokumen</h3>
          <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">#</th>
                    <th class="text-left">Nama Dokumen</th>
                    <th class="text-left">File Upload</th>
                    <th class="text-left">File Dokumen</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(el, idx) in files">
                    <td width="5%">@{{idx + 1}}</td>
                    <td width="35%">@{{el.title}}</td>
                    <td width="35%">
                      <v-file-input 
                          show-size 
                          small-chips 
                          counter 
                          multiple 
                          accept="image/*"
                          :label="el.title"
                          :name="'files[][' + el.file_name+ ']'"
                          :disabled="field_state">
                      </v-file-input>
                  </td>
                  <td width="25%">
                    <a :href="el.url" target="_blank">
                      @{{el.showcase}}
                    </a>
                    <div v-if="el.showcase" class="float-right">
                      <v-btn icon small @click.stop="promptDeleteItem(el.file_name)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                    </div>
                  </td>
                  </tr>
                </tbody>
              </template>
          </v-simple-table>
          {{-- <validation-provider v-slot="{ errors }" name="Approval kantor sub agent" rules="">
            <v-select
                v-model="form_data.approval_agent"
                label="Approval Kantor Sub Agent"
                :items="['Approved', 'Pending']"
                name="approval_agent"
                :persistent-hint="true"
                :error-messages="errors"
                :readonly="field_state">
              </v-select>
          </validation-provider> --}}

          <validation-provider v-slot="{ errors }" name="Approval developer" rules="">
            <v-select
                v-model="form_data.approval_developer"
                :items="['Approved', 'Pending']"
                label="Approval Developer"
                name="approval_developer"
                :persistent-hint="true"
                :error-messages="errors"
                :readonly="field_state">
              >
            </v-select>
          </validation-provider>
          <v-btn
            class="mt-5 mr-4 white--text"
            color="primary"
              elevation="5"
            :disabled="field_state"
            :loading="field_state"
            @click="submit">
            Simpan
              <template v-slot:loader>
                    <span class="custom-loader">
                        <v-icon color="white">mdi-sync</v-icon>
                    </span>
                </template>
          </v-btn>
            <v-btn
              class="mt-5"
              outlined 
              :disabled="field_state"
                @click="clear">
                Ulangi
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
    <v-dialog
      v-model="promptDelete"
      persistent
      max-width="550px"
    >
      <v-card>
        <v-card-title>
          <span class="headline"></span>
      </v-card-title>
      <v-card-text>
        <v-row
          align="center"
          justify="center"
            >
          <v-icon size="120" color="yellow darken-2">mdi-alert-rhombus</v-icon>
          <p class="text-md-h6 text-xs-h6 black--text">
            @{{ deleteConfirmationText }}
          </p>
          </v-row>

      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn text :disabled="deleteLoader" @click="promptDelete = !promptDelete">@{{ deleteCancelText }}</v-btn>
          <v-btn
            class="white--text"
              elevation="5"
              color="red"
              :disabled="deleteLoader"
              :loading="deleteLoader"
              @click="removeUploadedFile()"
              >
              <v-icon>@{{ deleteIcon }}</v-icon>
              <span class="hidden-xs-only ml-2">@{{ deleteText }}</span>
              <template v-slot:loader>
                    <span class="custom-loader">
                        <v-icon color="white">@{{ deleteIcon }}</v-icon>
                    </span>
                </template>
          </v-btn>
          </v-card-actions>
      </v-card>
    </v-dialog>
</v-container>