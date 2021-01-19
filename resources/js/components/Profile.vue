<template>
    <div class="card card-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-info">
            <h3 class="widget-user-username">{{form.name}}</h3>
            <h5 class="widget-user-desc">Founder &amp; CEO</h5>
        </div>
        <div class="widget-user-image">
            <img class="img-circle" v-bind:src="userPhoto" alt="User Avatar">
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header">3,200</h5>
                        <span class="description-text">SALES</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header">13,000</h5>
                        <span class="description-text">FOLLOWERS</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                    <div class="description-block">
                        <h5 class="description-header">35</h5>
                        <span class="description-text">PRODUCTS</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Settings</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Name" autocomplete="off" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Experience</label>
                        <textarea type="text" name="bio" class="form-control" id="experience" placeholder="..." v-model="form.bio" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Upload Profile Picture</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="photo"   @change="updateProfile" id="exampleInputFile">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password</label>
                        <input type="text" class="form-control" v-model="form.password" id="password" placeholder="Only if you want to change it !" :class="{ 'is-invalid': form.errors.has('password') }" >
                        <has-error :form="form" field="password"></has-error>

                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer" style="padding: 15px">
                    <button type="submit" @click.prevent="updateInfo" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                userPhoto:"",
                form: new Form({
                    id:'',
                    name:'',
                    bio:'',
                    email:'',
                    photo:'',
                    password:'',

                })
            }
        },
        methods:{
            updateInfo(){
                this.$Progress.start();
                if(this.form.password === ""){
                    this.form.password = undefined ;
                }
                this.form.put('api/profile')
                    .then(() => {
                        this.$Progress.finish();
                        //Toaster from Sweet Alert
                        Toast.fire(
                            'success',
                             'Profile updated!'
                        );
                        Fire.$emit('AfterUpdate');
                    })
                    .catch(() => {
                        this.$Progress.fail();

                        //Toaster from Sweet Alert
                        Toast.fire(
                             'error',
                            'Something went wrong!'
                        )
                    })
            },
          updateProfile(e){
              let file = e.target.files[0];
              //console.log=(file);
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
             }
        },
        created() {
            this.$Progress.start();
            axios.get('api/profile')
                .then(({ data }) => {
                    this.userPhoto = "img/profile/" + data.photo;
                    Fire.$on('AfterUpdate', () => {
                        axios.get('api/profile')
                            .then((data) => {
                                let photo = data.data.photo;
                                this.userPhoto = "img/profile/" + photo;
                            })
                    });
                    this.form.reset();
                    this.form.fill(data);
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                })
        },
        name: "Profile"
    }
</script>

<style scoped>

</style>
