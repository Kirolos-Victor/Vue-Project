<template>
    <div class="form-group">
        <div class="col-sm-8"  >
            <div class="comment-wrapper">
                <div class="panel panel-info">
                    <form>
                        <div class="panel-body">
                            <textarea class="form-control" placeholder="Write a post..." rows="3" v-model="post.Content"  :class="{ 'is-invalid': post.errors.has('Content') }" @click="postModal()" ></textarea>
                            <has-error  :form="post" field="Content"></has-error>
                            <br>
<!--                            <button type="submit" class="btn btn-info pull-right" @click.prevent="addPost()">Post</button>

 -->                            <div class="clearfix"></div>
                            <hr>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-white post panel-shadow" v-for="post in posts.data"  :key="post.id" >
                <div class="post-heading">
                    <div class="pull-left image">
                        <img v-bind:src="'img/profile/' + post.user.photo" class="img-circle avatar" alt="user profile image">
                    </div>

                    <div class="pull-left meta">

                        <div class="title h5">
                            <a href="#"><b>{{post.user.name}}  </b></a>
                            made a post.
                        </div>

                        <!-- | hour is called filter and we can stack many filters at the same time-->
                        <h6 class="text-muted time">{{post.created_at | hour}}</h6>
                    </div>
                </div>
                <div class="post-description">
                    <p>{{post.content}}</p>
                    <div class="stats">
                        <button class="btn btn-default stat-item"  @click.prevent="addLike(post.id)">
                            <i class="fa fa-thumbs-o-up" aria-hidden="false" style="color: blue" v-bind:style="likedBythisUser(post)?'color: blue;':'color: gray;'"  > Like &nbsp;{{post.likes.length}}
                            </i> <!-- here is the duplicate problem-->
                        </button>
                        <a class="btn btn-default stat-item" @click.prevent>
                            <i class="fa fa-reply-all" v-html="countComments(post.comments)"></i> Comments
                        </a>
                    </div>
                </div>
                <comment-input :post="post"  :userPhoto="userPhoto"></comment-input>
                <ul class="comments-list" v-for="comment in post.comments?post.comments:''">
                    <comments :comment="comment"  :userPhoto="userPhoto"></comments>
                </ul>
            </div>
            <pagination :data="posts" @pagination-change-page="loadPosts"></pagination>
            <hr>
            <!-- Post Modal -->
            <div class="modal fade" id="postModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"   >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <textarea class="form-control" v-bind:placeholder="'What is on your a mind, '+name+'?'" rows="3" v-model="post.Content"  :class="{ 'is-invalid': post.errors.has('Content') }"  id="postFocus" ref="postFocus"></textarea>
                            <has-error  :form="post" field="Content"></has-error>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info pull-right" @click.prevent="addPost()">Post</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        //if you want to use the data in props in your axios request or add url parameters add them like this Axios.post('api/like',{id:this.post.id})
        props:['id','name'],
        data(){
            return{
                posts:{},
                userPhoto:'',
                page:1,
                show: false,
                post : new Form({
                    id:'',
                    Content:'',
                })
            }
        },
        methods:{
            postModal() {
                $('#postModal').modal('show');
                $('#postModal').on('shown.bs.modal', function () {
                    $('#postFocus').trigger('focus')
                });
            },
            //the problem was we used this.loadPosts in created so when the page load it requested data twice one from created and the other
            // one from infinite loading component SO you have to remove loadPosts methods from created() on rely on <infinity-loading> only
            loadPosts(page = this.page){
                Vue.axios.get('api/post?page='+page).then(({data})=>{
                    this.posts=data;
                    this.page=data.current_page;
                });
            },
            addPost(){
                if(this.post.Content ==='')
                {
                    setTimeout(() => {
                        this.$refs.postFocus.focus();
                    }, 0);
                }
                else {
                    this.$Progress.start();
                    this.post.post('api/post').then(()=>{
                        $('#postModal').modal('hide');
                        this.post.reset();
                        Fire.$emit('loadPage');
                        Toast.fire({
                            icon: 'success',
                            title: 'Created successfully'
                        });
                        this.$Progress.finish();
                    }).catch(()=>{
                        this.$Progress.fail();

                    })
                }

            },
            addLike(post_id){
                Vue.axios.post('api/like',{
                    post_id:post_id,
                }).then(()=>{
                    Fire.$emit('loadPage');
                })
            },
            likedBythisUser(post){
                return post.likes.find(like=>{
                    return like.user_id===this.id && like.post_id===post.id;
                }) // return a boolean value
            },
            countComments(comments){
                const numberOfComments =comments.length;
                return numberOfComments;
            }

        },
        name: "Post",
        created() {
            Vue.axios.post('/user_photo').then((data)=>{
                this.userPhoto=data.data;
            });
            this.loadPosts();
            Fire.$on('loadPage',()=>{
                this.loadPosts();
            });

        },

    }
</script>

<style scoped>
    .panel-shadow {
        box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
    }
    .panel-white {
        border: 1px solid #dddddd;
    }
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
