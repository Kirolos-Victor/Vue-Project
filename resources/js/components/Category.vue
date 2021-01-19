<template>
    <div class="row">
        <div v-if="!$gate.isAdmin()" style="margin-left: 50px">
            <not-found></not-found>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories Table</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm">

                            <div class="input-group-append">
                                <span><button type="button" class="btn btn-success" @click.prevent="createModal">Create Category</button></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Active</th>
                            <th>Created Date</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="category in categories">
                            <td>{{category.id}}</td>
                            <td>{{category.name}}</td>
                            <td v-if="category.product.length>0">Not Empty</td>
                            <td v-else>Empty</td>
                            <td>{{category.created_at | date}}</td>
                            <td><button class="btn btn-primary" type="button" @click.prevent="updateModal(category)">Update</button>
                                <button class="btn btn-danger" type="button" @click.prevent="governorateDelete(category.id)">Delete</button>
                            </td>
                            <td>
                                <toggle-button @change="toggleCategoryStatus(category.id)" :value="category.status" />
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="modal fade" id="governorateModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!allowUpdateModal" class="modal-title" id="exampleModalLabel">New Category</h5>
                    <h5 v-show="allowUpdateModal" class="modal-title" >Update Category</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                   <div class="form-group">
                       <label>Category Name</label>
                       <input type="text" name="name" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                       <has-error :form="form" field="name"></has-error>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button v-show="!allowUpdateModal" type="button" class="btn btn-primary" @click.prevent="createGovernorate()">Create</button>
                    <button v-show="allowUpdateModal" type="button" class="btn btn-primary" @click.prevent="updateGovernorate()">Update</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>

    export default {
        data(){
            return{
                allowUpdateModal:false,
                categories:{},
                form:new Form({
                    id:'',
                    name:'',
                }),

            }
        },
        methods:{
            toggleCategoryStatus(id){
                Vue.axios.get('api/categories/'+id)

            },
            loadCategories(){
                //we add $gate line to apply $gate.isAdmin() in the first line
                this.$Progress.start();
                if(this.$gate.isAdmin()) {
                    Vue.axios.get('api/categories').then((data)=>{
                        this.categories=data.data;
                        this.$Progress.finish();
                    });
                }

            },
            createModal(){
                this.allowUpdateModal=false;
                $('#governorateModel').modal('show');
                this.form.reset();
            },
            createGovernorate(){
                this.$Progress.start();
                this.form.post('api/categories').then(()=>{
                    $('#governorateModel').modal('hide');
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

            updateModal(governorate){
                this.allowUpdateModal=true;
                $('#governorateModel').modal('show');
                this.form.fill(governorate);
            },
            updateGovernorate(){
                this.$Progress.start();
                this.form.put('api/categories/'+this.form.id).then(()=>{
                    $('#governorateModel').modal('hide');
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
            governorateDelete(id){
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

                        this.form.delete('api/categories/'+id).then(()=>{
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
        name: "Category",
        created() {
            this.loadCategories();
            Fire.$on('reload',()=>{
                this.loadCategories();
            });


        }
    }
</script>

<style scoped>

</style>
