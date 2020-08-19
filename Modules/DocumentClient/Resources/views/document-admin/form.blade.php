<v-container fluid>
    <v-card flat>
    	<validation-observer ref="observer" v-slot="{ validate, reset }">
	    	<form method="post" id="formEl" enctype="multipart/form-data" ref="post-form">
	    		<validation-provider v-slot="{ errors }" name="Klien" rules="required">
		    		<v-select
		    			class="mt-4"
		    			v-model="form_data.client_id" 
		    			@input="setSelectedClient()"
		              	:items="filter_client"
		              	label="Klien"
		              	name="client_id"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-select>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="" rules="">
		    		<v-text-field
		    			class="mt-4"
		    			v-model="form_data.profession"
			    		label="Pekerjaan"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state">
	    			</v-text-field>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="" rules="">
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
	    		        	:value="computedDateFormattedMomentjs"
	    		            v-model="form_data.submission_date"
	    		            label="Tanggal Pengajuan"
	    		            readonly
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
    		        	</template>
    		        	<v-date-picker v-model="form_data.submission_date" @input="menu2 = false"></v-date-picker>
    		      	</v-menu>
    		    </validation-provider>
				<h3 class="m-4">Upload Dokumen</h3>
    		    <v-simple-table>
    		        <template v-slot:default>
    		          <thead>
    		            <tr>
    		              <th class="text-left">#</th>
    		              <th class="text-left">Nama Dokumen</th>
    		              <th class="text-left">File Upload</th>
    		            </tr>
    		          </thead>
    		          <tbody>
    		            <tr>
    		              <td>1</td>
    		              <td>Fotocopy KTP Pemohon</td>
    		              <td>
	    		              <v-file-input 
		    		            show-size 
		    		            chips 
		    		            counter 
		    		            multiple 
		    		            label="File input"
		    		            v-model="form_data.file_ktp_pemohon"
	    		              	name="file_ktp_pemohon">
	    		              </v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>2</td>
    		              <td>Fotocopy KTP Suami/Istri</td>
    		              <td>
  	    		              	<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_ktp_suami_istri"
	  	    		              	name="file_ktp_suami_istri">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>3</td>
    		              <td>Fotocopy NPWP</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_npwp"
	  	    		              	name="file_npwp">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>4</td>
    		              <td>Fotocopy Kartu Keluarga</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_kk"
	  	    		              	name="file_kk">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>5</td>
    		              <td>Fotocopy Buku Nikah</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_surat_nikah"
	  	    		              	name="file_surat_nikah">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>6</td>
    		              <td>Fotocopy Rekening Tabungan</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_rekening_tabungan"
	  	    		              	name="file_rekening_tabungan">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>7</td>
    		              <td>Asli Slip Gaji (3 Bln Terakhir)</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_slip_gaji"
	  	    		              	name="file_slip_gaji">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>8</td>
    		              <td>Surat Keterangan Kerja</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_izin_praktek"
	  	    		              	name="file_izin_praktek">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>9</td>
    		              <td>Fotocopy R/K Tab.3 bln Terakhir</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_rekening_tabungan"
	  	    		              	name="file_rekening_tabungan">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>10</td>
    		              <td>Rek. Koran 6 Bln Bagi Pengusaha</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_rekening_koran"
	  	    		              	name="file_rekening_koran">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>11</td>
    		              <td>Fotocopy SIUP</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_siup"
	  	    		              	name="file_siup">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>12</td>
    		              <td>Fotocopy TDP/NIB</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_tdp"
	  	    		              	name="file_tdp">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>13</td>
    		              <td>Fotocopy Akte Pendirian/Perubahan</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_akta"
	  	    		              	name="file_akta">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>14</td>
    		              <td>Fotocopy Akte Pengesahan Menkeh</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_pengesahan"
	  	    		              	name="file_pengesahan">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>15</td>
    		              <td>Fotocopy Izin Praktek</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_izin_praktek"
	  	    		              	name="file_izin_praktek">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>16</td>
    		              <td>SK Domisili</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_sk_domisili"
	  	    		              	name="file_sk_domisili">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>17</td>
    		              <td>Surat Keterangan Usaha/Sewa</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_keterangan_usaha"
	  	    		              	name="file_keterangan_usaha">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		            <tr>
    		              <td>18</td>
    		              <td>SPT</td>
    		              <td>
    		              		<v-file-input 
	  		    		            show-size 
	  		    		            chips 
	  		    		            counter 
	  		    		            multiple 
	  		    		            label="File input"
	  		    		            v-model="form_data.file_spt"
	  	    		              	name="file_spt">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		          </tbody>
    		        </template>
    		      </v-simple-table>
					
    		    {{-- @if (!empty(\Auth::user()))
	    		@if (!empty(\Auth::user()->role_id == '1')) --}}
    		    <validation-provider v-slot="{ errors }" name="Persetujuan kantor agency" rules="required">
		    		<v-select
		    			class="mt-4"
		    			v-model="form_data.approval_agent" 
		              	:items="['Pending', 'Approved']"
		              	label="Persetujuan Kantor Agency"
		              	name="approval_agent"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-select>
	    		</validation-provider>
	    		<validation-provider v-slot="{ errors }" name="Persetujuan Developer" rules="required">
		    		<v-select
		    			class="mt-4"
		    			v-model="form_data.approval_developer" 
		              	:items="['Pending', 'Approved']"
		              	label="Persetujuan Developer"
		              	name="approval_developer"
			    		hint="* harus diisi"
			    		:persistent-hint="true"
			    		:error-messages="errors"
			    		:readonly="field_state"
		            ></v-select>
	    		</validation-provider>
		    	{{-- @endif
	    		@endif --}}
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
</v-container>