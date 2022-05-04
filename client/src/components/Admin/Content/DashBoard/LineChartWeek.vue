<script>
import { Line } from "vue-chartjs/legacy";
import moment from "moment-timezone";

export default {
  extends: Line,
  props: { orders: Array, timestamp: Number },
  data() {
    return {
      dataset: [],
      label: [],
      new_data: {
        label: "",
        data: [0, 0, 0, 0, 0, 0, 0],
        backgroundColor: "transparent",
        borderColor: null,
        pointBackgroundColor: "rgba(171, 71, 188, 1)",
      },
      formatted_data: [],
    };
  },
  computed: {
    chart_date() {
      return this.filterWeek(this.formatted_data);
    },
  },
  watch: {
    timestamp() {
      this.dataset = [];
      this.label = [];
      this.new_data = {
        label: "",
        data: [0, 0, 0, 0, 0, 0, 0],
        backgroundColor: "transparent",
        borderColor: null,
        pointBackgroundColor: "rgba(171, 71, 188, 1)",
      };
      this.formatted_data = [];
      this.init();
    },
  },
  methods: {
    init() {
      for (let i = 0; i < this.orders.length; i++) {
        const full = moment(this.orders[i].order_date, "DD/MM/YYYY").format(
          "YYYYMMDD"
        );
        var whichDay;
        var existing = this.formatted_data.filter((item, index) => {
          if (item.full == full) {
            whichDay = index;
            return true;
          } else {
            return false;
          }
        });
        const day = moment(this.orders[i].order_date, "DD/MM/YYYY").day();
        const date = moment(this.orders[i].order_date, "DD/MM/YYYY").format(
          "DD"
        );
        const month = moment(this.orders[i].order_date, "DD/MM/YYYY").format(
          "MM"
        );
        const year = moment(this.orders[i].order_date, "DD/MM/YYYY").format(
          "YYYY"
        );
        if (existing.length) {
          this.formatted_data[whichDay].total =
            this.formatted_data[whichDay].total + this.orders[i].order_total;
        } else {
          this.formatted_data.push({
            day: day,
            date: date,
            month: month,
            year: year,
            full: full,
            total: this.orders[i].order_total,
          });
        }
      }

      this.new_data.borderColor = this.getRandom();
      for (let i = 0; i < this.chart_date.length; i++) {
        var new_index = this.chart_date[i].day;
        this.new_data.data[new_index] = this.chart_date[i].total;
      }

      const time_now = new Date(this.timestamp);
      const time_now_1 = new Date(this.timestamp);
      const date = moment(time_now).day();

      var start_date = moment(
        time_now_1.setDate(time_now_1.getDate() - date)
      ).format("YYYYMMDD");

      for (let i = 0; i < 7; i++) {
        var first_day = new Date(moment(start_date, "YYYYMMDD"));
        first_day.setDate(first_day.getDate() + i);
        var changed_format = moment(first_day).format("dd DD/MM");

        this.label.push(changed_format);
      }

      this.dataset.push(this.new_data);
      this.new_data = {
        label: "",
        data: [0, 0, 0, 0, 0, 0, 0],
        backgroundColor: "transparent",
        borderColor: null,
        pointBackgroundColor: "rgba(171, 71, 188, 1)",
      };
      this.renderChart(
        {
          labels: this.label,
          datasets: this.dataset,
        },
        {
          responsive: true,
          maintainAspectRatio: false,
          legend: {
            display: false,
          },
        }
      );
    },

    filterWeek(formatted_data) {
      const time_now = new Date(this.timestamp);
      const time_now_1 = new Date(this.timestamp);
      const time_now_2 = new Date(this.timestamp);
      const date = moment(time_now).day();
      var till_end = 6 - Number(date);

      var start_date = moment(
        time_now_1.setDate(time_now_1.getDate() - date)
      ).format("YYYYMMDD");
      var end_date = moment(
        time_now_2.setDate(time_now_2.getDate() + till_end)
      ).format("YYYYMMDD");

      return formatted_data.filter(
        (f_data) => f_data.full >= start_date && f_data.full <= end_date
      );
    },
    getRandom() {
      var letters = "0123456789ABCDEF";
      var color = "#";
      for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    },
  },
  mounted() {
    this.init();
  },
};
</script>
var start_date = moment( time_now.setDate(time_now.getDate() - date)
).format("YYYYMMDD"); var end_date = moment( time_now.setDate(time_now.getDate()
+ till_end) ).format("YYYYMMDD");
