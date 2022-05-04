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
        data: [
          0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
          0, 0, 0, 0, 0, 0, 0, 0,
        ],
        backgroundColor: "transparent",
        borderColor: null,
        pointBackgroundColor: "rgba(171, 71, 188, 1)",
      },
      formatted_data: [],
    };
  },

  computed: {
    chart_date() {
      return this.filterMonth(this.formatted_data);
    },
  },
  watch: {
    timestamp() {
      (this.dataset = []),
        (this.label = []),
        (this.new_data = {
          label: "",
          data: [
            0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
            0, 0, 0, 0, 0, 0, 0, 0,
          ],
          backgroundColor: "transparent",
          borderColor: null,
          pointBackgroundColor: "rgba(171, 71, 188, 1)",
        }),
        (this.formatted_data = []),
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
        var new_index = this.chart_date[i].date - 1;
        this.new_data.data[new_index] = this.chart_date[i].total;
      }

      const time_now = new Date(this.timestamp);
      var year = moment(time_now).format("YYYY");
      var month = moment(time_now).format("MM");
      var m_e = new Date(Number(year), Number(month) + 0, 0);
      var qty_of_days = moment(m_e).format("DD");
      for (let i = 0; i < Number(qty_of_days); i++) {
        var m_s = new Date(Number(year), Number(month) - 1);
        m_s.setDate(m_s.getDate() + i);
        var changed_format = moment(m_s).format("D");
        this.label[i] = changed_format;
      }

      var month_full = moment(time_now).format("MMMM YYYY");
      this.new_data.label = month_full;

      this.dataset.push(this.new_data);
      this.new_data = {
        label: "",
        data: [
          0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
          0, 0, 0, 0, 0, 0, 0, 0,
        ],
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
        }
      );
    },
    filterMonth(formatted_data) {
      const time_now = new Date(this.timestamp);
      var year = moment(time_now).format("YYYY");
      var month = moment(time_now).format("MM");
      var m_e = new Date(Number(year), Number(month) + 0, 0);
      var m_s = new Date(Number(year), Number(month) - 1);
      var min = moment(m_s).format("YYYYMMDD");
      var max = moment(m_e).format("YYYYMMDD");

      return formatted_data.filter(
        (f_data) => f_data.full >= min && f_data.full <= max
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
