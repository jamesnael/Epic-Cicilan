<script>
	import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
	import { required, email, max, min, numeric, between } from 'vee-validate/dist/rules'
	import id from 'vee-validate/dist/locale/id.json'

    var moment = require('moment')

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
		},
		data: function () {
            return {
            	field_state: false,
            	formAlert: false,
	            formAlertText: '',
	            formAlertState: 'info',
	            date: new Date().toISOString().substr(0, 10),
                menu: false,
                modal: false,
                menu2: false,
                menu3: false,
                menu4: false,
                time: null,
	            datepicker: false,
                items_approval: [
                    'Approved',
                    'Pending'
                ],
            	form_data: {
            		booking_id: '',
                    akad_date: '',
                    akad_time: '',
                    location: '',
                    address: '',
                    dokumen_awal: '',
                    approval_client_status: '',
                    approval_developer_status: '',
                    approval_notaris_status: '',
                    akad_sign_date: '',
                    akad_doc_sign_file_name: '',
            	}
        	}
        },
        computed:{
        },
        mounted() {
            this.setData();
        },
        methods: {
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
                                    booking_id:data.id,
                                    client_name:data.client.client_name,
                                    client_mobile_number:data.client.client_mobile_number,
                                    unit_number:data.unit.unit_number + '/' + data.unit.unit_block,
                                    unit_price: this.moneyFormat(data.total_amount),
                                    sales_name:data.sales.user.full_name,
                                    agency_name:data.sales.agency ? data.sales.agency.agency_name : '',
                                    akad_date: data.akad_kpr ? data.akad_kpr.akad_date : '',
                                    akad_time: data.akad_kpr ? data.akad_kpr.akad_time : '',
                                    location: data.akad_kpr ? data.akad_kpr.location : '',
                                    address: data.akad_kpr ? data.akad_kpr.address : '',

                                    dokumen_awal_akad: data.akad_kpr ? data.akad_kpr.akad_doc_file_name : '',
                                    url_dokumen_awal: data.akad_kpr ?  data.akad_kpr.url_akad_doc_file_name : '',

                                    approval_client_status: data.akad_kpr ? data.akad_kpr.approval_client_status : '',
                                    approval_developer_status: data.akad_kpr ? data.akad_kpr.approval_developer_status : '',
                                    approval_notaris_status: data.akad_kpr ? data.akad_kpr.approval_notaris_status : '',
                                    akad_sign_date: data.akad_kpr ? data.akad_kpr.akad_sign_date : '',
                                    dokumen_akhir_akad: data.akad_kpr ? data.akad_kpr.akad_doc_sign_file_name : '',
                                    url_dokumen_akhir: data.akad_kpr ? data.akad_kpr.url_akad_doc_sign_file_name : '',
    		            		} 

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
            postFormData() {
                const data = new FormData(this.$refs['post-form']);

                if (this.dataUri) {
                    data.append("_method", "put");
                    data.append("booking_id", this.form_data.booking_id);
                    data.append("akad_date", this.form_data.akad_date);
                    data.append("akad_time", this.form_data.akad_time);
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
            moneyFormat(number) {
                var decimals = 0;
                var dec_point = ',';
                var thousands_sep = '.';

                var n = !isFinite(+number) ? 0 : +number, 
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    toFixedFix = function (n, prec) {
                        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                        var k = Math.pow(10, prec);
                        return Math.round(n * k) / k;
                    },
                    s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            }
        }
	}
</script>