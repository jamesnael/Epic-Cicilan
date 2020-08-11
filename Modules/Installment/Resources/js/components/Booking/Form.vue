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
			filter_unit: {
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
	            date: new Date().toISOString().substr(0, 10),
	            menu: false,
			    modal: false,
	            datepicker: false,
            	form_data: {
            		unit_id: '',
            		client_id: '',
            		total_amount: '',
            		ppn: '',
            		payment_type: '',
            		payment_method: '',
            		dp_amount: '',
            		first_payment: '',
            		principal: '',
            		installment: '',
            		installment_time: '',
            		due_date: '',
            		amount:'',
            		credits: '',
            		payment_method_utj: '',
            		bank_name: '',
            		card_number: '',
            		point: ''
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
    		            			unit_id: data.unit_id,
    		            			client_id: data.client_id,
    		            			total_amount: data.total_amount,
    		            			ppn: data.ppn,
    		            			payment_type: data.payment_type,
    		            			payment_method: data.payment_method,
    		            			dp_amount: data.dp_amount,
    		            			first_payment: data.first_payment,
    		            			principal: data.principal,
    		            			installment: data.installment,
    		            			installment_time: data.installment_time,
    		            			due_date: data.due_date,
    		            			credits: data.credits,
    		            			amount: data.amount,
    		            			payment_method_utj: data.payment_method_utj,
    		            			bank_name: data.bank_name,
    		            			card_number: data.card_number,
    		            			point: data.point
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
		    setSelectedUnit() {
				let unit = _.find(this.filter_unit, o => { return o.unit_id == this.form_data.unit_id})
				if (_.isUndefined(unit)) {
					this.form_data.unit_number = ''
					this.form_data.unit_block = ''
					this.form_data.unit_type = ''
					this.form_data.surface_area = ''
					this.form_data.building_area = ''
				} else {
					this.form_data.unit_number = unit.unit_number
					this.form_data.blok_number = unit.blok_number
					this.form_data.unit_type = unit.unit_type
					this.form_data.surface_area = unit.surface_area
					this.form_data.building_area = unit.building_area
				}
			},
        }
	}
</script>