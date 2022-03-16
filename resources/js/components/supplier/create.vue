<template>
    <div>

        <div class="row">
            <router-link to="/supplier" class="btn btn-primary">All Suppliers</router-link>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Add Suppliers</h1>
                                    </div>
                                    <form @submit.prevent="supplierInsert" enctype="multipart/form-data">
                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-6">
                                                    <label>Name</label>
                                                    <input type="text" v-model="form.name" class="form-control" id="exampleInputFirstName" placeholder="Enter Full Name">
                                                    <span class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Email</label>
                                                    <input type="email" v-model="form.email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                                           placeholder="Enter Email Address">
                                                    <span class="text-danger" v-if="errors.email"> {{ errors.email[0] }} </span>
                                                </div>

                                            </div>


                                        </div>

                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-6">
                                                    <label>Address</label>
                                                    <input type="text" v-model="form.address" class="form-control" id="" placeholder="Enter Your Address">
                                                    <span class="text-danger" v-if="errors.address"> {{ errors.address[0] }} </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Shop Name</label>
                                                    <input type="text" v-model="form.shopname" class="form-control"
                                                           placeholder="Enter Your Shop Name">
                                                    <span class="text-danger" v-if="errors.shopname"> {{ errors.shopname[0] }} </span>
                                                </div>

                                            </div>


                                        </div>



                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-6">
                                                    <label>Phone Number</label>
                                                    <input type="text" v-model="form.phone" class="form-control"  placeholder="Enter Your Mobile Number">
                                                    <span class="text-danger" v-if="errors.phone"> {{ errors.phone[0] }} </span>
                                                </div>


                                            </div>


                                        </div>

                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-6">

                                                    <input type="file" @change="onFileSelected" class="custom-file-input" id="customFile">
                                                    <label class="custom-file-label" for="customFile">Choose File</label>
                                                    <!--<span class="text-danger" v-if="errors.photo"> {{ errors.photo[0] }} </span>-->
                                                </div>

                                                <div class="col-md-6">
                                                    <img srcset="" style="width: 40px; height: 40px" :src="form.photo" alt="Loading">
                                                </div>

                                            </div>


                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                        </div>


                                    </form>

                                    <div class="text-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
   created(){
       if(!User.loggedIn()){
           this.$router.push({name: 'home'})
       }
   },
        data(){
            return {
                form: {
                    name: null,
                    email: null,
                    address: null,
                    shopname: null,
                    phone: null,
                    photo: null
                },
                errors: {},
                suppliers: [],
            }
        },
        methods:{
            onFileSelected(event){
                let file=event.target.files[0];
                if (file.size > 1048770){
                    Notification.image_validation();
                }
                else{
                    let reader= new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload= event => {
                        this.form.photo= event.target.result;
                        console.log(event.target.result);
                    }
                }
            },
            supplierInsert(){

                axios.post('/api/supplier',this.form)
                    .then(() => {
                        Notification.success()
                        this.$router.push({name: 'supplier'});
                    })
                    .catch(error => this.errors= error.response.data.errors)
            },


        }
    }
</script>

<style>

</style>
