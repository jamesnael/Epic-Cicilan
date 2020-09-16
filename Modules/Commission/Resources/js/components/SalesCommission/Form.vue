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
	            menu2: false,
	            menu3: false,
	            menu4: false,
	            menu5: false,
	            menu6: false,
	            menu7: false,
	            menu8: false,
                menu9: false,
                menu10: false,
                menu11: false,
                menu12: false,
	            form_data: {
		            payment_date_1: '',
		            payment_date_2: '',
                    korwil_payment_date_1: '',
                    korwil_payment_date_2: '',
                    korut_payment_date_1: '',
                    korut_payment_date_2: '',
		            sales_payment_date: '',
		            agency_payment_date: '',
		            korwil_payment_date: '',
		            korut_payment_date: '',
		           	// sales_name: '',
        			// agency_commission: '',
		         //    commission_1: '',
		         //   	invoice_commission_1: '',
		         //    commission_2: '',
		         //   	invoice_commission_2: '',
		         //    sales_id: '',
		         //    closing_fee_sales: '',
		         //   	sales_bank_name: '',
		         //   	sales_no_rek: '',
		         //   	sales_bank_account: '',
		         //   	sales_invoice: '',
		         //    agency_id: '',
		         //   	agency_name: '',
		         //    closing_fee_agency: '',
		         //   	agency_invoice: '',
		         //    korwil_id: '',
		         //   	korwil_name: '',
		         //    closing_fee_korwil: '',
		         //   	korwil_invoice: '',
		         //    korut_id: '',
		         //   	korut_name: '',
		         //    closing_fee_korut: '',
		         //   	korut_invoice: '',
        		}
        	}
        },
        computed:{
            commission_1: function() {
            	let total_unit_price = _.toString(this.form_data.unit_price).split('.').join('')
                let commission = (parseInt(total_unit_price) * parseInt(this.form_data.agency_commission)) / 100;
                let pph_21 = commission * parseInt(this.form_data.pph_21) / 100;
                let pph_final_result = commission * parseInt(this.form_data.pph_final) / 100;
                let result = (commission - pph_final_result - pph_21) / 2 ;
                return result.toFixed();  
            },
            commission_2: function() {
            	let total_unit_price = _.toString(this.form_data.unit_price).split('.').join('')
                let commission = (parseInt(total_unit_price) * parseInt(this.form_data.agency_commission)) / 100;
                let pph_21 = commission * parseInt(this.form_data.pph_21) / 100;
                let pph_final_result = commission * parseInt(this.form_data.pph_final) / 100;
                let result = (commission - pph_final_result - pph_21) / 2 ;
                return result.toFixed();  
            },
            bruto_commission: function() {
                let total_unit_price = _.toString(this.form_data.unit_price).split('.').join('')
                let commission = (parseInt(total_unit_price) * parseInt(this.form_data.agency_commission)) / 100;
                let pph_21 = commission * parseInt(this.form_data.pph_21) / 100;
                let pph_final_result = commission * parseInt(this.form_data.pph_final) / 100;
                let result = commission - pph_final_result - pph_21;
                return result.toFixed();  
            },

            //Korwil
            korwil_commission_1: function() {
                let total_unit_price = _.toString(this.form_data.unit_price).split('.').join('')
                let commission = (parseInt(total_unit_price) * parseInt(this.form_data.korwil_commission)) / 100;
                let pph_21 = commission * parseInt(this.form_data.pph_21) / 100;
                let pph_final_result = commission * parseInt(this.form_data.korwil_pph_final) / 100;
                let result = (commission - pph_final_result - pph_21) / 2 ;
                return result.toFixed();  
            },
            korwil_commission_2: function() {
                let total_unit_price = _.toString(this.form_data.unit_price).split('.').join('')
                let commission = (parseInt(total_unit_price) * parseInt(this.form_data.korwil_commission)) / 100;
                let pph_21 = commission * parseInt(this.form_data.pph_21) / 100;
                let pph_final_result = commission * parseInt(this.form_data.korwil_pph_final) / 100;
                let result = (commission - pph_final_result - pph_21) / 2 ;
                return result.toFixed();  
            },
            korwil_bruto_commission: function() {
                let total_unit_price = _.toString(this.form_data.unit_price).split('.').join('')
                let commission = (parseInt(total_unit_price) * parseInt(this.form_data.korwil_commission)) / 100;
                let pph_21 = commission * parseInt(this.form_data.pph_21) / 100;
                let pph_final_result = commission * parseInt(this.form_data.korwil_pph_final) / 100;
                let result = commission - pph_final_result - pph_21;
                return result.toFixed();  
            },

            //Korut
            korut_commission_1: function() {
                let total_unit_price = _.toString(this.form_data.unit_price).split('.').join('')
                let commission = (parseInt(total_unit_price) * parseInt(this.form_data.korut_commission)) / 100;
                let pph_21 = commission * parseInt(this.form_data.pph_21) / 100;
                let pph_final_result = commission * parseInt(this.form_data.korut_pph_final) / 100;
                let result = (commission - pph_final_result - pph_21) / 2 ;
                return result.toFixed();  
            },
            korut_commission_2: function() {
                let total_unit_price = _.toString(this.form_data.unit_price).split('.').join('')
                let commission = (parseInt(total_unit_price) * parseInt(this.form_data.korut_commission)) / 100;
                let pph_21 = commission * parseInt(this.form_data.pph_21) / 100;
                let pph_final_result = commission * parseInt(this.form_data.korut_pph_final) / 100;
                let result = (commission - pph_final_result - pph_21) / 2 ;
                return result.toFixed();  
            },
            korut_bruto_commission: function() {
                let total_unit_price = _.toString(this.form_data.unit_price).split('.').join('')
                let commission = (parseInt(total_unit_price) * parseInt(this.form_data.korut_commission)) / 100;
                let pph_21 = commission * parseInt(this.form_data.pph_21) / 100;
                let pph_final_result = commission * parseInt(this.form_data.korut_pph_final) / 100;
                let result = commission - pph_final_result - pph_21;
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
    		            			booking_id: data.id,
    		            			client_name: data.client.client_name,
    		            			unit_type: data.unit.unit_type,
    		            			unit_number: data.unit.unit_number +' / '+ data.unit.unit_block,
    		            			sales_name: data.sales.user.full_name,
    		            			unit_price: data.total_amount,
    		            			payment_method: data.payment_method,
                                    payment_type: data.payment_type,
    		            			agency_name: data.sales.agency.agency_name,
                                    korwil_name: data.sales.regional_coordinator.full_name,
                                    korut_name: data.sales.main_coordinator.full_name,
    		            			agency_commission: data.sales.agency.agency_commission,
                                    korwil_commission: data.sales.agency.regional_coordinator_commission,
                                    korut_commission: data.sales.agency.main_coordinator_commission,
    		            			closing_fee: data.unit.closing_fee,
    		            			korut_name: data.sales.main_coordinator.full_name,
    		            			korwil_name: data.sales.regional_coordinator.full_name,
    		            			pph_final: data.sales.agency.pph_final,
                                    korwil_pph_final: data.sales.regional_coordinator.pph_final,
                                    korut_pph_final: data.sales.main_coordinator.pph_final,

                                    pph_21: data.sales.agency.pph_21,
                                    korwil_pph_21: data.sales.regional_coordinator.pph_21,
                                    korut_pph_21: data.sales.main_coordinator.pph_21,
                                    pph_23: data.sales.agency.pph_23,
                                    korwil_pph_23: data.sales.regional_coordinator.pph_23,
                                    korut_pph_23: data.sales.main_coordinator.pph_23,

                                    prosentase_komisi: data.prosentase_komisi,

    		            			agency_id: data.sales.agency_id,
    		            			sales_id: data.sales_id,
    		            			korwil_id: data.sales.regional_coordinator_id,
    		            			korut_id: data.sales.main_coordinator_id,
    					            
                                    payment_date_1: data.commission ? data.commission.payment_date_1 : '',
    					           	invoice_commission_1: data.commission ? data.commission.invoice_commission_1 : '',
    					            payment_date_2: data.commission ? data.commission.payment_date_2 : '',
    					           	invoice_commission_2: data.commission ? data.commission.invoice_commission_2 : '',
                                    korwil_payment_date_1: data.commission ? data.commission.korwil_payment_date_1 : '',
                                    korwil_invoice_commission_1: data.commission ? data.commission.korwil_invoice_commission_1 : '',
                                    korwil_payment_date_2: data.commission ? data.commission.korwil_payment_date_2 : '',
                                    korwil_invoice_commission_2: data.commission ? data.commission.korwil_invoice_commission_2 : '',
                                    korut_payment_date_1: data.commission ? data.commission.korut_payment_date_1 : '',
                                    korut_invoice_commission_1: data.commission ? data.commission.korut_invoice_commission_1 : '',
                                    korut_payment_date_2: data.commission ? data.commission.korut_payment_date_2 : '',
                                    korut_invoice_commission_2: data.commission ? data.commission.korut_invoice_commission_2 : '',

    					           	sales_bank_name: data.commission ? data.commission.sales_bank_name : '',
    					            closing_fee_sales: data.commission ? data.commission.closing_fee_sales : '',
    					           	sales_no_rek: data.commission ? data.commission.sales_no_rek : '',
    					           	sales_bank_account: data.commission ? data.commission.sales_bank_account : '',
    					            sales_payment_date: data.commission ? data.commission.sales_payment_date : '',
    					           	sales_invoice: data.commission ? data.commission.sales_invoice : '',
    					            closing_fee_agency: data.commission ? data.commission.closing_fee_agency : '',
    					            agency_payment_date: data.commission ? data.commission.agency_payment_date : '',
    					           	agency_invoice: data.commission ? data.commission.agency_invoice : '',
    					            closing_fee_korwil: data.commission ? data.commission.closing_fee_korwil : '',
    					            korwil_payment_date: data.commission ? data.commission.korwil_payment_date : '',
    					           	korwil_invoice: data.commission ? data.commission.korwil_invoice : '',
    					            closing_fee_korut: data.commission ? data.commission.closing_fee_korut : '',
    					            korut_payment_date: data.commission ? data.commission.korut_payment_date : '',
    					           	korut_invoice: data.commission ? data.commission.korut_invoice : '',

    					           	payment_proof_1: data.commission ? data.commission.payment_proof_1 : '',
    					           	payment_proof_2: data.commission ? data.commission.payment_proof_2 : '',
                                    korwil_payment_proof_1: data.commission ? data.commission.korwil_payment_proof_1 : '',
                                    korwil_payment_proof_2: data.commission ? data.commission.korwil_payment_proof_2 : '',
                                    korut_payment_proof_1: data.commission ? data.commission.korut_payment_proof_1 : '',
                                    korut_payment_proof_2: data.commission ? data.commission.korut_payment_proof_2 : '',

    					           	sales_evidence: data.commission ? data.commission.sales_evidence : '',
    					           	agency_evidence: data.commission ? data.commission.agency_evidence : '',
    					           	korwil_evidence: data.commission ? data.commission.korwil_evidence : '',
                                    korut_evidence: data.commission ? data.commission.korut_evidence : '',

                                    url_payment_proof_one: data.commission ? data.commission.url_payment_proof_one : '',
                                    url_payment_proof_two: data.commission ? data.commission.url_payment_proof_two : '',
                                    url_sales_evidence: data.commission ? data.commission.url_sales_evidence : '',
                                    url_agency_evidence: data.commission ? data.commission.url_agency_evidence : '',
                                    url_korwil_evidence: data.commission ? data.commission.url_korwil_evidence : '',
                                    url_korut_evidence: data.commission ? data.commission.url_korut_evidence : '',
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
	    		    data.append("booking_id", this.form_data.booking_id);
	    		    data.append("agency_id", this.form_data.agency_id);
                    data.append("sales_id", this.form_data.sales_id);
                    data.append("payment_date_1", this.form_data.payment_date_1 ? this.form_data.payment_date_1 : '' );
                    data.append("payment_date_2", this.form_data.payment_date_2 ? this.form_data.payment_date_2 : '');
                    data.append("korwil_payment_date_1", this.form_data.korwil_payment_date_1 ? this.form_data.korwil_payment_date_1 : '' );
                    data.append("korwil_payment_date_2", this.form_data.korwil_payment_date_2 ? this.form_data.korwil_payment_date_2 : '');
                    data.append("korut_payment_date_1", this.form_data.korut_payment_date_1 ? this.form_data.korut_payment_date_1 : '' );
                    data.append("korut_payment_date_2", this.form_data.korut_payment_date_2 ? this.form_data.korut_payment_date_2 : '');
                    data.append("sales_payment_date", this.form_data.sales_payment_date ? this.form_data.sales_payment_date : '');
                    data.append("agency_payment_date", this.form_data.agency_payment_date ? this.form_data.agency_payment_date : '');
                    data.append("korwil_payment_date", this.form_data.korwil_payment_date  ? this.form_data.korwil_payment_date : '');
                    data.append("korut_payment_date", this.form_data.korut_payment_date ? this.form_data.korut_payment_date : '');
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