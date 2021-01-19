<template>
                <div class="post-footer">
                    <ul class="comments-list" style="position: relative;right: 40px">
                        <li class="comment">
                            <a class="pull-left" href="#">
                                <img class="img-circle" v-bind:src="'img/profile/'+comment.user.photo" alt="avatar" style="width:35px;height: 35px;">
                            </a>
                            <div class="comment-body">
                                <div class="comment-heading">
                                    <h4 class="user">{{comment.user?comment.user.name:''}}</h4>
                                    <h5 class="time">{{comment.created_at | hour}}</h5>
                                </div>
                                <p>{{comment.comment}}</p>
                            </div>
                            <anchorAllReply :comment="comment" :userPhoto="userPhoto">
                            </anchorAllReply>
                        </li>
                    </ul>
                </div>
</template>
<script>
    let allReply={
        data(){
            return{
                showAnchor:true,
                showInput:false,
                replies:{},
                replyForm: new Form({
                    id:'',
                    reply:'',
                }),

            }
        },
        template:`<div class="comment-body"><form>
 <a href="" style="position:relative;"   @click.prevent="showAnchor?loadReplies(comment.id):setFocus();"  >Reply</a>                            <br>
<a href="" style="position:relative;left:150px;"  @click.prevent="loadReplies(comment.id)" v-if="comment.reply.length !== 0" v-show="showAnchor" v-text="comment.reply.length > 1 ?' '+comment.reply.length+' Replies':' 1 Reply'"></a>
                                <replies v-if="replies"  v-for="(reply,index) in replies" :reply="reply" :key="index"></replies>  <div class="input-group" v-show="showInput">
                                                                <img class="img-circle" v-bind:src="'img/profile/'+ userPhoto" alt="avatar" style="width:35px;height: 35px;margin-right: 10px;">
<input type="text" name="reply" class="form-control" v-model="replyForm.reply" :class="{ 'is-invalid': replyForm.errors.has('reply') }" required="required" placeholder="Write a reply..." ref="replyFocus"  style="border-radius: 20px;margin-right: 10px;" autocomplete="off">
                                                <has-error  :form="replyForm" field="reply"></has-error>
                                                <span class="input-group-addon">
                                        <button type="submit" class="fa fa-send form-control"  @click.prevent="addReply(comment.id)" >Send</button>
                        </span>
                                            </div></form></div>`,
        props:['comment','userPhoto'],
        methods:{
            loadReplies(comment_id){
                axios.get('api/reply?comment_id='+comment_id).then((data)=>{
                    this.replies=data.data;
                    this.showAnchor=false;
                    this.showInput=true;
                    Fire.$on('loadReply',()=>{
                        this.loadReplies(comment_id);
                    });
                })
            },
            addReply(comment_id){
                if(this.replyForm.reply ===''){
                    this.setFocus();
                }
                else{
                    this.$Progress.start();
                    this.replyForm.post('api/reply?comment_id='+comment_id).then(()=>{
                        this.replyForm.reset();
                        Fire.$emit('loadReply');
                        this.$Progress.finish();
                    }).catch(()=>{
                        this.$Progress.fail();

                    })
                }

            },
            setFocus()
            {
                // Note, you need to add a ref="search" attribute to your input.
                setTimeout(() => {
                    this.$refs.replyFocus.focus();
                }, 0);
            },
        },

    };
    export default {
        props:['comment','userPhoto'],
        data(){
            return{
            }
        },
        methods:{
            loadReplies(comment_id){
                axios.get('api/reply?comment_id='+comment_id).then((data)=>{
                    this.replies=data.data;
                })
            }
        },
        components:{
            anchorAllReply:allReply,

        },
        name: "Comment"
    }
</script>

<style scoped>

    .panel-white  .panel-heading {
        color: #333;
        background-color: #fff;
        border-color: #ddd;
    }
    .panel-white  .panel-footer {
        background-color: #fff;
        border-color: #ddd;
    }

    .post .post-heading {
        height: 95px;
        padding: 20px 15px;
    }
    .post .post-heading .avatar {
        width: 60px;
        height: 60px;
        display: block;
        margin-right: 15px;
    }
    .post .post-heading .meta .title {
        margin-bottom: 0;
    }
    .post .post-heading .meta .title a {
        color: black;
    }
    .post .post-heading .meta .title a:hover {
        color: #aaaaaa;
    }
    .post .post-heading .meta .time {
        margin-top: 8px;
        color: #999;
    }
    .post .post-image .image {
        width: 100%;
        height: auto;
    }
    .post .post-description {
        padding: 15px;
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
