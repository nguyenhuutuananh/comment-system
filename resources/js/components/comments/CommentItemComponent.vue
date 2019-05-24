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
        <template v-if="subComments && subComments.length > 0">
          <comment-item
            :key="index"
            :comment="item"
            :sub-comments="item.comments"
            v-for="(item, index) in subComments"
          ></comment-item>
        </template>
      </div>
      <!-- <ul class="comments-list">
        <li class="comment">
          <a class="pull-left" href="#">
            <img class="avatar" src="http://bootdey.com/img/Content/user_3.jpg" alt="avatar">
          </a>
          <div class="comment-body">
            <div class="comment-heading">
              <h4 class="user">Ryan Haywood</h4>
              <h5 class="time">3 minutes ago</h5>
            </div>
            <p>Relax my friend</p>
          </div>
        </li>
        <li class="comment">
          <a class="pull-left" href="#">
            <img class="avatar" src="http://bootdey.com/img/Content/user_2.jpg" alt="avatar">
          </a>
          <div class="comment-body">
            <div class="comment-heading">
              <h4 class="user">Gavino Free</h4>
              <h5 class="time">3 minutes ago</h5>
            </div>
            <p>Ok, cool.</p>
          </div>
        </li>
      </ul>-->
    </li>
  </ul>
</template>
<script>
export default {
  props: ["comment", "subComments"]
};
</script>