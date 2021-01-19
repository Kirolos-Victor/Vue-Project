<template>
    <div>
        <pie-chart :data="answers"></pie-chart>
    </div>
</template>

<script>
    export default {
        props:['question'],
        data(){
            return{
                questions:this.question,
                answers:[],
            }
        },
        methods:{
          loadAnswers(){
               this.questions.answers.forEach(answer=>{
                   this.answers.push([answer.answer,answer.responses.length * 100 /this.questions.responses.length])
               }) // return a boolean value
          }
        },
        created(){
            this.loadAnswers();
        },

        name: "AnswerChart"
    }
</script>

<style scoped>

</style>
