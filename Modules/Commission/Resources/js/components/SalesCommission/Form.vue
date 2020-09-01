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
			pph21: {
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
	            datepicker: false,
	            menu4: false,
	            menu3: false,
	            menu2: false,
	            form_data: {
        			client_name: '',
        			unit_type: '',
        		}

        	}
        },
        computed:{
            commission_1: function() {
            	let total_unit_price = _.toString(this.form_data.unit_price).split('.').join('')
                let commission = (parseInt(total_unit_price) * parseInt(this.form_data.agency_commission)) / 100;
                let pph_21 = commission * parseInt(this.pph21) / 100;
                let pph_final_result = commission * parseInt(this.form_data.pph_final) / 100;
                let result = commission - pph_final_result - pph_21
                return result.toFixed();  
            },
            commission_2: function() {
            	let total_unit_price = _.toString(this.form_data.unit_price).split('.').join('')
                let commission = (parseInt(total_unit_price) * parseInt(this.form_data.agency_commission)) / 100;
                let pph_21 = commission * parseInt(this.pph21) / 100;
                let pph_final_result = commission * parseInt(this.form_data.pph_final) / 100;
                let result = commission - pph_final_result - pph_21
                return result.toFixed();  
            },
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
    		            			client_name: data.client.client_name,
    		            			unit_type: data.unit.unit_type,
    		            			unit_number: data.unit.unit_number +' / '+ data.unit.unit_block,
    		            			sales_name: data.sales.user.full_name,
    		            			unit_price: data.total_amount,
    		            			payment_method: data.payment_method,
    		            			agency_name: data.sales.agency.agency_name,
    		            			agency_commission: data.sales.agency.agency_commission,
    		            			closing_fee: data.unit.closing_fee,
    		            			korut_name: data.sales.main_coordinator.full_name,
    		            			korwil_name: data.sales.regional_coordinator.full_name,
    		            			pph_final: data.sales.agency.pph_final,
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
		        	sales_commission: '',
            		agency_commission: '',
            		regional_coordinator_commission: '',
            		main_coordinator_commission: '',
		        }
		        this.$refs.observer.reset()
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
		    }
        }
	}
</script>