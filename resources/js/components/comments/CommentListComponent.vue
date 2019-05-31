<template>
  <div>
    <comment-box
      :post-id="postId"
      :last-sub-comment-id="last_comment"
      @onReceiveComments="onReceiveComments"
    ></comment-box>
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
      comments: [],
      last_comment: 0
    };
  },
  created() {},
  mounted() {
    axios.get("/comments").then(resp => {
      this.comments = resp.data.data
        .map(comment => {
          comment.comments = comment.comments.reverse();
          return comment;
        })
        .reverse();
      this.setLastCommentId();
    });
  },
  methods: {
    setLastCommentId() {
      if (this.comments) {
        this.last_comment =
          this.comments.length > 0
            ? this.comments[this.comments.length - 1].id
            : 0;
      }
    },
    onReceiveComments(resp) {
      if (!this.comments) {
        this.comments = [];
      }
      this.comments = _.concat(this.comments, ...resp.data.comments.reverse());
      this.setLastCommentId();
    }
  }
};
</script>