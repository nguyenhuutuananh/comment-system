<template>
  <div>
    <comment-box :post-id="postId"></comment-box>
    <comment-item
      :key="index"
      v-for="(item, index) in comments"
      :comment="item"
      :sub-comments="item.comments"
      :post-id="postId"
    ></comment-item>
  </div>
</template>
<script>
export default {
  props: ["postId"],
  data() {
    return {
      comments: []
    };
  },
  mounted() {
    console.log(this.postId);
    axios.get("/comments").then(resp => {
      this.comments = resp.data.data
        .map(comment => {
          comment.comments = comment.comments.reverse();
          return comment;
        })
        .reverse();
    });
  }
};
</script>