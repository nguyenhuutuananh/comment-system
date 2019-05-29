<template>
  <div class="input-group">
    <input
      v-on:keyup.13="comment"
      class="form-control"
      v-model="message"
      placeholder="Add a comment"
      type="text"
    >
    <div class="input-group-append">
      <span @click="comment" class="input-group-text">
        <i class="fa fa-edit"></i>
      </span>
    </div>
  </div>
</template>
<script lang="ts">
import Vue from "vue";
import axios from "axios";
export default Vue.extend({
  props: ["postId"],
  data() {
    return {
      message: ""
    };
  },
  methods: {
    comment: function(event) {
      if (this.message.trim() === "") return;
      console.log(this.message, this.postId);
      axios
        .post("/comments", {
          content: this.message,
          post_id: this.postId
        })
        .then(resp => {
          console.log(resp);
          this.comments.push(resp.data);
        })
        .finally(() => {
          this.message = "";
        });
    }
  }
});
</script>
