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
			    		:readonly="field_state">
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
			    		:readonly="field_state">
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
			    		:readonly="field_state">
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
	    		        	:value="reformatDateTime(form_data.submission_date, 'YYYY-MM-DD', 'DD MMMM YYYY')"
	    		            label="Tanggal Pengajuan"
	    		            readonly
	    		            v-bind="attrs"
	    		            v-on="on"
	    		        ></v-text-field>
    		        	</template>
    		        	<v-date-picker name="submission_date" v-model="form_data.submission_date" @input="menu2 = false"></v-date-picker>
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
		    		            v-model="form_data.ktp_pemohon"
	    		              	name="ktp_pemohon">
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
	  		    		            v-model="form_data.ktp_suami_istri"
	  	    		              	name="ktp_suami_istri">
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
	  		    		            v-model="form_data.npwp"
	  	    		              	name="npwp">
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
	  		    		            v-model="form_data.kk"
	  	    		              	name="kk">
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
	  		    		            v-model="form_data.surat_nikah"
	  	    		              	name="surat_nikah">
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
	  		    		            v-model="form_data.rekening_tabungan"
	  	    		              	name="rekening_tabungan">
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
	  		    		            v-model="form_data.slip_gaji"
	  	    		              	name="slip_gaji">
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
	  		    		            v-model="form_data.keterangan_kerja"
	  	    		              	name="keterangan_kerja">
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
	  		    		            v-model="form_data.tabungan_3_bulan_terakhir"
	  	    		              	name="tabungan_3_bulan_terakhir">
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
	  		    		            v-model="form_data.rekening_koran"
	  	    		              	name="rekening_koran">
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
	  		    		            v-model="form_data.siup"
	  	    		              	name="siup">
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
	  		    		            v-model="form_data.tdp"
	  	    		              	name="tdp">
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
	  		    		            v-model="form_data.akta"
	  	    		              	name="akta">
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
	  		    		            v-model="form_data.pengesahan"
	  	    		              	name="pengesahan">
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
	  		    		            v-model="form_data.izin_praktek"
	  	    		              	name="izin_praktek">
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
	  		    		            v-model="form_data.sk_domisili"
	  	    		              	name="sk_domisili">
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
	  		    		            v-model="form_data.keterangan_usaha"
	  	    		              	name="keterangan_usaha">
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
	  		    		            v-model="form_data.spt"
	  	    		              	name="spt">
  	    		              	</v-file-input>
	    		          </td>
    		            </tr>
    		          </tbody>
    		        </template>
    		    </v-simple-table>
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