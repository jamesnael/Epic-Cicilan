<script type="text/javascript">
	export default {
		props: {
			uri: {
				type: String,
				required: true
			},
			dataUri: {
			    type: String,
			    required: true
			}			
		},
		data: () => ({
        	loader: null,
            field_state: false,
        	card_overlay: false,
            overlay: false,
        	progressText: 'Mohon Menunggu.',
        	formAlert: false,
            formAlertText: '',
            formAlertState: 'info',
        	form_data: {
        		client_number: '',
        		client_name: '',
        		client_mobile_number: '',
        		client_email: '',
        		client_address: '',
        		sales_name: '',
        		unit_type: '',
        		unit_block: '',
        		unit_number: '',
        		surface_area: '',
        		building_area: '',
        		electrical_power: '',
        		nup_amount: '',
        		payment_method_nup: '',
        		nup_date: '',
        		utj_amount: '',
        		payment_method_utj: '',
        		utj_date: '',
        		payment_type: '',
        		total_amount: '',
        		first_payment: '',
        		principal: '',
        		installment: '',
        		installment_time: '',
        		total_pembayaran: '',
        		sisa_tunggakan: '',
        		total_denda: '',
                slug: '',
        		payments: []
        	}
        }),
        mounted() {
            this.setData();
        },
        methods: {
    		setData() {
    			if (this.dataUri) {
    				this.field_state = true
    				this.overlay = true
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
                                    dp_amount: data.dp_amount,
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
                                    slug: data.slug,
					        		payments: items
					        	}

    			                this.field_state = false
    			                this.overlay = false
    		            	} else {
			    		        this.overlay = false
    		            		this.formAlert = true
		    		            this.formAlertState = 'error'
		    		            this.formAlertText = response.data.message
			    		        this.field_state = false
    		            	}
    		            })
    		            .catch(error => {
		    		        this.overlay = false
    	            		this.formAlert = true
		                    this.formAlertState = 'error'
		                    this.formAlertText = 'Oops, something went wrong. Please try again later.'
		    		        this.field_state = false
    		            });
    			}
    		},
            postPayment(item) {
                const data = new FormData();

                this.field_state = true

                axios.post(this.base_url() + this.ziggy('pembayaran.cicilan.payment', [this.form_data.slug, item.slug]).url(), data)
                    .then((response) => {
                        if (response.data.success) {
                            this.goto(response.data.data.redirect_url);
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
            }
    	}
	}
</script>