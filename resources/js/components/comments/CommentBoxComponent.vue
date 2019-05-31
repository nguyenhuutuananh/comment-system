<template>
  <div class="input-group">
    <input
      v-on:keyup.13="comment"
      class="form-control"
      v-model="message"
      placeholder="Add a comment"
      type="text"
      ref="commentInput"
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
import _ from "lodash";
export default Vue.extend({
  props: {
    postId: {
      type: Number
    },
    parent: {
      type: Number
    },
    lastSubCommentId: {
      type: Number,
    }
  },
  data() {
    return {
      message: ""
    };
  },
  methods: {
    focusInput() {
      console.log(this.$refs.commentInput);
      setTimeout(_ => this.$refs.commentInput.focus());
    },
    comment: _.debounce(function(event) {
      if (this.message.trim() === "") return;
      let params = {
        content: this.message,
        parent_comment_id: this.parent,
        post_id: this.postId
      };
      if (this.lastSubCommentId) {
        params.last_seen_comment_id = this.lastSubCommentId;
      }
      axios
        .post("/comments", params)
        .then(resp => {
          this.$emit('onReceiveComments', resp);
        })
        .finally(() => {
          this.message = "";
        });
    }, 500)
  }
});
</script>
