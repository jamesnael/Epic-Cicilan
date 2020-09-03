<script>
  export default {
    data () {
      return {
        props: {
          redirectUri: {
            type: String,
            required: true
          },
        },
        headers: [
          {
            text: '#',
            align: 'start',
            sortable: false,
            value: 'name',
          },
          { text: 'Category Reward', value: 'cat' },
          { text: 'Reward', value: 'reward' },
          { text: 'Points', value: 'point' },
        ],
        desserts: [
          {
            name: '1',
            cat: 'Trip Jalan-jalan',
            reward: 'Japan',
            point: 24,
          },
          {
            name: '2',
            cat: 'Mobil',
            reward: 9.0,
            point: 37,
          },
          {
            name: '3',
            cat: 'Emas',
            reward: 16.0,
            point: 23,
          },
        ],
      }
    },
  }
</script>