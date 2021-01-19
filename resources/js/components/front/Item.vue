<template>
    <section class="content">

        <!-- Default box -->
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none">{{product.name}}</h3>
                        <div class="col-12">
                            <img :src="'/img/T-shirts/'+product.photo" class="product-image" alt="Product">
                        </div>

                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">{{product.name}}</span></span></h3>
                        <p><font style="vertical-align: inherit;"><span style="vertical-align: inherit;">You probably have not heard of them raw denim jean shorts Austin. </span><span
                            style="vertical-align: inherit;">Some do not make tofu stumptown buteher back keffiyeh dreamcatcher synth. </span><font style="vertical-align: inherit;">Cosby sweater football banh mi, who cupidatat ten.</font></font></p>

                        <hr>
                        <h4><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">available colors</font></font></h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-default text-center active">
                                <input type="radio" name="color_option" id="color_option1" autocomplete="off" checked=""><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                Green
                            </font></font><br>
                                <i class="fas fa-circle fa-2x text-green"></i>
                            </label>
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option2" autocomplete="off"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                blue
                            </font></font><br>
                                <i class="fas fa-circle fa-2x text-blue"></i>
                            </label>
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option3" autocomplete="off"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                White
                            </font></font><br>
                                <i class="fas fa-circle fa-2x text-purple"></i>
                            </label>
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option4" autocomplete="off"><span
                                style="vertical-align: inherit;"><span
                                style="vertical-align: inherit;">
                                        red
                                    </span></span><br>
                                <i class="fas fa-circle fa-2x text-red"></i>
                            </label>
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option5" autocomplete="off"><span
                                style="vertical-align: inherit;"><span
                                style="vertical-align: inherit;">
                                        orange
                                    </span></span><br>
                                <i class="fas fa-circle fa-2x text-orange"></i>
                            </label>
                        </div>

                        <h4 class="mt-3"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">Size </span></span><small><span
                            style="vertical-align: inherit;"><span style="vertical-align: inherit;">Please select one</span></span></small></h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option1" autocomplete="off">
                                <span class="text-xl"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">S</span></span></span>
                                <br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                Medium
                            </font></font></label>
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option1" autocomplete="off">
                                <span class="text-xl"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">1000</font></font></span>
                                <br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                Bold
                            </font></font></label>
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option1" autocomplete="off">
                                <span class="text-xl"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">50</span></span></span>
                                <br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">
                                Large
                            </font></font></label>
                            <label class="btn btn-default text-center">
                                <input type="radio" name="color_option" id="color_option1" autocomplete="off">
                                <span class="text-xl"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">40</span></span></span>
                                <br><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">
                                        Xtra-Large
                                    </span></span></label>
                        </div>

                        <div class="bg-gray py-2 px-3 mt-4">
                            <h2 class="mb-0"><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">
                                        $ {{product.price}}
                                    </span></span></h2>
                            <h4 class="mt-0">
                                <small><span style="vertical-align: inherit;"><span style="vertical-align: inherit;">Ex Tax: $ {{product.price}} </span></span></small>
                            </h4>
                        </div>

                        <div class="mt-4">
                            <!--SO important to use backslash / before url in javascript -->
                            <a class="btn btn-primary btn-lg btn-flat" @click.prevent="showAlert">
                                <i class="fas fa-cart-plus fa-lg mr-2"></i><span style="vertical-align: inherit;"><span
                                style="vertical-align: inherit;">
                                        Add to Cart
                                    </span></span></a>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!--Alert modal-->
        <div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0" style="border: 0">
                    <div class="modal-header" >
                        <h5 class="modal-title" id="exampleModalLongTitle">success!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{product.name}} added to your cart
                    </div>
                    <div class="modal-footer">
                        <a data-dismiss="modal" class="btn btn-default form-control border-1">Continue shopping</a>
                        <a href="/cart" class="btn btn-primary form-control-file">Go to cart</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        props:['product'],
        methods:{
            showAlert(){
                Vue.axios.get('/cart/'+this.product.id).then(()=>{
                    Fire.$emit('reloadCart');
                       $('#alertModal').modal('show');
                });
            },
        },
        created(){
        },
        name: "Item"
    }
</script>

<style scoped>

</style>
