<script>
	export default {
		components: {
		   // 
		},
		props: {
			events_calendar: {
          type: Array,
          default: function () {
              return []
          }
      },
		},
		data: function () {
            return {
                focus: '',
                type: 'month',
                typeToLabel: {
                  month: 'Month',
                  week: 'Week',
                  day: 'Day',
                  '4day': '4 Days',
                },
                selectedEvent: {},
                selectedElement: null,
                selectedOpen: false,
                events: [],
        	}
        },
        mounted () {
          this.$refs.calendar.checkChange()
        },
        methods: {
      		viewDay ({ date }) {
            this.focus = date
            this.type = 'day'
          },
          getEventColor (event) {
            return event.color
          },
          setToday () {
            this.focus = ''
          },
          prev () {
            this.$refs.calendar.prev()
          },
          next () {
            this.$refs.calendar.next()
          },
          showEvent ({ nativeEvent, event }) {
            const open = () => {
              this.selectedEvent = event
              this.selectedElement = nativeEvent.target
              setTimeout(() => this.selectedOpen = true, 10)
            }

            if (this.selectedOpen) {
              this.selectedOpen = false
              setTimeout(open, 10)
            } else {
              open()
            }

            nativeEvent.stopPropagation()
          },
          updateRange ({ start, end }) {
            const events = []

            const min = new Date(`${start.date}T00:00:00`)
            const max = new Date(`${end.date}T23:59:59`)
            const days = (max.getTime() - min.getTime()) / 86400000
            const eventCount = this.rnd(days, days + 20)

            this.events = this.events_calendar
          },
          rnd (a, b) {
            return Math.floor((b - a + 1) * Math.random()) + a
          }
      },
    }
</script>