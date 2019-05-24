<template>
  <div>
    <comment-item
      :key="index"
      v-for="(item, index) in comments"
      :comment="item"
      :sub-comments="item.comments"
    ></comment-item>
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
  </div>
</template>
<script>
export default {
  props: ["postId"],
  data() {
    return {
      message: "",
      comments: []
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
  },
  mounted() {
    axios.get("/comments").then(resp => {
      this.comments = resp.data.data.reverse();
    });
  }
};
</script>