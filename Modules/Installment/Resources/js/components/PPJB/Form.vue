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
			filter_client: {
			    type: Array,
			    default: function () {
			        return []
			    }
			},
			filter_sales: {
			    type: Array,
			    default: function () {
			        return []
			    }
			},			
		},
		data: function () {
            return {
            	field_state: false,
            	formAlert: false,
	            formAlertText: '',
	            formAlertState: 'info',
                cancel_reason:'',
                dialog:false,
                menu: false,
                modal: false,
                modal2: false,
                menu2: false,
                menu3: false,
                menu4: false,
                time: null,
                datepicker: false,
            	
                files: [
                    {
                        title: 'Document PPJB',
                        file_name: 'ppjb_doc_file_name',
                        url: '',
                        showcase: ''
                    },
                    {
                        title: 'Document PPJB Sudah Ditandatangani',
                        file_name: 'ppjb_doc_sign_name',
                        url: '',
                        showcase: ''
                    },
                ],
                form_data: {
            		client_name:'',
                    phone_number:'',
                    unit:'',
                    unit_price:'',
                    status_ppjb: '',
                    ppjb_sign_date:new Date().toISOString().substr(0, 10),
                    sales_name:'',
                    agent_name:'',
                    ppjb_date:new Date().toISOString().substr(0, 10),
                    ppjb_time:'',
                    location:'',
                    address:'',
                    approval_client_status:'',
                    approval_developer_status:'',
                    approval_notaris_status:'',
                    url_file_doc:'',
                    url_file_doc_sign:'',
                    booking_id:'',
            	}
        	}
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
    		            		this.form_data = {
                                    slug: data.slug,
                                    client_name: data.client.client_name,
                                    phone_number: data.client.client_phone_number,
                                    unit: data.unit.unit_number + '/' + data.unit.unit_block,
                                    unit_type: data.unit.unit_type + ' ' + data.unit.unit_number + '/' + data.unit.unit_block,
                                    unit_price: data.total_amount ,
                                    sales_name: data.sales.user.full_name,
                                    agent_name: data.sales.agency.agency_name,
                                    booking_id: data.document.booking_id,
                                    ppjb_date: data.document.submission_date,
                                    ppjb_doc_file_name: data.ppjb ? data.ppjb.ppjb_doc_file_name : '',
                                    ppjb_doc_sign_file_name: data.ppjb ? data.ppjb.ppjb_doc_sign_file_name : '',
                                    address: data.ppjb ? data.ppjb.address : '',
                                    location: data.ppjb ? data.ppjb.location : '' ,
                                    ppjb_time: data.ppjb ? data.ppjb.ppjb_time : '',
                                    approval_client_status: data.ppjb ? data.ppjb.approval_client_status : '',
                                    approval_notaris_status: data.ppjb ? data.ppjb.approval_notaris_status : '',
                                    approval_developer_status: data.ppjb ? data.ppjb.approval_developer_status : '',
                                    ppjb_sign_date: data.ppjb ? data.ppjb.ppjb_sign_date : '',
    		            		    ppjb_sign_date_data: data.ppjb ? data.ppjb.ppjb_sign_date : '',
                                    url_file_doc: data.ppjb ? data.ppjb.url_file_doc : '    ',
                                    url_file_doc_sign: data.ppjb ? data.ppjb.url_file_doc_sign : '',
                                }
                                this.unit_price = data.total_amount
            

                               
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
                    ppjb_date: '',
                    ppjb_time: '',
                    location: '',
                    address: '',
                    status_ppjb: '',
                    approval_client_status:'',
                    approval_developer_status:'',
                    approval_notaris_status: '',
                    ppjb_doc_file_name: '',
                    ppjb_doc_sign_file_name:'',
                    ppjb_sign_date:'',
                    booking_id:'',
                    url_file_doc:'',
                    url_file_doc_sign:'',
                    
                }
                this.$refs.observer.reset()
            },
            postFormData() {
                const data = new FormData(this.$refs['post-form']);
                data.append("booking_id", this.form_data.booking_id);
                if (this.dataUri) {
                    data.append("_method", "put");
                    data.append("ppjb_sign_date", this.form_data.ppjb_sign_date);
                    data.append("ppjb_date", this.form_data.ppjb_date);
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


        	showFormattedDt(dt) {
                return moment(dt, "YYYY-MM-DD").format("DD-MMM-YYYY")
            },
            cancelPpjb () {
                const data = new FormData(this.$refs['put-form']);
                data.append("_method", "put");
                data.append("reject_reason", this.cancel_reason);

                axios.post(this.base_url() + this.ziggy('ppjb.cancel', [this.form_data.slug]).url(), data)
                    .then((response) => {
                        if (response.data.success) {
                            this.formAlert = true
                            this.formAlertState = 'success'
                            this.formAlertText = response.data.message

                            setTimeout(() => {
                                this.goto(this.redirectUri);
                            }, 3000);

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