<script>
	import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
	import { required, email, max, numeric, between } from 'vee-validate/dist/rules'
	import id from 'vee-validate/dist/locale/id.json'

	extend('required', required)
	extend('email', email)
	extend('max', max)
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
			filter_category: {
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
            filter_client: {
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
	            switchStatus: true,
	            regional_coordinator: false,
	            main_coordinator: false,
	            agency: false,
	            sales: false,
        		menu3: false,
	            menu4: false,
	            listStatus:['All', 'Lunas', 'Belum Lunas'],
	            // listLaporan:['Pembayaran Cicilan', 'Komisi', 'Point Reward'],
	            listLaporan:['Pembayaran Cicilan'],
            	form_data: {
            		category_reward_id: '',
            		reward_name: '',
            		kuota: '',
            		description: '',
            		status: '',
            		redeem_point_main_coordinator: '',
            		redeem_point_regional_coordinator: '',
            		redeem_point_agency: '',
            		redeem_point_sales: '',
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
                                    client_name: data.client.client_name,
    		            			sales: (data.redeem_point_sales != null) ? true : false,
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
        	clear () {
		        this.form_data = {
		        	category_reward_id: '',
            		reward_name: '',
            		description: '',
            		status: '',
            		redeem_point_main_coordinator: '0',
            		redeem_point_regional_coordinator: '0',
            		redeem_point_agency: '0',
            		redeem_point_sales: '0',
		        }
		        this.$refs.observer.reset()
		    },
		    setSelectedSales() {
                let sales = _.find(this.filter_sales, o => { return o.value == this.form_data.user_name})
                if (_.isUndefined(sales)) {
                    this.form_data.sales_name = ''
                    this.form_data.agency_name = ''
                    this.form_data.agency_name = ''
                } else {
                    this.form_data.sales_name = sales.text
                    this.form_data.agency_name = sales.agency_name
                    this.form_data.regional_coordinator = sales.regional_coordinator
                    console.log(sales);
                }
            },
		    postFormData() {
		    	console.log('a')
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
		    }
        }
	}
</script>