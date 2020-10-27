<script>
    import { ValidationObserver, ValidationProvider, extend, localize } from 'vee-validate';
    import { required, email, max, min, numeric, between } from 'vee-validate/dist/rules'
    import id from 'vee-validate/dist/locale/id.json'

    var moment = require('moment')

    extend('required', required)
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
        },
        data: function () {
            return {
                field_state: false,
                formAlert: false,
                formAlertText: '',
                formAlertState: 'info',
                form_data: {
                    file_import: '',
                }
            }
        },
        computed:{
        },
        mounted() {
            // 
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
        }
    }
</script>