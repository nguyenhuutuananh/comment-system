<template>
  <ul class="comments-list">
    <li class="comment">
      <a href="#">
        <img class="avatar" src="http://bootdey.com/img/Content/user_1.jpg" alt="avatar">
      </a>
      <div class="comment-body">
        <div class="comment-heading">
          <div class="user">{{comment.user.name}}</div>
        </div>
        <p>{{comment.content}}</p>
        <div class="action-links">
          <span class="action-links__like">
            <i class="far fa-thumbs-up"></i> Thích
          </span>
          <span class="action-links__reply" @click="showReply">
            <i class="fas fa-reply"></i> Trả lời
          </span>
          <span class="time">
            <dynamic-from-now tag="div" :value="comment.created_at" transition="fade"></dynamic-from-now>
          </span>
        </div>
        <template v-if="subComments && subComments.length > 0">
          <comment-item
            :key="index"
            :comment="item"
            :sub-comments="item.comments"
            v-for="(item, index) in subComments"
            :post-id="postId"
            @onCallParentReply="showReply"
          ></comment-item>
        </template>
        <comment-box
          v-show="isShowCommentBox"
          v-if="!comment.parent_comment_id"
          :post-id="postId"
          :parent="comment.parent_comment_id || comment.id"
          :last-sub-comment-id="last_comment"
          @onReceiveComments="onReceiveComments"
          ref="commentBox"
        ></comment-box>
      </div>
    </li>
  </ul>
</template>
<script>
export default {
  props: ["comment", "subComments", "postId"],
  data() {
    return {
      last_comment: 0,
      isShowCommentBox: false,
    };
  },
  mounted() {},
  created() {
    this.setLastCommentId();
  },
  methods: {
    showReply (event) {
      if (this.subComments && this.subComments.length > 0) {
        this.isShowCommentBox = !this.isShowCommentBox;
        if (this.isShowCommentBox) {
          this.$refs.commentBox.focusInput();
        }
      } else {
        this.$emit('onCallParentReply');
      }
    },
    setLastCommentId() {
      if (this.comment.comments) {
        this.last_comment = this.comment.comments.length > 0 ? this.comment.comments[this.comment.comments.length-1].id : 0
      }
    },
    onReceiveComments(resp) {
      if (!this.comment.comments) {
        this.comment.comments = [];
      }
      this.comment.comments = _.concat(this.comment.comments, ...resp.data.comments.reverse());
      this.setLastCommentId();
    },
  }
};
</script>

<style lang="scss" scoped>
.comments-list {
  padding: 0;
  margin-top: 20px;
  list-style-type: none;
  .comment {
    display: flex;
    width: 100%;
    margin: 20px 0;
    .avatar {
      width: 35px;
      height: 35px;
    }
    .comment-heading {
      display: block;
      width: 100%;
      .user {
        font-size: 1rem;
        font-weight: bold;
        display: inline;
        margin-right: 10px;
      }
    }
    .comment-body {
      margin-left: 10px;
      width: 90%;
      p {
        overflow-wrap: break-word;
        width: 100%;
      }
      .action-links {
        &__like,
        &__reply {
          &:hover {
            text-decoration: underline;
          }
          cursor: pointer;
        }
        .time {
          font-size: 12px;
          color: #aaa;
          margin-top: 0;
          display: inline;
        }
      }
    }
    > .comments-list {
      margin-left: 50px;
    }
  }
}
</style>
