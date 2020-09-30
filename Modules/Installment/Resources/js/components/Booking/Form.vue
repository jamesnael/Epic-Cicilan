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
            filter_unit_type: {
                type: Array,
                default: function () {
                    return []
                }
            },
            filter_tipe_programs: {
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
                menu2: false,
			    modal: false,
	            datepicker: false,
            	form_data: {
            		unit_type:'',
                    cluster_name:'',
            		client_name:'',
            		unit_number:'',
                    unit_address:'',
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
                    nup_amount: '0',
                    utj_amount: '0',
                    payment_method_nup: '',
                    nup_date: '',
                    utj_date: '',
                    id_unit_type: '',
                    main_coor_id:'',
                    regional_coor_id:'',
                    agent_id:'',
                    program_id:'',
                    deal_closer:'',
            	},
                program: {
                    nama_program: '',
                    harga_termasuk: [],
                    harga_tidak_termasuk: [],
                    gimmick: '',
                    keterangan: '',
                },
            	total_amount: '0',
                first_payment: '0',
                dp_amount: '0',
                dp_percent: '0',
                installment_time: '',
                due_date: '',
                payment_method: '',
                payment_type: '',
                credits: '0',
        	}
        },
        computed:{
            hargaExcludePPN: function() {
                if (this.total_amount) {
                    return  _.isNumber(parseInt(this.total_amount)) ? _.round(parseInt(this.total_amount) / 1.1, 0) : 0;
                }

                return 0;
            },
            principal: function() {
                if (this.payment_type == 'KPR/KPA') {
                    this.credits = parseInt(this.total_amount) - parseInt(this.dp_amount);

                    return parseInt(this.dp_amount) /*- parseInt(this.first_payment)*/ - parseInt(this.form_data.nup_amount) - parseInt(this.form_data.utj_amount);
                }

                this.credits = '0';

                return parseInt(this.total_amount) /*- parseInt(this.first_payment)*/ - parseInt(this.form_data.nup_amount) - parseInt(this.form_data.utj_amount);
            },
            installment: function() {
            	if(this.principal == '' && this.installment_time == ''){
            		return '0';
            	}
            	let result = (parseInt(this.principal) - parseInt(this.first_payment)) / (parseInt(this.installment_time) - 1);

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
    		            		this.form_data = {
    		            			id_unit_type:data.unit.id_unit_type,
                                    cluster_name:data.unit.point.cluster.cluster_name,
                                    unit_type:data.unit.unit_type,
    		            			unit_block:data.unit.unit_block,
    		            			unit_number:data.unit.unit_number,
                                    unit_address:data.unit.unit_address,
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

    		            			sales_name:data.sales.user.full_name,

    		            			agency_name:data.sales.agency ? data.sales.agency.agency_name : '',
    		            			main_coordinator:data.sales.main_coordinator ? data.sales.main_coordinator.full_name : '',
    		            			regional_coordinator:data.sales.regional_coordinator ? data.sales.regional_coordinator.full_name : '',

                                    nup_amount: data.nup_amount,
                                    utj_amount: data.utj_amount,
                                    payment_method_nup: data.payment_method_nup,
                                    nup_date: data.nup_date,
                                    utj_date: data.utj_date,

    		            			sales_id: data.sales.id,
                                    main_coor_id:data.sales.main_coordinator_id,
                                    regional_coor_id:data.sales.regional_coordinator_id,
                                    agent_id:data.sales.agency_id,
                                    program_id:data.program_id,

                                    deal_closer:data.deal_closer,
    		            		},
    		            		this.total_amount = data.total_amount
    		            		this.first_payment = data.first_payment
    		            		this.dp_amount = data.dp_amount
    		            		this.dp_percent = data.dp_percent
    		            		this.installment_time = data.installment_time
    		            		this.due_date = data.due_date
    		            		this.payment_method = data.payment_method
    		            		this.payment_type = data.payment_type
    		            		this.credits = data.credits

                                this.setSelectedProgram()

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
                    data.append("utj_date", this.form_data.utj_date);
                    data.append("nup_date", this.form_data.nup_date);
                } 

                data.append("utj_date", this.form_data.utj_date);
                data.append("nup_date", this.form_data.nup_date);
	    		
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
		    setSelectedClient() {
				let client = _.find(this.filter_client, o => { return o.value == this.form_data.client_id})
				if (_.isUndefined(client)) {
					this.form_data.client_number = ''
					this.form_data.client_name = ''
					this.form_data.client_phone_number = ''
					this.form_data.client_mobile_number = ''
					this.form_data.client_address = ''
					this.form_data.client_email = ''
				} else {
					this.form_data.client_number = client.client_number
					this.form_data.client_name = client.text
					this.form_data.client_phone_number = client.client_phone_number
					this.form_data.client_mobile_number = client.client_mobile_number
					this.form_data.client_address = client.client_address
					this.form_data.client_email = client.client_email
				}
			},
			setSelectedSales() {
				let sales = _.find(this.filter_sales, o => { return o.value == this.form_data.sales_id})
				if (_.isUndefined(sales)) {
					this.form_data.sales_name = ''
					this.form_data.agency_name = ''
					this.form_data.main_coordinator = ''
					this.form_data.regional_coordinator = ''
                    this.form_data.main_coor_id = ''
                    this.form_data.regional_coor_id = ''
                    this.form_data.agent_id = ''
				} else {
					this.form_data.sales_name = sales.text
					this.form_data.main_coor_id = sales.main_coordinator_id
                    this.form_data.regional_coor_id = sales.regional_coordinator_id
                    this.form_data.agent_id = sales.agency_id
                    this.form_data.agency_name = sales.agency_name
					this.form_data.main_coordinator = sales.main_coordinator
					this.form_data.regional_coordinator = sales.regional_coordinator
				}
			},
            setSelectedUnitType() {
                let unit = _.find(this.filter_unit_type, o => { return o.value == this.form_data.id_unit_type})
                console.log(this.filter_unit_type);
                if (_.isUndefined(unit)) {
                    this.form_data.closing_fee = ''
                    this.form_data.unit_type = ''
                    this.form_data.points = ''
                    this.form_data.cluster_name = ''
                } else {
                    this.form_data.unit_type = unit.text
                    this.form_data.closing_fee = unit.closing_fee
                    this.form_data.points = unit.point
                    this.form_data.cluster_name = unit.cluster_name
                }
            },
			paymentType() {
                    this.total_amount = '0';
                    this.first_payment = '0';
                    this.dp_amount = '0';
                    this.installment_time = '1';
                    this.due_date = '0';
                    this.credits = '0';
            },
            setSelectedProgram() {
                let data = _.find(this.filter_tipe_programs, o => { return o.id == this.form_data.program_id})
                if (_.isUndefined(data)) {
                    this.program = {
                                    nama_program: '',
                                    harga_termasuk: [],
                                    harga_tidak_termasuk: [],
                                    gimmick: '',
                                    keterangan_program: '',
                                }
                } else {
                    this.program = {
                                    nama_program: data.nama_program,
                                    harga_termasuk: data.harga_termasuk,
                                    harga_tidak_termasuk: data.harga_tidak_termasuk,
                                    gimmick: data.gimmick,
                                    keterangan_program: data.keterangan,
                                }
                }
            }
        }
	}
</script>