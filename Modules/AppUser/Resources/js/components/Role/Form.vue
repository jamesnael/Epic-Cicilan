<script>
	import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
	import { required, email, max, numeric, between } from 'vee-validate/dist/rules'
	import id from 'vee-validate/dist/locale/id.json'

	extend('required', required)
	extend('email', email)
	extend('max', max)
	extend('numeric', numeric)
	extend('between', between)
    localize('id', id);

	export default {
		components: {
		    ValidationObserver,
		    ValidationProvider
		},
		props: {
			slug: {
				type: String,
				required: true
			},
			uri: {
				type: String,
				required: true
			},
			filter_menu: {
			    type: Object,
			    default: function () {
			        return {}
			    }
			},
			hak_akses: {
			    type: Array,
			    default: function () {
			        return []
			    }
			},
			redirectUri: {
				type: String,
				required: true
			},
			dataUri: {
			    type: String,
			    default: ''
			}
		},
		data: function () {
            return {
            	field_state: false,
            	formAlert: false,
	            formAlertText: '',
	            formAlertState: 'info',
	            show1: false,
	            refreshCK: true,
            	form_data: {
            		full_name: '',
            		email: '',
            		password:'',
            		phone_number: '',
            		address: '',
            		province: '',
            		city: '',
            		role_id:'',
            		hak_akses: [],
            		role_name: '',
            		description:''
            	},
            	menu: '',
        	}
        },
        mounted() {
            this.setData();
        },
        methods: {
        	selectAll() {
        		console.log('test')
    	        this.refreshCK = false
    	        this.form_data.hak_akses = []
    	        _.forEach(this.filter_menu, (key) => {
    	        	if (key['has_child'] == 'true') {
		                _.forEach(key['submenu'], (parent) => {
		                	_.forEach(parent['routes'], (route) => {
		                	    this.form_data.hak_akses.push(route.uri)
		                	});
		                });
    	        	}else{
    	        		_.forEach(key['routes'], (child) => {
		                    this.form_data.hak_akses.push(child.uri)
		                });
    	        	}
    	        });
    	        this.refreshCK = true
        	},
    		setData() {
    			this.refreshCK = false

    			if (this.dataUri) {
    				this.field_state = true

    		        axios
    		            .get(this.dataUri)
    		            .then(response => {
    		            	if (response.data.success) {
    		            		let data = response.data.data

    		            		this.form_data = {
    		            			full_name: data.full_name,
    		            			email: data.email,
    		            			phone_number: data.phone_number,
    		            			address: data.address,
    		            			province: data.province,
    		            			city: data.city,
    		            			role_id:'',

    		            			role_name: data.role_name,
    		            			description: data.description,

    		            			hak_akses: data.user_access ? data.user_access : []
    		            		},


    		            		// this.menu = item;


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

    			this.refreshCK = true
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
		        	full_name: '',
		        	email: '',
		        	phone_number: '',
		        	address: '',
		        	province: '',
		        	city: '',
		        	role_id: ''
		        }
		        this.$refs.observer.reset()
		    },
		    postFormData() {
	    		const data = new FormData(this.$refs['post-form']);
	    		if (_.isEmpty(this.form_data.hak_akses)) {
		    		data.append("hak_akses[]", "");
	    		}
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
		    }
        }
	}
</script>