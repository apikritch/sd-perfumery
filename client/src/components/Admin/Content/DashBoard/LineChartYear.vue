<script>
import { Line } from "vue-chartjs/legacy";

export default {
  extends: Line,
  props: { dashboard_year: Array },
  data() {
    return {
      dataset: [],
      new_data: {
        label: 0,
        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
        backgroundColor: "transparent",
        borderColor: "rgba(1, 116, 188, 0.50)",
        pointBackgroundColor: "rgba(171, 71, 188, 1)",
      },
    };
  },
  methods: {
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
    for (let i = 0; i < this.dashboard_year.length; i++) {
      var whichYear;
      var existing = this.dataset.filter((item, index) => {
        if (item.label == this.dashboard_year[i].year) {
          whichYear = index;
          return true;
        } else {
          return false;
        }
      });
      var new_index = this.dashboard_year[i].month - 1;
      if (existing.length) {
        this.dataset[whichYear].data[new_index] = this.dashboard_year[i].total;
      } else {
        this.new_data.borderColor = this.getRandom();
        this.new_data.label = this.dashboard_year[i].year;
        this.new_data.data[new_index] = this.dashboard_year[i].total;

        this.dataset.push(this.new_data);
        this.new_data = {
          label: 0,
          data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
          backgroundColor: "transparent",
          borderColor: null,
          pointBackgroundColor: "rgba(171, 71, 188, 1)",
        };
      }
    }
    this.renderChart(
      {
        labels: [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December",
        ],
        datasets: this.dataset,
      },
      {
        responsive: true,
        maintainAspectRatio: false,
      }
    );
  },
};
</script>
