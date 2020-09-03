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
            filter_category: {
                type: Array,
                default: function () {
                    return []
                }
            },
            filter_reward: {
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
            filter_agency: {
                type: Array,
                default: function () {
                    return []
                }
            },
            filter_korut: {
                type: Array,
                default: function () {
                    return []
                }
            },
            filter_korwil: {
                type: Array,
                default: function () {
                    return []
                }
            },
            filter_reward_point: {
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
                switchStatus: true,
                regional_coordinator: false,
                main_coordinator: false,
                agency: false,
                sales: false,
                listStatus:['Aktif', 'Tidak Aktif'],
                form_data: {
                    category_reward_id: '',
                    reward_point_id:'',
                    level:'',
                    user_name:'',
                    exchange_point:'',
                    redeem_point:''
                }
            }
        },

        computed: {
            computedCategoryName: function () {
                if (this.form_data.category_reward_id) {
                    return _.filter(this.filter_reward, (o) => { return o.value == this.form_data.category_reward_id })
                }
                return []
            },
            computedRedeemPoint: function () {
                if (this.form_data.reward_points) {
                    return _.filter(this.filter_reward_point, (o) => { return o.value == this.form_data.reward_points })
                }
                return []
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
                                    // category_name: data.category_name,
                                    // description: data.description,
                                    //   category_reward_id: data.category_reward_id,
                                    // reward_name: data.reward_name,
                                    // redeem_point: data.redeem_point_sales,
                                    // kuota: data.kuota,
                                    // description:data.description,
                                    // status: data.status,
                                    // redeem_point_main_coordinator: data.redeem_point_main_coordinator,
                                    // redeem_point_regional_coordinator: data.redeem_point_regional_coordinator,
                                    // redeem_point_agency: data.redeem_point_agency,
                                    // redeem_point_sales: data.redeem_point_sales,
                                }

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
                console.log('a')
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

            setSelectedSales() {
                let sales = _.find(this.filter_sales, o => { return o.value == this.form_data.user_name})
                if (_.isUndefined(sales)) {
                    this.form_data.sales_name = ''
                    this.form_data.agency_name = ''
                    this.form_data.total_point = ''
                } else {
                    this.form_data.sales_name = sales.text
                    this.form_data.agency_name = sales.agency_name
                    this.form_data.total_point = sales.total_point
                    
                }
            },

            setSelectedSubAgent() {
                let agency = _.find(this.filter_agency, o => { return o.value == this.form_data.user_name})
                if (_.isUndefined(agency)) {
                    this.form_data.agency_name = ''
                    this.form_data.regional = ''
                    this.form_data.total_point = ''
                } else {
                    this.form_data.agency_name = agency.text
                    this.form_data.regional = agency.regional
                    this.form_data.total_point = agency.total_point
                    
                }
            },


            setSelectedKorwil() {
                let main_coordinator = _.find(this.filter_korwil, o => { return o.value == this.form_data.user_name})
                if (_.isUndefined(main_coordinator)) {
                    this.form_data.korwil_name = ''
                    this.form_data.maincoor = ''
                    this.form_data.total_point = ''
                } else {
                    this.form_data.korwil_name = main_coordinator.text
                    this.form_data.maincoor = main_coordinator.maincoor
                    this.form_data.total_point = main_coordinator.total_point
                    
                }
            },

            setRewardPoint() {
                let reward = _.find(this.computedCategoryName, o => { return o.value == this.form_data.reward_points})
                console.log(reward);
                if (_.isUndefined(reward)) {
                    this.form_data.redeem_point = ''
                } else {
                    this.form_data.redeem_point_sales = reward.redeem_point_sales
                    this.form_data.redeem_point_agency = reward.redeem_point_agency
                    this.form_data.redeem_point_regional_coordinator = reward.redeem_point_regional_coordinator
                    this.form_data.redeem_point_main_coordinator = reward.redeem_point_main_coordinator                    
                }
            },
        }
    }
</script>