<script>
    export default {
        props: {
            source: String,
            items: {
                type: Array,
                default: function() {
                    return []
                }
            }
        },
        data: () => ({
            drawer: null,
        }),
    }
</script>