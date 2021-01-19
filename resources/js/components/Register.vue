<template>
    <div class="content" >
        <div class="register-logo">
            <a href="/register"><b>Vue</b>Project</a>
        </div>
        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form >
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Full name" v-model="form.name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" v-model="form.email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="governorate_id">Select Your Government</label><select name="governorate_id" class="form-control" id="governorate_id" v-model="form.governorate_id" @change="loadCities">
                        <option :value=undefined>-Select-</option>
                        <option v-for="governorate in governorates" :value="governorate.id">{{governorate.name}}</option>
                        </select>
                    </div>
                    <div class="form-group mb-3" v-show="enableCitySelect">
                        <label for="city_id">Select Your City</label>
                        <select name="city_id" class="form-control" v-model="form.city_id" id="city_id">
                            <option :value=undefined>-Select-</option>
                            <option v-for="city in cities" :value="city.id">{{city.name}}</option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" v-model="form.password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Retype password" v-model="form.password_confirmation">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" @click.prevent="Register">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <a href="/login" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

</template>

<script>
    export default {
        data(){
            return{
                cities:{},
                enableCitySelect:false,
                governorates:{},
                form : new Form({
                    name:'',
                    email:'',
                    governorate_id:undefined,
                    city_id:undefined,
                    password:'',
                    password_confirmation:'',
                }),

            }
        },
        methods:{
            loadCities(){
                Fire.$emit('LoadCity');
                this.enableCitySelect=true;

            },
            Register(){
                this.form.post('api/register').then(()=>{
                    Toast.fire({
                        icon: 'success',
                        title: 'Registered successfully'
                    });
                    window.location.href="/login";
                  //  VueRouter.push({name:'/profile'})
                })

            }

        },
        created() {
                Vue.axios.get('api/governor').then(({data}) => {
                    this.governorates = data.data;
                });
                Fire.$on('LoadCity',()=>{
                    Vue.axios.get('api/city?governorate_id='+this.form.governorate_id).then(({data}) => {
                        this.cities = data.data;
                    })
                })

        },

        name: "Register"
    }
</script>

<style scoped>

</style>
