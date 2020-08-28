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
	            unit_handover: [],
            	field_state: false,
            	formAlert: false,
	            formAlertText: '',
	            formAlertState: 'info',
	            date: new Date().toISOString().substr(0, 10),
                menu: false,
                time: '',
                modal: false,
                menu2: false,
                menu3: false,
                menu4: false,
                menu5: false,
	            datepicker: false,
                items_approval: [
                    'Approved',
                    'Pending'
                ],
                files: [
                    {
                        title: 'Surat Hand Over',
                        file_name: 'handover_doc_file_name',
                        url: '',
                        showcase: ''
                    },
                ],
	            unit_handover: [],
            	form_data: {
                    handover_date: new Date().toISOString().substr(0, 10),
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
            		handover: '',
            		time: '',
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
            	}
        	}
        },
        computed:{
        },
        mounted() {
            this.setData();
        },
        methods: {
            setTime(time) {
                this.$refs.menu.save(time)
                this.form_data.time = time
            },
    		setData() {
    			if (this.dataUri) {
    				this.field_state = true
    		        axios
    		            .get(this.dataUri)
    		            .then(response => {
    		            	if (response.data.success) {
    		            		let data = response.data.data
                                console.log(data);
                                let arr_handover = []
    		            		this.form_data = {
                                    booking_id: data.id,
                                    ajb_date: data.ajb ? data.ajb.ajb_date : null,
                                    unit_name: data.unit.unit_number + '/' + data.unit.unit_block,
    		            			unit_type: data.unit.unit_type,
    		            			unit_block: data.unit.unit_block,
    		            			unit_number: data.unit.unit_number,
    		            			closing_fee:this.moneyFormat(data.unit.closing_fee),
    		            			total_amount: this.moneyFormat(data.total_amount),
    		            			payment_type: data.payment_type,
                                    payment_date: data.tanggal_lunas_cicilan,
    		            			payment_method: data.payment_method,
    		            			dp_amount: this.moneyFormat(data.dp_amount),
    		            			first_payment: this.moneyFormat(data.first_payment),
    		            			principal: this.moneyFormat(data.principal),
    		            			handover: this.moneyFormat(data.handover),
    		            			time: data.time,
    		            			due_date: data.due_date,
    		            			credits: this.moneyFormat(data.credits),
    		            			amount: this.moneyFormat(data.amount),
    		            			payment_method_utj: data.payment_method_utj,
    		            			bank_name: data.bank_name,
    		            			card_number: data.card_number,
    		            			point: data.point,
    		            			client_id: data.client_id,
    		            			client_name: data.client.client_name,
    		            			client_number: data.client.client_number,
    		            			client_email: data.client.client_email,
    		            			client_phone_number: data.client.client_phone_number,
    		            			client_mobile_number: data.client.client_mobile_number,
    		            			client_address: data.client.client_address,
    		            			sales_id: data.sales_id,
    		            			sales_name: data.sales.user.full_name,
    		            			agency_name: data.sales.agency.agency_name,
    		            			main_coordinator: data.sales.main_coordinator ? data.sales.main_coordinator.full_name : '',
    		            			regional_coordinator:data.sales.regional_coordinator ? data.sales.regional_coordinator.full_name : '',
                                    handover_date: data.handover ? data.handover.handover_date : null,
                                    time: data.handover ? this.reformatDateTime(data.handover.time, 'HH:mm:ss', 'HH:mm') : null,
                                    location: data.handover ? data.handover.location : null,
                                    address: data.handover ? data.handover.address : null,
                                    handover_doc_file_name: data.handover ? data.handover.handover_doc_file_name : null,
    		            		} 

                                _.forEach(data.payments, (value, key) => {
                                        arr_handover.push({
                                            id: value.id,
                                            payment: value.payment,
                                            due_date: this.showFormattedDt(value.due_date),
                                            handover: this.moneyFormat(value.handover),
                                            credit: this.moneyFormat(value.credit)
                                        })
                                });

                                this.unit_handover = arr_handover

                                this.time = this.reformatDateTime(data.handover.time, 'HH:mm:ss', 'HH:mm') 

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
            postFormData() {
                const data = new FormData(this.$refs['post-form']);
                if (this.dataUri) {
                    data.append("_method", "put");
                    data.append("booking_id", this.form_data.booking_id);
                    data.append("handover_date", this.form_data.handover_date);
                    data.append("time", this.form_data.time);
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
            updatehandover() {
                this.regeneratehandover();

                const data = new FormData(this.$refs['post-form']);

                data.append('unit_handover', JSON.stringify(this.unit_handover))

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
        	regeneratehandover () {
                let new_handover = []
                let credit = _.toString(this.unit_handover[0].credit).split('.').join('')
                let unit_price = parseInt(credit)

                _.forEach(this.unit_handover, (value, key) => {
                    if (key == 0) {
                        new_handover.push({
                            id: value.id,
                            payment: value.payment,
                            due_date: value.due_date,
                            handover: this.moneyFormat(parseInt(_.toString(value.handover).split('.').join(''))),
                            credit: this.moneyFormat(parseInt(_.toString(value.credit).split('.').join('')))
                        })
                    } else {
                        unit_price = unit_price - parseInt(_.toString(value.handover).split('.').join(''))
                        new_handover.push({
                            id: value.id,
                            payment: value.payment,
                            due_date: value.due_date,
                            handover: key == this.form_data.time ? this.moneyFormat(parseInt(_.toString(value.handover).split('.').join('')) + unit_price) : this.moneyFormat(parseInt(_.toString(value.handover).split('.').join(''))),
                            credit: key == this.form_data.time ? 0 : this.moneyFormat(unit_price)
                        })
                    }
                });
                this.unit_handover = new_handover
            },

        }
	}
</script>