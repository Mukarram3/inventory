<template>
    <div>

        <div class="row">
            <router-link to="/employee" class="btn btn-primary">All Employees</router-link>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Edit Employee</h1>
                                    </div>
                                    <form @submit.prevent="employeeUpdate" enctype="multipart/form-data">
                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-6">
                                                    <label>Name</label>
                                                    <input type="text" v-model="form.name" class="form-control" id="exampleInputFirstName" placeholder="Enter Full Name">
                                                    <span class="text-danger" v-if="errors.name"> {{ errors.name }} </span>
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
                                                    <label>Salary</label>
                                                    <input type="text" v-model="form.salary" class="form-control"
                                                           placeholder="Enter Your Salary">
                                                    <span class="text-danger" v-if="errors.salary"> {{ errors.salary[0] }} </span>
                                                </div>

                                            </div>


                                        </div>

                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-6">
                                                    <label>Joining Date</label>
                                                    <input type="date" v-model="form.joining_date" class="form-control"  placeholder="Enter Your Joining Date">
                                                    <span class="text-danger" v-if="errors.joining_date"> {{ errors.joining_date[0] }} </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>NID</label>
                                                    <input type="text" v-model="form.nid" class="form-control"
                                                           placeholder="Enter Your NID">
                                                    <span class="text-danger" v-if="errors.nid"> {{ errors.nid[0] }} </span>
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
                                                    <img :src="form.photo" srcset="" style="width: 40px; height: 40px;" alt="">
                                                </div>
                                                <div class="col-md-6">
                                                    <img :src="form.photo" srcset="" style="width: 40px; height: 40px;" alt="">
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
       let id=this.$route.params.id;
       axios.get('/api/employee/' + id)
           .then( ({data}) => (this.form=data) )
           .catch()
   },
    data(){
        return {
            form: {
                name: '',
                email: '',
                address: '',
                salary: '',
                joining_date: '',
                nid: '',
                phone: '',
                photo: '',
                newphoto: ''
            },
            errors: {},
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
                    this.form.newphoto = event.target.result;

                }
            }
        },
        employeeUpdate(){
            let id= this.$route.params.id;
            axios.patch('/api/employee/' +id,this.form)
                .then(() => {
                    Notification.success()
                    this.$router.push({ name: 'employee' });
                })
                .catch(error => this.errors= error.response.data.errors)
        },


    }
}
</script>

<style>

</style>
