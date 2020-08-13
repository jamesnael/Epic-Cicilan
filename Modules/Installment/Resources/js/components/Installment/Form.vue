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
	            unit_installments: [],

            	field_state: false,
            	formAlert: false,
	            formAlertText: '',
	            formAlertState: 'info',
	            date: new Date().toISOString().substr(0, 10),
	            menu: false,
			    modal: false,
	            datepicker: false,
	            unit_installments: [],
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
    		            		console.log(data.payments)
    		            		this.form_data = {
    		            			unit_type:data.unit.unit_type,
    		            			unit_block:data.unit.unit_block,
    		            			unit_number:data.unit.unit_number,
    		            			surface_area:data.unit.surface_area,
    		            			building_area:data.unit.building_area,
    		            			utj:data.unit.utj,
    		            			electrical_power:data.unit.electrical_power,
    		            			points:data.unit.points,
    		            			closing_fee:data.unit.closing_fee,
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
    		            			point: data.point,
    		            			client_id: data.client_id,
    		            			client_name: data.client.client_name,
    		            			client_number: data.client.client_number,
    		            			client_email: data.client.client_email,
    		            			client_phone_number: data.client.client_phone_number,
    		            			client_mobile_number: data.client.client_mobile_number,
    		            			client_address: data.client.client_address,
    		            			sales_id: data.sales_id,
    		            			sales_name:data.sales.user.full_name,
    		            			agency_name:data.agency ? data.agency.agency_name : '',
    		            			main_coordinator:data.sales.main_coordinator ? data.sales.main_coordinator.full_name : '',
    		            			regional_coordinator:data.sales.regional_coordinator ? data.sales.regional_coordinator.full_name : '',
    		            		}
    		            		this.unit_installments = data.payments

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
        	showFormattedDt(dt) {
                return moment(dt, "YYYY-MM-DD").format("DD-MMM-YYYY")
            },
        	// regenerateInstallment () {
         //        let new_installment = []
         //        let credit = _.toString(this.unit_installments[0].credit).split('.').join('')
         //        let unit_price = parseInt(credit)

         //        _.forEach(this.unit_installments, (value, key) => {
         //            if (key == 0) {
         //                new_installment.push({
         //                    hashid: value.hashid,
         //                    payment: value.payment,
         //                    due_date: value.due_date,
         //                    installment: this.moneyFormat(parseInt(_.toString(value.installment).split('.').join(''))),
         //                    credit: this.moneyFormat(parseInt(_.toString(value.credit).split('.').join('')))
         //                })
         //            } else {
         //                unit_price = unit_price - parseInt(_.toString(value.installment).split('.').join(''))

         //                new_installment.push({
         //                    hashid: value.hashid,
         //                    payment: value.payment,
         //                    due_date: value.due_date,
         //                    installment: key == this.installment_time ? this.moneyFormat(parseInt(_.toString(value.installment).split('.').join('')) + unit_price) : this.moneyFormat(parseInt(_.toString(value.installment).split('.').join(''))),
         //                    credit: key == this.installment_time ? 0 : this.moneyFormat(unit_price)
         //                })
         //            }
         //        });

         //        this.unit_installments = new_installment
         //        console.log('unit_installments')
         //    },
        }
	}
</script>