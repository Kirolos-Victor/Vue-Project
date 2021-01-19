<template>
<div class="row">
    <div v-if="!$gate.isAdmin()" style="margin-left: 50px">
        <not-found></not-found>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Product Table</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search" >

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default" ><i class="fas fa-search"></i></button>
                            <span><button type="button" class="btn btn-success" @click.prevent="createModal">Create Product</button></span>
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
                        <th>Price</th>
                        <th>Category</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in products.data">
                        <td>{{product.id}}</td>
                        <td><img v-bind:src="'img/T-shirts/' + product.photo" style="width: 50px;margin-right: 20px;">{{product.name}}</td>
                        <td>{{product.price}}</td>
                        <td><template v-for="( productCategory, index) in product.category">{{productCategory.name}}{{index+1< product.category.length?' ,':''}}</template></td>
                        <td>{{product.created_at | date}}</td>
                        <td><button class="btn btn-primary"type="button" @click.prevent="updateModal(product)">Update</button>
                            <button class="btn btn-danger" type="button" @click.prevent="deleteProduct(product.id)">Delete</button>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <pagination :data="products" @pagination-change-page="loadProducts"></pagination>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!allowUpdateModal" class="modal-title" id="exampleModalLabel">New Product</h5>
                    <h5 v-show="allowUpdateModal" class="modal-title" >Update Product</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="name" class="form-control" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" v-model="form.price" :class="{ 'is-invalid': form.errors.has('price') }">
                        <has-error :form="form" field="price"></has-error>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" multiple data-max-options="3" v-model="form.category_id"  name="category_id"
                                 :class="{ 'is-invalid': form.errors.has('category_id') }">
                            <option v-for="category in categories" :value="category.id">{{category.name}}</option>
                        </select>
                        <has-error :form="form" field="category_id"></has-error>
                    </div>
                    <div class="form-group">
                        <label>Photo</label>
                        <input type="file"  name="photo" class="form-control-file"  @change="uploadImage" :class="{ 'is-invalid': form.errors.has('photo') }">
                        <has-error :form="form" field="photo"></has-error>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button v-show="!allowUpdateModal" type="button" class="btn btn-primary" @click.prevent="createProduct()">Create</button>
                    <button v-show="allowUpdateModal" type="button" class="btn btn-primary" @click.prevent="updateProduct()">Update</button>
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
                products:{},
                categories:{},
                productPhoto:'',
                currentPage:1,
                allowUpdateModal:false,
                form:new Form({
                    id:'',
                    name:'',
                    price:'',
                    category_id:[],
                    photo:'',
                }),


            }
        },
        methods:{
           loadProducts(page = this.currentPage){
               this.$Progress.start();
               Vue.axios.get('api/product?page='+page).then((data)=>{
                   this.products=data;
                   this.$Progress.finish();
                   this.currentPage=data.current_page;
               })

           },
            createModal(){
                this.allowUpdateModal=false;
                $('#productModal').modal('show');
                this.form.reset();
            },
            uploadImage(e){
              // console.log('loading');
                let file = e.target.files[0];
                let reader = new FileReader();
                if(file['size'] < 2111775) {
                    reader.onloadend = ( file ) => {
                        //console.log('RESULT',reader.result);
                        this.form.photo = reader.result;
                    };
                    reader.readAsDataURL(file);
                }
                else{
                    swal.fire(
                        'Oops!',
                        'Sorry the image must be less than 2Mb.',
                        'error',
                    )

                }
            },
            createProduct(){
                this.$Progress.start();
                this.form.post('api/product').then(()=>{
                    $('#productModal').modal('hide');
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

            updateModal(product){
                this.allowUpdateModal=true;
                $('#productModal').modal('show');
                this.form.fill(product);
            },
            updateProduct(){
                this.$Progress.start();
                this.form.put('api/product/'+this.form.id).then(()=>{
                    $('#productModal').modal('hide');
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
            deleteProduct(id){
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

                        this.form.delete('api/product/'+id).then(()=>{
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
        created(){
            this.loadProducts(this.currentPage);
            Fire.$on('reload',()=>{
                this.loadProducts(this.currentPage);
            });
            Vue.axios.get('api/all-categories').then((data)=>{
                this.categories=data.data
            })


        },
        name: "Product.vue"
    }
</script>

<style scoped>

</style>
