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
            slug: {
                type: String,
                default: ''
            },
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
            deleteText: {
                type: String,
                default: "Delete"
            },
            deleteIcon: {
                type: String,
                default: "mdi-trash-can-outline"
            },
            deleteColor: {
                type: String,
                default: "red lighten-1"
            },
            deleteConfirmationText: {
                type: String,
                default: "Are you sure want to delete this file ?"
            },
            deleteCancelText: {
                type: String,
                default: "Cancel"
            },
        },
        data: function () {
            return {
                promptDelete: false,
                field_state: false,
                formAlert: false,
                deleteLoader: false,
                formAlertText: '',
                formAlertState: 'info',
                menu2: false,
                menu3: false,
                menu4: false,
                modal: false,
                form_data: {
                    booking_id: '',
                    client_name: '',
                    sales_name: '',
                    unit_name: '',
                    print_date: new Date().toISOString().substr(0, 10),
                    sent_date: new Date().toISOString().substr(0, 10),
                    received_date: new Date().toISOString().substr(0, 10),
                },
                delete_file_type: '',
            }
        },
        mounted() {
            this.setData();
        },
        methods: {
            pairingUploadedUrl(data) {
                _.forEach(this.files, (file) => {
                    let url_link = 'url_' + file.file_name
                    file.url = data[url_link] ?? ''
                    file.showcase = data[file.file_name] ?? ''
                });
            },
            setData() {
                if (this.dataUri) {
                    this.field_state = true

                    axios
                        .get(this.dataUri)
                        .then(response => {
                            if (response.data.success) {
                                let data = response.data.data
                                this.form_data = {
                                    booking_id: data.id,
                                    slug: data.slug,
                                    client_name: data.client.client_name,
                                    sales_name: data.sales.user.full_name,
                                    unit_name: data.unit.unit_number + '/' + data.unit.unit_block,
                                    print_date: data.spr ? data.spr.print_date : null,
                                    print_date_data: data.spr ? data.spr.print_date : null,
                                    sent_date: data.spr ? data.spr.sent_date : null,
                                    sent_date_data: data.spr ? data.spr.sent_date : null,
                                    received_date: data.spr ? data.spr.received_date : null,
                                    received_date_data: data.spr ? data.spr.received_date : null,
                                    approval_status: data.spr ? data.spr.approval_status : null,
                                }

                                this.pairingUploadedUrl(data.spr)

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
                    data.append("booking_id", this.form_data.booking_id);
                    data.append("print_date", this.form_data.print_date);
                    data.append("sent_date", this.form_data.sent_date);
                    data.append("received_date", this.form_data.received_date);
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
            promptDeleteItem(file_name) {
                this.promptDelete = true
                this.delete_file_type = file_name
            },
            removeUploadedFile () {
                const data = new FormData();

                axios.delete(this.base_url() + this.ziggy('spr.remove-file', [this.slug, this.delete_file_type]).url(), data)
                    .then((response) => {
                        if (response.data.success) {
                            this.formAlert = true
                            this.formAlertState = 'success'
                            this.formAlertText = response.data.message
                        } else {
                            this.formAlert = true
                            this.formAlertState = 'error'
                            this.formAlertText = response.data.message
                        }
                        this.deleteLoader = false
                        this.promptDelete = false

                        this.setData()
                    })
                    .catch((error) => {
                        this.formAlert = true
                        this.formAlertState = 'error'
                        this.formAlertText = 'Oops, something went wrong. Please try again later.'

                        this.deleteLoader = false
                        this.promptDelete = false
                    });
            }
        }
    }
</script>