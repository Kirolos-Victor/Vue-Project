<template>
    <div class="post-footer">
        <form>
            <div class="input-group">
                <img class="img-circle" v-bind:src="'img/profile/'+ userPhoto" alt="avatar" style="width:35px;height: 35px;margin-right: 10px;">
                <input  type="text" name="comment" class="form-control" v-model="comments.comment" required="required" autocomplete="off" placeholder="Write a comment..."
                        style="border-radius: 20px;margin-right: 10px;"
                        ref="commentFocus"
                >
                <has-error  :form="comments" field="comment"></has-error>
                <div class="input-group-append">
                    <button type="submit" class="fa fa-send form-control"  @click.prevent="addComment(post.id)" >Send</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props:['post','userPhoto'],
        data(){
            return{
                comments: new Form({
                    id:'',
                    comment:'',
                }),
            }
        },
        methods:{
            addComment(post_id){
                if(this.comments.comment ==='')
                {
                    this.$refs.commentFocus.focus();
                }
                else {
                this.$Progress.start();
                this.comments.post('api/comment?post_id='+post_id).then(()=>{
                    this.comments.reset();
                    Fire.$emit('loadPage');
                    this.$Progress.finish();
                }).catch(()=>{
                    this.$Progress.fail();

                })
                }
            },
        },

        name: "commentInput"
    }
</script>

<style scoped>

</style>
