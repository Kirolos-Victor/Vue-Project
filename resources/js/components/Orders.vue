<template>
    <div class="row">
        <div v-if="!$gate.isAdmin()" style="margin-left: 50px">
            <not-found></not-found>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Orders Table</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search" >
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Purchaser Name</th>
                            <th>Created Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="order in orders.data">
                            <td>{{order.id}}</td>
                            <td>{{order.user.name}}</td>
                            <td>{{order.created_at | date}}</td>
                            <td>
                                <button class="btn btn-primary" @click.prevent="showCart(order.id)" data-toggle="modal" data-target="#exampleModalLong">    <span class="fas fa-shopping-cart">Cart</span></button>
                                <button class="btn btn-danger" type="button" @click.prevent="deleteOrder(order.id)">Delete</button>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="orders" @pagination-change-page="loadOrders"></pagination>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ITEMS ({{cart.totalQty}})</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead class="table-active">
                            <tr>
                                <th>PRODUCT</th>
                                <th>QUANTITY</th>
                                <th>UNIT PRICE</th>
                                <th>SUBTOTAL</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in cart.items">
                                <td>
                                    <img :src="'img/T-shirts/'+item['photo']" alt="Product 1" class="img-circle img-size-32 mr-2">
                                    {{item['name']}}
                                </td>
                                <td>{{item['Qty']}}</td>
                                <td>
                                    ${{item['price']}}
                                </td>
                                <td>
                                    ${{item['qtyPrice']}}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                                    <table class="table no-border" >
                                        <tr>
                                            <th>Total Paid:</th>
                                            <td>$ {{cart.totalPrice}}</td>
                                        </tr>
                                    </table>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                orders:{},
                cart:{},
                currentPage:1,
                form:new Form({
                    id:'',
                    name:'',
                }),
            }
        },
        methods:{
            loadOrders(page = this.currentPage){
                this.$Progress.start();
                Vue.axios.get('api/orders?page='+page).then(({data})=>{
                    this.orders=data;
                    this.$Progress.finish();
                    this.currentPage=data.current_page;
                })
            },
            showCart(id){
                Vue.axios.get('api/orders/'+id).then((data)=>{
                    this.cart=data.data;
                })
            },

            deleteOrder(id){
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

                        this.form.delete('api/orders/'+id).then(()=>{
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
            this.loadOrders(this.currentPage);
            Fire.$on('reload',()=>{
                this.loadOrders(this.currentPage);
            })
        },
        name: "Orders.vue"
    }
</script>

<style scoped>

</style>
