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
			occupationValue: {
				type: String,
				default: ''
			},
			occupationRules: {
				type: String,
				default: ''
			},
			occupationClass: {
				type: String,
				default: ''
			},
			occupationInputName: {
				type: String,
				default: ''
			},
			occupationLabel: {
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
        		occupation: '',
        		items: [],
        	}
        },
        mounted() {
            this.getItems();
        },
        methods: {
    		getItems() {
		        axios
		            .get(this.base_url() + this.ziggy('occupations.index').url())
		            .then(response => {
		            	if (response.data.success) {
		            		this.items = response.data.data
		            		this.occupation = this.occupationValue
		            	}
		            })
		            .catch(error => {
	            		console.log(error.response)
		            });
    		}
        }
	}
</script>