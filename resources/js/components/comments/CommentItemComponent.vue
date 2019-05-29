<template>
  <ul class="comments-list">
    <li class="comment">
      <a href="#">
        <img class="avatar" src="http://bootdey.com/img/Content/user_1.jpg" alt="avatar">
      </a>
      <div class="comment-body">
        <div class="comment-heading">
          <h4 class="user">{{comment.user.name}}</h4>
        </div>
        <p>{{comment.content}}</p>
        <div class="action-links">
          <span class="action-links__like">
            <i class="far fa-thumbs-up"></i> Thích
          </span>
          <span class="action-links__reply">
            <i class="fas fa-reply"></i> Trả lời
          </span>
          <span class="time">{{comment.created_at}}</span>
        </div>
        <comment-box :post-id="postId"></comment-box>
        <template v-if="subComments && subComments.length > 0">
          <comment-item
            :key="index"
            :comment="item"
            :sub-comments="item.comments"
            v-for="(item, index) in subComments"
            :post-id="postId"
          ></comment-item>
        </template>
      </div>
    </li>
  </ul>
</template>
<script>
export default {
  props: ["comment", "subComments", "postId"]
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
                font-size: 14px;
                font-weight: bold;
                display: inline;
                margin-top: 0;
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
                &__like, &__reply {
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
