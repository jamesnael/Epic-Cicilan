<script>
	import { ValidationProvider, extend, localize } from 'vee-validate';
	import { required } from 'vee-validate/dist/rules'
	import id from 'vee-validate/dist/locale/id.json'

	extend('required', required)
    localize('id', id);

	export default {
		components: {
		    ValidationProvider
		},
		props: {
			paymentMethodValue: {
				type: String,
				default: ''
			},
			paymentMethodRules: {
				type: String,
				default: ''
			},
			paymentMethodClass: {
				type: String,
				default: ''
			},
			paymentMethodInputName: {
				type: String,
				default: ''
			},
			paymentMethodLabel: {
				type: String,
				default: ''
			},
			disabled: {
				type: Boolean,
				default: function() {
					return false
				}
			}
		},
		data: function () {
            return {
        		paymentMethod: '',
        		items: [],
        	}
        },
        mounted() {
            this.getItems();
        },
        methods: {
    		getItems() {
		        axios
		            .get(this.base_url() + this.ziggy('payment-methods.index').url())
		            .then(response => {
		            	if (response.data.success) {
		            		this.items = response.data.data
		            		this.paymentMethod = this.paymentMethodValue
		            	}
		            })
		            .catch(error => {
	            		console.log(error.response)
		            });
    		}
        }
	}
</script>