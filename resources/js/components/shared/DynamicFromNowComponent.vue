<template>
<span :title="value">{{fromNow}}</span>
</template>
<script>
var Clock = new Vue({
  created() {
    this.listeners = 0; // set non-reactive counter
  },
  methods: {
    start() {
      this.interval = setInterval(this.emit, 10000);
    },
    emit() {
      this.$emit("tick");
    },
    register(cb) {
      if (!cb) return;
      if (this.listeners === 0) {
        this.start(); //start clock
      }
      this.listeners++;
      this.$on("tick", cb);
    },
    unregister(cb) {
      if (!cb) return;
      this.listeners--;
      this.$off("tick", cb);
      if (this.listeners === 0) {
        clearInterval(this.interval); // turn off clock
      }
    }
  }
});
export default {
  props: {
    tag: { type: String, default: "span" },
    value: { type: String, default: () => moment().toISOString() },
    dropFixes: {
      default: false,
      type: Boolean
    },
    interval: { type: Number, default: 1000 }
  },
  data() {
    return { fromNow: moment(this.value).fromNow(this.dropFixes) };
  },
  mounted() {
    Clock.register(this.updateFromNow);
    this.$watch("value", this.updateFromNow);
  },
  beforeDestroy() {
    Clock.unregister(this.intervalId);
  },
  methods: {
    updateFromNow() {
      var newFromNow = moment(this.value).fromNow(this.dropFixes);
      if (newFromNow !== this.fromNow) {
        this.fromNow = newFromNow;
      }
    }
  },
};
</script>
