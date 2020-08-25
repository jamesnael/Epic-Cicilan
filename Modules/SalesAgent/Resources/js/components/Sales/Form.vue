<script>
	import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
	import { required, email, max, numeric, between, image, min } from 'vee-validate/dist/rules'
	import id from 'vee-validate/dist/locale/id.json'

	extend('required', required)
	extend('email', email)
	extend('max', max)
	extend('min', min)
	extend('image', image)
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
			filter_agency: {
			    type: Array,
			    default: function () {
			        return []
			    }
			},
			filter_main_coordinator: {
			    type: Array,
			    default: function () {
			        return []
			    }
			},
			filter_regional_coordinator: {
			    type: Array,
			    default: function () {
			        return []
			    }
			},
			filter_sales_commission: {
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
	            showPassword: false,
            	form_data: {
            		main_coordinator_id:'',
            		regional_coordinator_id:'',
            		agency_id: '',
            		sales_nip:'',
            		file_ktp:'',
            		file_npwp:'',
            		sales_commission:'',
            		agency_commission:'',
            		regional_coordinator_commission:'',
            		main_coordinator_commission:''
            	},
            	form_user: {
            		full_name: '',
            		email: '',
            		password:'',
            		phone_number: '',
            		address: '',
            		province: '',
            		city: '',
            		role_id:''
            	}
        	}
        },
        computed: {
            computedRegionalCoordinator: function () {
            	if (this.form_data.main_coordinator_id) {
            		return _.filter(this.filter_regional_coordinator, (o) => { return o.value == this.form_data.main_coordinator_id })
            	}
            	return []
            },
            computedAgency: function () {
            	if (this.form_data.regional_coordinator_id) {
            		return _.filter(this.filter_agency, (o) => { return o.regional_coordinator_id == this.form_data.regional_coordinator_id })
            	}
            	return []
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
    		            		console.log(data)
    		            		this.form_data = {
    		            			sales_nip: data.sales_nip,
    		            			main_coordinator_id:data.main_coordinator_id,
    		            			sales_commission:data.sales_commission,
    		            			agency_commission:data.agency_commission,
    		            			regional_coordinator_commission:data.regional_coordinator_commission,
    		            			main_coordinator_commission:data.main_coordinator_commission,
    		            			regional_coordinator_id: '',
    		            			agency_id: '',
    		            			file_ktp: data.file_ktp,
    		            			url_file_ktp: data.url_file_ktp,
    		            			file_npwp: data.file_npwp,
    		            			url_file_npwp: data.url_file_npwp,
    		            		}
    		            		
    		            		this.form_user = {
    		            			full_name: data.full_name,
    		            			email: data.email,
    		            			password: '',
    		            			phone_number: data.phone_number,
    		            			address: data.address,
    		            			province: data.province,
    		            			city: data.city,
    		            			role_id: data.role_id
    		            		}
    		            		this.$nextTick(() => {
			            			this.form_data.regional_coordinator_id = data.regional_coordinator_id;

			            			this.$nextTick(() => {
				            			this.form_data.agency_id = data.agency_id;
			            			})
		            			})

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
		        	agency_id: '',
            		sales_nip:'',
		        	pph_final: '',
		        	file_ktp:'',
            		file_npwp:'',
            		main_coordinator_id:'',
            		regional_coordinator_id:'',
            		sales_commission:'',
            		agency_commission:'',
            		regional_coordinator_commission:'',
            		main_coordinator_commission:''
		        }
		        this.form_user = {
		        	full_name: '',
		        	email: '',
		        	password:'',
		        	phone_number: '',
		        	address: '',
		        	province: '',
		        	city: '',
		        	role_id:''
		        }
		        this.$refs.observer.reset()
		    },
		    postFormData() {
	    		const data = new FormData(this.$refs['post-form']);

	    		if (this.dataUri) {
	    		    data.append("_method", "put");
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
		    setSelectedSales() {
				let sales = _.find(this.filter_sales_commission, o => { return o.value == this.form_data.sales_commission})
				console.log(sales)
				if (_.isUndefined(sales)) {
					this.form_data.agency_commission = ''
					this.form_data.main_coordinator_commission = ''
					this.form_data.regional_coordinator_commission = ''
				} else {
					this.form_data.agency_commission = sales.agency_commission
					this.form_data.main_coordinator_commission = sales.main_coordinator_commission
					this.form_data.regional_coordinator_commission = sales.regional_coordinator_commission
				}
			},

        }
	}
</script>