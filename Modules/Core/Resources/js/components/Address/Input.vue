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
			addressValue: {
				type: String,
				default: ''
			},
			addressRules: {
				type: String,
				default: ''
			},
			addressClass: {
				type: String,
				default: ''
			},
			addressInputName: {
				type: String,
				default: ''
			},
			addessLabel: {
				type: String,
				default: ''
			},
			addressCounter: {
				type: Number,
				default: 0
			},			
			provinceValue: {
				type: String,
				default: ''
			},			
			provinceRules: {
				type: String,
				default: ''
			},
			provinceClass: {
				type: String,
				default: ''
			},
			provinceInputName: {
				type: String,
				default: ''
			},
			provinceLabel: {
				type: String,
				default: ''
			},
			cityValue: {
				type: String,
				default: ''
			},
			cityRules: {
				type: String,
				default: ''
			},
			cityClass: {
				type: String,
				default: ''
			},
			cityInputName: {
				type: String,
				default: ''
			},
			cityLabel: {
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
        		address: '',
        		province: '',
        		city: '',
        		items: [],
        	}
        },
        computed: {
            cityOptions: function () {
            	if (this.province) {
            		return _.filter(this.items, (o) => { return o.name == this.province })
            	}
            	return []
            }
        },
        mounted() {
            this.getItems();
        },
        methods: {
    		getItems() {
		        axios
		            .get(this.base_url() + this.ziggy('provinces.index').url())
		            .then(response => {
		            	if (response.data.success) {
		            		this.items = response.data.data
		            		this.address = this.addressValue

		            		if (this.provinceValue) {
		            			this.$nextTick(() => {
			            			this.province = this.provinceValue

    			            		if (this.cityValue) {
    			            			this.$nextTick(() => {
    				            			this.city = this.cityValue
    			            			})
    			            		}
		            			})
		            		}
		            	}
		            })
		            .catch(error => {
	            		console.log(error.response)
		            });
    		},
    		refreshCity() {
    			this.city = ''
    		}
        }
	}
</script>