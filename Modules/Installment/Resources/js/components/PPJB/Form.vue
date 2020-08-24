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
	            date: new Date().toISOString().substr(0, 10),
                menu: false,
                modal: false,
                modal2: false,
                menu2: false,
                menu3: false,
                menu4: false,
                time: null,
                datepicker: false,
            	form_data: {
            		client_name:'',
                    phone_number:'',
                    unit:'',
                    unit_price:'',
                    submission_date:'',
                    sales_name:'',
                    agent_name:'',
                    surat_ppjb_awal:'',
                    ppjb_date:'',
                    time:'',
                    ppjb_place:'',
                    full_address:'',
                    approved_pembeli:'',
                    approved_developer:'',
                    approved_notaris:'',
                    surat_ppjb:'',

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
                                let arr_installment = []
    		            		this.form_data = {
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
        	showFormattedDt(dt) {
                return moment(dt, "YYYY-MM-DD").format("DD-MMM-YYYY")
            },
        }
	}
</script>