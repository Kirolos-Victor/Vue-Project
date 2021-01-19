<template>

    <div class="row">
        <div v-if="!$gate.isAdmin()" style="margin-left: 50px">
            <not-found></not-found>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cities Table</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search" >

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default" ><i class="fas fa-search"></i></button>
                                <span><button type="button" class="btn btn-success" @click.prevent="createModal">Create City</button></span>
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
                            <th>Governorate</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(city,index) in cities.data">
                            <td>{{city.id}}</td>
                            <td>{{city.name}}</td>
                            <td>{{city.governorate.name}}</td>
                            <td>{{city.created_at | date}}</td>
                            <td><button class="btn btn-primary"type="button" @click.prevent="updateModal(city,index)">Update</button>
                                <button class="btn btn-danger" type="button" @click.prevent="cityDelete(city,city.id,index)">Delete</button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="cities" @pagination-change-page="loadCities"></pagination>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <div class="modal fade" id="cityModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!allowUpdateModal" class="modal-title" id="exampleModalLabel">New City</h5>
                        <h5 v-show="allowUpdateModal" class="modal-title" >Update City</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="reset">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group" v-if="Validation">
                            <label>City Name</label>
                            <input type="text" name="name" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" required="required">
                            <has-error  :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group" v-else>
                            <label>City Name</label>
                            <input type="text" name="name" class="form-control" v-model="form.name">
                        </div>
                        <div class="form-group" v-if="Validation">

                           <select  v-model="form.governorate_id" class="form-control"  :class="{ 'is-invalid': form.errors.has('governorate_id') }"  name="governorate_id">
                               <option :value=undefined>-Select-</option>
                               <option v-for="governorate in governorates" :value="governorate.id">{{governorate.name}}</option>
                           </select>
                            <has-error  :form="form" field="governorate_id"></has-error>
                        </div>
                        <div class="form-group" v-else>
                            <select v-model="form.governorate_id" class="form-control"    name="governorate_id" >
                                <option :value=undefined>-Select-</option>
                                <option v-for="governorate in governorates" :value="governorate.id">{{governorate.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="reset()">Close</button>
                        <button v-show="!allowUpdateModal" type="button" class="btn btn-primary" @click.prevent="createCity()">Create</button>
                        <button v-show="allowUpdateModal" type="button" class="btn btn-primary" @click.prevent="updateCity()">Update</button>
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
                Validation:true,
                allowUpdateModal:false,
                cities:{
                    data:[]
                },
                governorates:{},
                currentPage:1,
                form:new Form({
                    id:'',
                    name:'',
                    governorate_id:undefined,
                }),
                updateIndex:'',


            }
        },
        methods:{

            loadCities(page = this.currentPage){
                this.$Progress.start();

                //we add $gate line to apply $gate.isAdmin() in the first line
                if(this.$gate.isAdmin()) {
                    Vue.axios.get('api/cities?page='+page).then(({data})=>{
                        this.cities=data;
                        this.$Progress.finish();

                        this.currentPage=data.current_page;
                    });
                }

            },
            reset(){
                this.Validation=false;

            },
            createModal(){
                this.allowUpdateModal=false;
                this.loadGover();
                $('#cityModal').modal('show');
                this.form.reset();
            },
            createCity(){
                this.$Progress.start();
                this.Validation=true;
                    $('#cityModal').modal('hide');
                    //Fire.$emit('reload');
                this.form.post('api/cities').then(({data})=> {
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated successfully'
                    });
                    //this.cities.data = {
                //...this.cities.data,
                  //      data
                //}
                    var cities= this.cities.data;
                        cities.push(data);
                    this.$Progress.finish();
                }).catch(()=>{
                    Toast.fire({
                        icon:'error',
                        title:'failed'
                    });
                    this.$Progress.fail();
                });
            },

            updateModal(city,index){
                this.allowUpdateModal=true;
                this.loadGover();
                $('#cityModal').modal('show');
                this.form.fill(city);
                this.updateIndex=index;

            },
            updateCity(){
                this.$Progress.start();
                this.Validation=true;
                this.form.put('api/cities/'+this.form.id).then(({data})=>{
                    $('#cityModal').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated successfully'
                    });
                    //Fire.$emit('reload');
                        var cities=this.cities.data
                                Vue.set(cities,this.updateIndex,data)
                    this.$Progress.finish();
                }).catch(()=>{
                    Toast.fire({
                        icon:'error',
                        title:'failed'
                    });
                    this.$Progress.fail();
                });
            },
            cityDelete(city,id,index){
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

                        this.form.delete('api/cities/'+id).then(()=>{
                            var cities=this.cities.data
                                   // Vue.delete(cities,index)
                            cities.splice(cities.indexOf(city),1)
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
            loadGover(){
                Fire.$emit('loadGov');
            }
        },
        name: "City",
        created() {
           Fire.$on('loadGov',()=>{
               Vue.axios.get('api/governor').then(({data})=>{
                   this.governorates=data.data;
               });
           });
            this.loadCities();
        },

    }
</script>

<style scoped>

</style>
