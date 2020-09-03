<script>

let call

export default {
    props: {
        uri: {
            type: String,
            required: true
        },
        headers: {
            type: Array,
            required: true
        },
        noDataText: {
            type: String,
            default: "No data found."
        },
        noResultsText: {
            type: String,
            default: "No data found."
        },
        searchText: {
            type: String,
            default: "Search"
        },
        searchIcon: {
            type: String,
            default: "mdi-magnify"
        },
        refreshText: {
            type: String,
            default: "Reload"
        },
        refreshIcon: {
            type: String,
            default: "mdi-sync"
        },
        addNewText: {
            type: String,
            default: "Add New"
        },
        addNewIcon: {
            type: String,
            default: "mdi-plus"
        },
        addNewUri: {
            type: String,
            default: ""
        },
        addNewColor: {
            type: String,
            default: "info"
        },
        itemsPerPageAllText: {
            type: String,
            default: "All"
        },
        itemsPerPageText: {
            type: String,
            default: "Rows per page:"
        },
        pageTextLocale: {
            type: String,
            default: "en"
        },
        editUri: {
            type: String,
            default: ""
        },
        editUriParameter: {
            type: String,
            default: ""
        },
        editText: {
            type: String,
            default: "Edit"
        },
        editIcon: {
            type: String,
            default: "mdi-pencil"
        },
        editColor: {
            type: String,
            default: "primary"
        },
        deleteUri: {
            type: String,
            default: ""
        },
        deleteUriParameter: {
            type: String,
            default: ""
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
            default: "Are you sure want to delete this data ?"
        },
        deleteCancelText: {
            type: String,
            default: "Cancel"
        },
    },
    data () {
        return {
            promptDelete: false,
            search: '',
            totalData: 0,
            fromData: 0,
            toData: 0,
            tableItems: [],
            loading: true,
            options: {},
            tableSortBy: [],
            tableSortDesc: [],
            selected: null,
            deleteLoader: false,
            tableAlert: false,
            tableAlertText: '',
            tableAlertState: 'info',
        }
    },
    watch: {
        options: {
            handler () {
                this.dataHandler()
            },
            deep: true,
        },
    },
    mounted () {
        this.dataHandler()
    },
    computed:{
        query() {
            var sortBy = []
            _.forEach(this.options.sortBy, (value, key) => {
                sortBy.push({
                    0: value, 
                    1: this.options.sortDesc[key]
                })
            });
            return '?page=' + this.options.page + '&search=' + this.search + '&paginate=' + this.options.itemsPerPage + '&sort=' + JSON.stringify(sortBy)
        }
    },
    methods: {
        dataHandler() {
            setTimeout(this.getData(), 2000);
        },
        getData() {
            this.loading = true
            if (call) {
                call.cancel();
            }
            call = axios.CancelToken.source()
            axios
                .get(this.uri + this.query,  {
                    cancelToken: call.token
                })
                .then(response => {
                    this.setData(response.data.data.data)
                    this.totalData = response.data.data.total
                    this.fromData = response.data.data.from
                    this.toData = response.data.data.to
                    this.loading = false;
                })
                .catch(error => {
                    this.loading = false;
                });
        },
        setData(data) {
            var items = []
            _.forEach(data, (value, key) => {
                value.table_index = parseInt(key) + 1
                items.push(value)
            });
            this.tableItems = items
        },
        promptDeleteItem(item) {
            this.promptDelete = true
            this.selected = item
        },
        deleteItem() {
            this.deleteLoader = true
            axios.delete(this.base_url() + this.ziggy(this.deleteUri, [this.selected[this.deleteUriParameter]]).url())
                .then((response) => {
                    if (response.data.success) {
                        this.tableAlert = true
                        this.tableAlertState = 'success'
                        this.tableAlertText = response.data.message

                        this.dataHandler()
                    } else {
                        this.tableAlert = true
                        this.tableAlertState = 'error'
                        this.tableAlertText = response.data.message
                    }
                    this.deleteLoader = false
                    this.promptDelete = false
                })
                .catch((error) => {
                    this.tableAlert = true
                    this.tableAlertState = 'error'
                    this.tableAlertText = 'Oops, something went wrong. Please try again later.'

                    this.deleteLoader = false
                    this.promptDelete = false
                });
        },
    },
}
</script>