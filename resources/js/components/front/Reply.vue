<template>
    <ul class="comments-list">
        <li class="comment">
            <a class="pull-left" href="#">
                <img class="img-circle" v-bind:src="'img/profile/'+reply.user.photo" alt="avatar" style="width:35px;height: 35px;">
            </a>
            <div class="comment-body">
                <div class="comment-heading">
                    <h4 class="user">{{reply?reply.user.name:''}}</h4>
                    <h5 class="time">{{reply.updated_at | hour}}</h5>
                </div>
                <p>{{reply?reply.reply:''}}</p>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        props:['reply'],
        name: "Reply"
    }
</script>

<style scoped>

    .post .post-heading .meta .title a {
        color: black;
    }
    .post .post-heading .meta .title a:hover {
        color: #aaaaaa;
    }

    .post .post-description p {
        font-size: 14px;
    }
    .post .post-description .stats {
        margin-top: 20px;
    }
    .post .post-description .stats .stat-item {
        display: inline-block;
        margin-right: 15px;
    }
    .post .post-description .stats .stat-item .icon {
        margin-right: 8px;
    }
    .post .post-footer {
        border-top: 1px solid #ddd;
        padding: 15px;
    }
    .post .post-footer .input-group-addon a {
        color: #454545;
    }
    .post .post-footer .comments-list {
        padding: 0;
        margin-top: 20px;
        list-style-type: none;
    }
    .post .post-footer .comments-list .comment {
        display: block;
        width: 100%;
        margin: 20px 0;
    }
    .post .post-footer .comments-list .comment .avatar {
        width: 35px;
        height: 35px;
    }
    .post .post-footer .comments-list .comment .comment-heading {
        display: block;
        width: 100%;
    }
    .post .post-footer .comments-list .comment .comment-heading .user {
        font-size: 14px;
        font-weight: bold;
        display: inline;
        margin-top: 0;
        margin-right: 10px;
    }
    .post .post-footer .comments-list .comment .comment-heading .time {
        font-size: 12px;
        color: #aaa;
        margin-top: 0;
        display: inline;
    }
    .post .post-footer .comments-list .comment .comment-body {
        margin-left: 50px;
    }
    .post .post-footer .comments-list .comment > .comments-list {
        margin-left: 50px;
    }
</style>
