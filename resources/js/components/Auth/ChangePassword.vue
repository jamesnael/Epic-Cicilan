<script type="text/javascript">
	import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
	import { required, email, max, min, numeric, between, confirmed } from 'vee-validate/dist/rules'
	import id from 'vee-validate/dist/locale/id.json'

	extend('required', required)
	extend('email', email)
	extend('max', max)
	extend('min', min)
	extend('numeric', numeric)
	extend('between', between)
	extend('confirmed', confirmed)
    localize('id', id);

	export default {
		components: {
		    ValidationObserver,
		    ValidationProvider
		},
		data: function () {
            return {
            	formAlert: false,
	            formAlertText: '',
	            formAlertState: 'info',
            	show1: false,
            	show2: false,
            	show3: false,

                field_state: false,
                old_password: '',
                password: '',
                password_confirmation: '',
            }
        },
		methods: {
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
				
				this.field_state = true

				axios.post(this.base_url() + this.ziggy('change-password').url(), data)
				    .then((response) => {
	    		        if (response.data.success) {
	    		            this.formAlert = true
	    		            this.formAlertState = 'success'
	    		            this.formAlertText = response.data.message

	    		            setTimeout(() => {
			                     window.location.reload(true);
			                }, 6000);
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