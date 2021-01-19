<template>
    <div class="row">
        <div v-if="!$gate.isAdmin()" style="margin-left: 50px">
            <not-found></not-found>
        </div>
        <div class="col-12"  v-if="$gate.isAdmin()">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users Table</h3>

                    <div class="card-tools">

                        <div class="input-group input-group-sm">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search" v-model="search" @keypress="searchUser">

                            <div class="input-group-append">
                                <button @click="searchUser()" class="btn btn-default" ><i class="fas fa-search" ></i></button>
                                <span> <button type="button" @click.prevent class="btn btn-success" @click="createModal">Create User <i class="fas fa-user-plus"></i></button></span>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users.data" :key="user.id">
                            <td>{{user.id}}</td>
                            <td>{{user.name}}</td>
                            <td>{{user.email | upText}}</td>
                            <td>{{user.type}}</td>
                            <td>{{user.created_at | date}}</td>
                            <td>
                                <a href="#">
                                    <i class="fa fa-edit" @click="updateModal(user)"></i>
                                </a>
/                                <a href="#">
                                    <i class="fa fa-trash text-red" @click="deleteUser(user.id)"></i>
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <pagination :data="users" @pagination-change-page="loadUsers"></pagination>
                    <button @click="printPage()">Print</button>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!--Create User Modal -->
        <div class="modal fade" id="userModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="editMode" class="modal-title" >Update User</h5>

                        <h5  class="modal-title" v-show="!editMode" id="userModelLabel">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode? updateModal():createModal()">
                    <div class="modal-body">
                        <!-- name -->
                        <div class="form-group">
                            <input v-model="form.name" type="text" name="name" placeholder="Name..."
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <!-- email -->

                        <div class="form-group">
                            <input v-model="form.email" type="email" name="email" placeholder="E-mail..."
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <!-- password -->

                        <div class="form-group">
                            <input v-model="form.password" type="text" name="password" placeholder="Password..."
                                   class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                        </div>
                        <!-- type -->

                        <div class="form-group">
                            <select v-model="form.type"  name="type"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                <option :value=undefined>-Select-</option>
                                <option value="admin" selected>Administrator</option>
                                <option value="user">Standard User</option>
                                <option value="author">Author</option>
                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                        <!-- bio -->

                        <div class="form-group">
                            <textarea v-model="form.bio" type="text" name="bio" placeholder="short bio for user (Optional)"
                                      class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                            <has-error :form="  form" field="bio"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-show="!editMode" type="button" class="btn btn-primary" @click.prevent="createUser()">Create</button>
                        <button v-show="editMode" type="button" class="btn btn-primary" @click.prevent="updateUser">Update</button>

                    </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
    <!-- /.row -->

</template>

<script>
    export default {

        data() {
            return {
                search:'',
                editMode :false,
                users:{},
                currentPage:1,
                // Create a new form instance
                form: new Form({
                    id:'',
                    name: '',
                    email: '',
                    password: '',
                    type:undefined,
                    photo:'',
                    bio:'',
                })
            }
        },
        methods:{
            printPage(){
                window.print();
            },
            searchUser(){
                Fire.$emit('searching');

            },
            loadUsers(page = this.currentPage){
                this.$Progress.start();

                //we add $gate line to apply $gate.isAdmin() in the first line
                if(this.$gate.isAdmin()) {
                    Vue.axios.get('api/users?page='+page).then(({data})=>{
                        this.users=data;
                        this.$Progress.finish();
                        this.currentPage=data.current_page;
                    });
                }

            },
            createModal(){
                this.editMode=false;
                $('#userModel').modal('show');
                this.form.reset();
            },
            createUser(){
                this.$Progress.start();
                this.form.post('api/users').then(()=>{
                    $('#userModel').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Created successfully'
                    });
                    Fire.$emit('reload');
                    this.$Progress.finish();
                }).catch(()=>{
                    Toast.fire({
                        icon:'error',
                        title:'failed'
                    });
                    this.$Progress.fail();
                });
            },

            updateModal(user){
                this.editMode=true;
                $('#userModel').modal('show');
                this.form.fill(user);
            },
            updateUser(){
                this.$Progress.start();
                if(this.form.password ==="") {
                    this.form.password = undefined;
                }
                this.form.put('api/users/'+this.form.id).then(()=>{
                    $('#userModel').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated successfully'
                    });
                    Fire.$emit('reload');
                    this.$Progress.finish();
                }).catch(()=>{
                    Toast.fire({
                        icon:'error',
                        title:'failed'
                    });
                    this.$Progress.fail();

                });
            },
            deleteUser(id){
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

                        this.form.delete('api/users/'+id).then(()=>{
                            Fire.$emit('reload');
                            swal.fire(
                                'Deleted!',
                                'Your record has been deleted.',
                                'success'
                            );
                            this.$Progress.finish();
                        }).catch(()=>{
                            Swal.fire(
                                'Fail!',
                                'Something is wrong.',
                                'error'
                            );
                            this.$Progress.fail();
                        });
                    }
                });
            },
        },
        //THIS IS SO FKING IMPORTANT YOU STUPID FUCK WE PUT created function its Built in function outside
        // the methods to load the custom function you built inside the method
        created() {
            this.loadUsers();
            Fire.$on('reload', () =>{
                this.loadUsers();
            });
            Fire.$on('searching',()=>{
                if(this.search.length > 0){
                    axios.get('api/search?q='+this.search).then((data)=>{
                        this.users=data.data;
                    }).catch()
                }
            });


        },
        name: "Users"
    }
</script>

<style scoped>

</style>
