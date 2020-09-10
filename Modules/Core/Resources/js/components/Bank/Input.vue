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
			bankValue: {
				type: String,
				default: ''
			},
			bankRules: {
				type: String,
				default: ''
			},
			bankClass: {
				type: String,
				default: ''
			},
			bankInputName: {
				type: String,
				default: ''
			},
			bankLabel: {
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
        		bank: '',
        		items: [],
        	}
        },
        mounted() {
            this.getItems();
        },
        methods: {
    		getItems() {
		        axios
		            .get(this.base_url() + this.ziggy('banks.index').url())
		            .then(response => {
		            	if (response.data.success) {
		            		this.items = response.data.data
		            		this.bank = this.bankValue
		            	}
		            })
		            .catch(error => {
	            		console.log(error.response)
		            });
    		}
        }
	}
</script>