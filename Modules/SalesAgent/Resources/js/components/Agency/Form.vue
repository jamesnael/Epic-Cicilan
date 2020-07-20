<script>
	import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
	import { required, email, max, numeric } from 'vee-validate/dist/rules'
	import id from 'vee-validate/dist/locale/id.json'

	extend('required', required)
	extend('email', email)
	extend('max', max)
	extend('numeric', numeric)
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
			}
		},
		data: function () {
            return {
            	field_state: false,
            	formAlert: false,
	            formAlertText: '',
	            formAlertState: 'info',
            	form_data: {
            		agency_name: '',
            		agency_email: '',
            		agency_phone: '',
            		agency_address: '',
            		province: '',
            		city: '',
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
    		            			agency_name: data.agency_name,
    		            			agency_email: data.agency_email,
    		            			agency_phone: data.agency_phone,
    		            			agency_address: data.agency_address,
    		            			province: data.province,
    		            			city: data.city,
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
		        	agency_name: '',
		        	agency_email: '',
		        	agency_phone: '',
		        	agency_address: '',
		        	province: '',
		        	city: '',
		        }
		        this.$refs.observer.reset()
		    },
		    postFormData() {
	    		const data = new FormData();
	    	    data.append("agency_name", this.form_data.agency_name);
	    	    data.append("agency_email", this.form_data.agency_email);
	    	    data.append("agency_phone", this.form_data.agency_phone);
	    	    data.append("agency_address", this.form_data.agency_address);
	    	    data.append("province", this.form_data.province);
	    	    data.append("city", this.form_data.city);
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