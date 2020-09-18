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
			filter_regional_coordinator: {
			    type: Array,
			    default: function () {
			        return []
			    }
			},
			filter_agency_commission: {
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
            	form_data: {
            		regional_coordinator_id: '',
            		agency_name: '',
            		agency_email: '',
            		agency_phone: '',
            		agency_address: '',
            		province: '',
            		city: '',
            		pph_final: '',
            		id_commission:'0',
            		sales_commission:'0',
            		agency_commission:'0',
            		regional_coordinator_commission:'0',
            		main_coordinator_commission:'0',
            		bank_name: '',
            		rek_number: '',
            		account_name: '',
            		principal: '',
            		no_hp_principal: '',
            		ppn: '',
            		pph_21: '',
            		pph_23: '',
            	}
        	}
        },
        watch: {
        },
        computed: {
            total: function() {
              	var calculate = parseFloat(this.form_data.agency_commission ) + parseFloat(this.form_data.regional_coordinator_commission) + parseFloat(this.form_data.main_coordinator_commission);
              	
              	if (calculate) {
	             	return calculate.toFixed(2)
	             }else{
	             	return '0'
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
    		            			regional_coordinator_id: data.regional_coordinator_id,
    		            			agency_name: data.agency_name,
    		            			agency_email: data.agency_email,
    		            			agency_phone: data.agency_phone,
    		            			agency_address: data.agency_address,
    		            			province: data.province,
    		            			city: data.city,
    		            			pph_final: data.pph_final,
    		            			id_commission:data.id_commission,
    		            			sales_commission:data.sales_commission,
    		            			agency_commission:data.agency_commission,
    		            			regional_coordinator_commission:data.regional_coordinator_commission,
    		            			main_coordinator_commission:data.main_coordinator_commission,
    		            			commission_type:data.commission_type,
    		            			bank_name: data.bank_name,
    		            			rek_number: data.rek_number,
    		            			account_name: data.account_name,
    		            			principal: data.principal,
    		            			no_hp_principal: data.no_hp_principal,
    		            			ppn: data.ppn,
    		            			pph_21: data.pph_21,
    		            			pph_23: data.pph_23,
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
		        	regional_coordinator_id: '',
		        	agency_name: '',
		        	agency_email: '',
		        	agency_phone: '',
		        	agency_address: '',
		        	province: '',
		        	city: '',
		        	pph_final: '',
		        	sales_commission:'',
            		agency_commission:'',
            		regional_coordinator_commission:'',
            		main_coordinator_commission:'',
            		bank_name: '',
            		rek_number: '',
            		account_name: '',
            		principal: '',
            		no_hp_principal: '',
            		ppn: '',
            		pph_21: '',
            		pph_23: '',

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
		    setSelectedAgency() {
				let agency = _.find(this.filter_agency_commission, o => { return o.value == this.form_data.id_commission})
				if (_.isUndefined(agency)) {
					// this.form_data.sales_commission = ''
					this.form_data.commission_type = ''
					this.form_data.agency_commission = ''
					this.form_data.main_coordinator_commission = ''
					this.form_data.regional_coordinator_commission = ''
				} else {
					this.form_data.commission_type = agency.commission_type
					this.form_data.agency_commission = agency.agency_commission
					this.form_data.main_coordinator_commission = agency.main_coordinator_commission
					this.form_data.regional_coordinator_commission = agency.regional_coordinator_commission
				}

			},
        }
	}
</script>