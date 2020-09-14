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
            filter_payment_method: {
                type: Array,
                default: function () {
                    return []
                }
            },  
		},
		data: function () {
            return {
                loader: null,
                overlay: false,
                progressText: 'Mohon Menunggu.',
	            unit_installments: [],
            	field_state: false,
            	formAlert: false,
	            formAlertText: '',
	            formAlertState: 'info',
                modal: false,
                idx:false,
                menu:false,
                menu2:false,
	            datepicker: false,
            	form_data: {
            		unit_type:'',
            		client_name:'',
            		unit_number:'',
            		surface_area:'',
            		building_area:'',
            		utj:'',
            		electrical_power:'',
            		points:'',
            		closing_fee:'',
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
            		point: '',
            		client_id: '',
            		client_name: '',
            		client_email: '',
            		client_phone_number: '',
            		client_mobile_number: '',
            		client_addres: '',
            		sales_id:'',
            		sales_name:'',
            		agency_name:'',
            		main_coordinator:'',
            		regional_coordinator:'',
                    total_pembayaran: 0,
                    sisa_tunggakan: 0,
                    total_denda: 0,
                    prosentase_pembayaran: 0,
                    slug: '',

                    payment_method: '',
                    payment_date: '',
                    total_paid: '',
                    description: '',

                    payments: []
            	},
                paymentMethod:''
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
                                var items = []
                                _.forEach(data.payments, (value, key) => {
                                    value.table_index = parseInt(key) + 1
                                    items.push(value)
                                });

    		            		this.form_data = {
    		            			client_number: data.client.client_number,
                                    client_name: data.client.client_name,
                                    client_mobile_number: data.client.client_mobile_number,
                                    client_email: data.client.client_email,
                                    client_address: data.client.client_address,
                                    sales_name: data.sales.user.full_name,
                                    unit_type: data.unit.unit_type,
                                    unit_block: data.unit.unit_block,
                                    unit_number: data.unit.unit_number,
                                    surface_area: data.unit.surface_area,
                                    building_area: data.unit.building_area,
                                    electrical_power: data.unit.electrical_power,
                                    nup_amount: data.nup_amount,
                                    payment_method_nup: data.payment_method_nup,
                                    nup_date: data.nup_date,
                                    utj_amount: data.utj_amount,
                                    payment_method_utj: data.payment_method_utj,
                                    utj_date: data.utj_date,
                                    payment_type: data.payment_type,
                                    total_amount: data.total_amount,
                                    first_payment: data.first_payment,
                                    principal: data.principal,
                                    installment: data.installment,
                                    installment_time: data.installment_time,
                                    total_pembayaran: data.total_pembayaran,
                                    sisa_tunggakan: data.sisa_tunggakan,
                                    total_denda: data.total_denda,
                                    prosentase_pembayaran: data.prosentase_pembayaran,

                                    sales_id: data.sales_id,
                                    sales_name:data.sales.user.full_name,
                                    agency_name:data.sales.agency ? data.sales.agency.agency_name : '',
                                    main_coordinator:data.sales.main_coordinator ? data.sales.main_coordinator.full_name : '',
                                    regional_coordinator:data.sales.regional_coordinator ? data.sales.regional_coordinator.full_name : '',

                                    payments: items,
                                    slug: data.slug,
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
            postPayment(item) {
                this.$refs.observer.validate().then((success) => {
                    if (!success) {
                      return;
                    }
                    this.field_state = true
                    
                    const data = new FormData(this.$refs['post-form']);

                    data.append("_method", "put");
                    data.append("payment_method", this.form_data.payment_method);
                    data.append("payment_date", this.form_data.payment_date);
                    data.append("total_paid", this.form_data.total_paid);
                    data.append("description", this.form_data.description ? this.form_data.description : '');

                    console.log(data)

                    axios.post(this.base_url() + this.ziggy('manual-payment', [this.form_data.slug, item.slug]).url(), data)
                        .then((response) => {
                            if (response.data.success) {
                                this.formAlert = true
                                this.formAlertState = 'success'
                                this.formAlertText = response.data.message
                                this.field_state = false
                                
                                setTimeout((function() {
                                  window.location.reload();
                                }), 250);
                            } else {
                                this.formAlert = true
                                this.formAlertState = 'error'
                                this.formAlertText = response.data.message
                                this.field_state = false
                            }
                        })
                        .catch((error) => {
                            this.formAlert = true
                            this.formAlertState = 'error'
                            this.formAlertText = 'Oops, something went wrong. Please try again later.'
                            this.field_state = false
                        });
                 });
            },
            setSelectedPayment() {
                let payment = _.find(this.filter_payment_method, o => { return o.value == this.form_data.payment_method_id})
                if (_.isUndefined(payment)) {
                    this.form_data.payment_method = ''
                } else {
                    this.form_data.payment_method = payment.text
                }
            },
        }
	}
</script>