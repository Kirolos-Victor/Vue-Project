<template>

    <div class="card-body">
        <h3 class="text-center">Questions</h3>
        <loading-circule v-show="!loading" class="loading-question"></loading-circule>
        <div class="form-group" v-show="loading">
            <template v-if="questions.length > 0">
                <div class="row mt-2"  v-for="(question,index) in questions" :key="index">
                    <div class="col-10">
                        <a  class="form-control"  @click.prevent="openUpdateModal(question.id)">{{question.question}}</a>

                    </div>
                    <div class="col-2">
                        <button class="btn btn-danger" @click.prevent="deleteQuestion(question.id)"><i class="fas fa-backspace"></i>
                        </button>
                    </div>

                </div>
            </template>
            <template v-else>
                <div class="form-control" >
                    You dont have any questions yet!
                </div>
            </template>
        </div>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal">
            Add a question
        </button>

        <!--Create Modal -->
        <div class="modal" id="createModal" tabindex="-1" role="dialog" aria-labelledby="CreateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="CreateModalLabel">Create a question</h5>
                        <button type="button" class="close" @click.prevent="closeQuestionModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Question</label>
                            <input type="text"
                                   class="form-control"
                                   v-model="form.questionTitle"
                                   :class="{ 'is-invalid': form.errors.has('questionTitle') }">
                            <has-error  :form="form" field="questionTitle"></has-error>

                            <small class="form-text text-muted">Add your question title.</small>
                        </div>
                        <h3>Choices</h3>
                        <small class="form-text text-muted" style="margin-bottom:20px;">Add your answers, remember you are limited with 5 answers.</small>
                        <div class="form-group">
                            <template v-for="(choice,index) in choices">
                                <label>Choice {{index+1}}</label>
                              <div class="d-flex justify-content-between">
                                  <input type="text" class="form-control"
                                         v-model="form.answers[index]"
                                         :class="{ 'is-invalid': form.errors.has('answers') }">
                                  <button class="btn btn-danger ml-2" @click.prevent="deleteAnswer(index,form.answers[index])"><i class="fas fa-backspace"></i>
                                  </button>
                              </div>
                                <has-error  :form="form" field="answers"></has-error>
                            </template>
                            <small class="form-text text-danger" style="margin-bottom:20px;" v-show="answersLimit">Sorry, you can not add more answers.</small>

                            <button class="btn btn-dark mt-2" @click.prevent="addAnswer()">Add one more answer</button>

                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click.prevent="closeQuestionModal">Close</button>
                        <button type="button" class="btn btn-primary" @click.prevent="createQuestion">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Update Modal -->
        <div class="modal" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel">Question form</h5>
                        <button type="button" class="close" @click.prevent="CloseUpdateModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Question</label>
                            <h3 type="text"
                                class="form-control">{{questionUpdate.question}}</h3>

                        </div>
                        <h3>Choices</h3>
                        <div class="form-group">
                            <ul class="list-group" style="font-family: Arial;font-size: 16px">

                            <template v-for="(answer,index) in questionUpdate.answers">
                                    <label :for="answer[answer.id]">
                                <li  class="list-group-item list-group-item-action"  :id="answer[answer.id]">{{answer.answer}}</li>
                                    </label>
                                        <has-error  :form="form" field="answers"></has-error>
                            </template>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click.prevent="CloseUpdateModal">Close</button>
                        <button type="button" class="btn btn-danger" @click.prevent="deleteQuestion(questionUpdate.id)">Delete Question</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LoadingCircule from "../loading-circule";
    export default {
        components: {LoadingCircule},
        props:['questionnaire_id'],
        data(){
            return{
                loading: false,
                answersLimit:false,
                questions:{},
                questionUpdate:{},
                choices:[0,1],
                form:new Form({
                    questionTitle:'',
                    answers:[],
                }),

            }
        },
        methods:{
            loadQuestion(){
                Vue.axios.get(this.questionnaire_id+'/questions').then((data)=>{
                    this.questions=data.data;
                    this.loading= true;

                })
            },
            addAnswer(){
              if(this.choices.length===5){
                  this.answersLimit=true;
              }
              else{
                  this.choices.push(1);
              }
            },
            closeQuestionModal(){
                this.choices=[0,1];
                this.form.reset();

                this.answersLimit=false;
                $('#createModal').modal('hide');

            },
            CloseUpdateModal(){
                $('#updateModal').modal('hide');

            },
            openUpdateModal(id){
                Vue.axios.get('edit/'+id).then((data)=>{
                    this.questionUpdate=data.data;
                    $('#updateModal').modal('show');
                })

            },
            createQuestion(){
                this.form.post(this.questionnaire_id+'/questions').then(()=>{
                  Fire.$emit('reloadQuestions');
                  this.closeQuestionModal();
                }).catch(()=>{
                })
            },
            updateQuestion(){

            },
            deleteQuestion(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.$Progress.start();

                        Vue.axios.delete(id+'/questions').then(()=>{
                            Fire.$emit('reloadQuestions');
                            swal.fire(
                                'Deleted!',
                                'Your question has been deleted.',
                                'success'
                            );
                            this.CloseUpdateModal();
                            this.$Progress.finish();
                        }).catch(()=>{
                            swal.fire(
                                'Fail!',
                                'Something is wrong.',
                                'error'
                            );
                            this.$Progress.fail();
                        });

                    }
                });
            },
            deleteAnswer(id,answer){
                console.log(answer);
                if(this.choices.length > 2)
                {
                    this.choices.splice(id);
                    let index = this.form.answers.indexOf(answer);
                    this.form.answers.splice(index,1);

                }
                else{
                    alert('You must have at least two choices')
                }
            }


        },
        created(){
this.loadQuestion();
            Fire.$on('reloadQuestions',()=>{
                this.loadQuestion();
            });
        },

        name: "Question"
    }
</script>

<style scoped>
.loading-question{
    margin-left: 290px;
    margin-top:40px;
}
    a{
        cursor: pointer;
    }

</style>
