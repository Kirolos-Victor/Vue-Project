<template>
    <div class="row">
        <div v-if="!$gate.isAdmin()" style="margin-left: 50px">
            <not-found></not-found>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Governorates Table</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search" autocomplete="off" @keypress="searchGovernorate" v-model="governorateName" >

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default" ><i class="fas fa-search"></i></button>
                                <span><button type="button" class="btn btn-success" @click.prevent="createModal">Create Governorate</button></span>
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
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(governorate,index) in governorates.data">
                            <td>{{governorate.id}}</td>
                            <td>{{governorate.name}}</td>
                            <td>{{governorate.created_at | date}}</td>
                            <td><button class="btn btn-primary"type="button" @click.prevent="updateModal(governorate,index)">Update</button>
                                <button class="btn btn-danger" type="button" @click.prevent="governorateDelete(governorate.id,index)">Delete</button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="governorates" @pagination-change-page="loadGovernorates"></pagination>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <div class="modal fade" id="governorateModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!allowUpdateModal" class="modal-title" id="exampleModalLabel">New Governorate</h5>
                    <h5 v-show="allowUpdateModal" class="modal-title" >Update Governorate</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                   <div class="form-group">
                       <label>Governement Name</label>
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
                governorates:{},
                governorateName:'',
                currentPage:1,
                form:new Form({
                    id:'',
                    name:'',
                }),
                governorateUpdateIndex:''

            }
        },
        methods:{
            searchGovernorate(){
                Fire.$emit('searchingGovernorate');
            },

            loadGovernorates(page = this.currentPage){
                //we add $gate line to apply $gate.isAdmin() in the first line
                this.$Progress.start();
                if(this.$gate.isAdmin()) {
                    Vue.axios.get('api/governorates?page='+page).then(({data})=>{
                        this.governorates=data;
                        this.$Progress.finish();
                        this.currentPage=data.current_page;
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
                this.form.post('api/governorates').then(({data})=>{
                    $('#governorateModel').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Created successfully'
                    });
                  this.governorates.data=
                      {
                      data,...this.governorates.data
                  }
                    this.$Progress.finish();
                }).catch(()=>{
                    Toast.fire({
                       icon:'error',
                       title:'failed'
                    });
                    this.$Progress.fail();
                });
            },

            updateModal(governorate,index){
                this.allowUpdateModal=true;
                $('#governorateModel').modal('show');
                this.form.fill(governorate);
                this.governorateUpdateIndex=index;
            },
            updateGovernorate(){
                this.$Progress.start();
                this.form.put('api/governorates/'+this.form.id).then(({data})=>{
                    $('#governorateModel').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated successfully'
                    });
                    Vue.set(this.governorates.data,this.governorateUpdateIndex,data)
                    this.$Progress.finish();
                }).catch(()=>{
                    Toast.fire({
                        icon:'error',
                        title:'failed'
                    });
                    this.$Progress.fail();

                });
            },
            governorateDelete(id,index){
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

                        this.form.delete('api/governorates/'+id).then(()=>{
                            Vue.delete(this.governorates.data,index);
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
        name: "Governorate",
        created() {
            this.loadGovernorates();

            Fire.$on('searchingGovernorate',()=>{
                if(this.governorateName.length > 1){
                    Vue.axios.get('api/governorates/'+this.governorateName).then((data)=>{
                        this.governorates=data.data;

                    })

                }
            })

        }
    }
</script>

<style scoped>

</style>
