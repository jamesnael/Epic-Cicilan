<script>
	import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
	import { required, email, max, min, numeric, between } from 'vee-validate/dist/rules'
	import id from 'vee-validate/dist/locale/id.json'

	extend('required', required)
	extend('email', email)
	extend('max', max)
	extend('min', min)
	extend('numeric', numeric)
	extend('between', between)
    localize('id', id);

	export default {
		components: {
		    ValidationObserver,
		    ValidationProvider
		},
		props: {
			slug: {
				type: String,
				default: ''
			},
			uri: {
				type: String,
				required: true
			},
			redirectUri: {
				type: String,
				required: true
			},
			dataUri: {
			    type: String,
			    default: ''
			},
			deleteText: {
			    type: String,
			    default: "Delete"
			},
			deleteIcon: {
			    type: String,
			    default: "mdi-trash-can-outline"
			},
			deleteColor: {
			    type: String,
			    default: "red lighten-1"
			},
			deleteConfirmationText: {
			    type: String,
			    default: "Are you sure want to delete this file ?"
			},
			deleteCancelText: {
			    type: String,
			    default: "Cancel"
			},
		},
		data: function () {
            return {
            	promptDelete: false,
            	field_state: false,
            	formAlert: false,
            	deleteLoader: false,
	            formAlertText: '',
	            formAlertState: 'info',
	            menu2: false,
			    modal: false,
            	form_data: {
            		booking_id: '',
            		profession:'',
            		ktp_pemohon:'',
            		submission_date:new Date().toISOString().substr(0, 10),
            	},
            	delete_file_type: '',
        		files: [
        			{
        				title: 'Fotocopy KTP Pemohon',
        				file_name: 'file_ktp_pemohon',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Fotocopy KTP Suami/Istri',
        				file_name: 'file_ktp_suami_istri',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Fotocopy NPWP',
        				file_name: 'file_npwp',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Fotocopy Kartu Keluarga',
        				file_name: 'file_kk',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Fotocopy Buku Nikah',
        				file_name: 'file_surat_nikah',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Fotocopy Rekening Tabungan',
        				file_name: 'file_rekening_tabungan',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Asli Slip Gaji (3 Bln Terakhir)',
        				file_name: 'file_slip_gaji',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Surat Keterangan Kerja',
        				file_name: 'file_keterangan_kerja',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Fotocopy R/K Tab.3 bln Terakhir',
        				file_name: 'file_tabungan_3_bulan_terakhir',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Rek. Koran 6 Bln Bagi Pengusaha',
        				file_name: 'file_rekening_koran',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Fotocopy SIUP',
        				file_name: 'file_siup',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Fotocopy TDP/NIB',
        				file_name: 'file_tdp',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Fotocopy Akte Pendirian/Perubahan',
        				file_name: 'file_akta',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Fotocopy Akte Pengesahan Menkeh',
        				file_name: 'file_pengesahan',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Fotocopy Izin Praktek',
        				file_name: 'file_izin_praktek',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'SK Domisili',
        				file_name: 'file_sk_domisili',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'Surat Keterangan Usaha/Sewa',
        				file_name: 'file_keterangan_usaha',
            			url: '',
            			showcase: ''
            		},
        			{
        				title: 'SPT',
        				file_name: 'file_spt',
            			url: '',
            			showcase: ''
            		}
        		]
        	}
        },
        mounted() {
            this.setData();
        },
        methods: {
        	pairingUploadedUrl(data) {
        		_.forEach(this.files, (file) => {
        			let url_link = 'url_' + file.file_name
				  	file.url = data[url_link] ?? ''
				  	file.showcase = data[file.file_name] ?? ''
				});
        	},
    		setData() {
    			if (this.dataUri) {
    				this.field_state = true

    		        axios
    		            .get(this.dataUri)
    		            .then(response => {
    		            	if (response.data.success) {
    		            		let data = response.data.data
    		            		console.log(data)
    		            		this.form_data = {
    		            			booking_id: data.id,
    		            			slug: data.slug,
    		            			client_name: data.client.client_name,
    		            			client_profession: data.client.profession,
    		            			unit_name: data.unit.unit_number + '/' + data.unit.unit_block,
    		            			unit_price: this.number_format(data.total_amount),
    		            			submission_date: data.document ? data.document.submission_date : '',
    		            		}

    		            		this.pairingUploadedUrl(data.document)

    			                this.field_state = false
    		            	} else {
    		            		this.formAlert = true
		    		            this.formAlertState = 'error'
		    		            this.formAlertText = response.data.message
			    		        this.field_state = false
    		            	}
    		            })
    		            .catch(error => {
    	            		this.tableAlert = true
		                    this.tableAlertState = 'error'
		                    this.tableAlertText = 'Oops, something went wrong. Please try again later.'
		    		        this.field_state = false
    		            });
    			}
    		},
        	submit() {
    			this.$refs.observer.validate().then((success) => {
    				if (!success) {
    		          return;
    		        }

    		        this.postFormData()
    			});
        	},
        	clear () {
		        this.form_data = {
		        	
		        }
		        this.$refs.observer.reset()
		    },
		    postFormData() {
	    		const data = new FormData(this.$refs['post-form']);
	    		if (this.dataUri) {
	    		    data.append("_method", "put");
	    		    data.append("booking_id", this.form_data.booking_id);
	    		    data.append("submission_date", this.form_data.submission_date);
	    		}
	    		
	    		this.field_state = true

	    		axios.post(this.uri, data)
	    		    .then((response) => {
	    		        if (response.data.success) {
	    		            this.formAlert = true
	    		            this.formAlertState = 'success'
	    		            this.formAlertText = response.data.message

	    		            setTimeout(() => {
			                    this.goto(this.redirectUri);
			                }, 6000);
	    		        } else {
	    		            this.formAlert = true
	    		            this.formAlertState = 'error'
	    		            this.formAlertText = response.data.message
		    		        this.field_state = false
	    		        }
	    		    })
	    		    .catch((error) => {
	    		        this.tableAlert = true
	                    this.tableAlertState = 'error'
	                    this.tableAlertText = 'Oops, something went wrong. Please try again later.'
	    		        this.field_state = false
	    		    });
		    },
		    promptDeleteItem(file_name) {
		        this.promptDelete = true
		        this.delete_file_type = file_name
		    },
		    removeUploadedFile () {
		    	const data = new FormData();

		        axios.delete(this.base_url() + this.ziggy('document.remove-file', [this.slug, this.delete_file_type]).url(), data)
		            .then((response) => {
		                if (response.data.success) {
		                    this.formAlert = true
		                    this.formAlertState = 'success'
		                    this.formAlertText = response.data.message
		                } else {
		                    this.formAlert = true
		                    this.formAlertState = 'error'
		                    this.formAlertText = response.data.message
		                }
		                this.deleteLoader = false
		                this.promptDelete = false

		                this.setData()
		            })
		            .catch((error) => {
		                this.formAlert = true
		                this.formAlertState = 'error'
		                this.formAlertText = 'Oops, something went wrong. Please try again later.'

		                this.deleteLoader = false
		                this.promptDelete = false
		            });
		    }
        }
	}
</script>