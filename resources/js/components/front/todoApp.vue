<template>
    <section class="todoapp" >
        <header class="header">
            <h1>todos</h1>
            <input class="new-todo"
                   autocomplete="off"
                   placeholder="What needs to be done?"
            @keyup.enter="addTodo()" v-model="title">
        </header>
        <section class="main" >
            <input class="toggle-all" id="toggle-all" type="checkbox" v-model="allDone">
            <label for="toggle-all">Mark all as complete</label>

            <ul class="todo-list">
                <li class="todo" v-for="todo in filterTodos" :class="{completed:todo.completed,editing:todo==editingTodo}">
                    <div class="view">
                        <input class="toggle" type="checkbox" v-model="todo.completed">
                        <label @dblclick="editTodo(todo)">{{ todo.title }}</label>
                        <button class="destroy" @click="deleteTodo(todo)"></button>
                    </div>
                    <input class="edit" type="text" v-model="todo.title" @keyup.enter="doneEditing()" @keyup.esc="cancelEditing()">
                </li>
            </ul>
        </section>
        <footer class="footer">
    <span class="todo-count">
      <strong>{{itemsLeft}}</strong> item left
    </span>
            <ul class="filters">
                <li><a href="#/all" @click.prevent="filterType='all'" :class="{selected:filterType=='all'}">All</a></li>
                <li><a href="#/active" @click.prevent="filterType='active'" :class="{selected:filterType=='active'}" >Active</a></li>
                <li><a href="#/completed" @click.prevent="filterType='completed'" :class="{selected:filterType=='completed'}">Completed</a></li>
            </ul>
            <button class="clear-completed" @click.prevent="clearCompleted()">
                Clear completed
            </button>
        </footer>
    </section>

</template>

<script>
export default {
    name: "todoApp",
    data(){
        return{
            filterType:'all',
            title:'',
            itemsLeft:0,
            editingTodo:null,
            oldTodoTitle:'',
            todos:[
                {title:'test1',completed:true},
                {title:'test2',completed:false}
            ]

        }
    },
    methods:{
        addTodo(){
            if(this.title ==='')
            {
                return alert('enter a text');
            }
            this.todos.push({title:this.title,completed: false});
            this.title='';
        },
        deleteTodo(todo){
            this.todos.splice(this.todos.indexOf(todo),1)

        },
        clearCompleted(){
          this.todos=this.todos.filter((todo)=>{
              return !todo.completed;
          })
        },
        editTodo(todo){
            this.editingTodo=todo;
            this.oldTodoTitle=todo.title;

        },
        doneEditing(){

            if(this.editingTodo.title ==='')
            {
                this.todos.splice(this.todos.indexOf(this.editingTodo),1)
            }
                this.editingTodo=null;
        },
        cancelEditing(){
            this.editingTodo.title=this.oldTodoTitle;
            this.editingTodo=null;


        }





    },
    computed:{
        countItemsLeft(){

         var itemsLeft= this.todos.filter((todo)=>{
                return !todo.completed
            })
           return  this.itemsLeft=itemsLeft.length;
        },
        filterTodos(){
            if(this.filterType==='active'){
                return this.todos.filter((todo)=>{
                    return !todo.completed
                });
                }
            else if(this.filterType ==='completed') {
                return this.todos.filter((todo)=>{
                    return todo.completed
                })
            }
            else{
                return this.todos;
            }
},
        allDone: {
            get: function(){
                return this.itemsLeft === 0;
            },
            set: function(value){
                this.todos.forEach(function(todo){
                    todo.completed = value;
                });
            }
        }


    },
    created() {

    }
}
</script>

<style scoped>

</style>
