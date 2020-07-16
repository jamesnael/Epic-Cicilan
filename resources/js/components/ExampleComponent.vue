<script>
  export default {
    data: () => ({
          drawers: ['Default (no property)', 'Permanent', 'Temporary'],
          primaryDrawer: {
            model: null,
            type: 'temporary',
            clipped: false,
            floating: false,
            mini: false,
          },
          footer: {
            inset: false,
          },
        }),
  }
</script>