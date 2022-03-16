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
                                        <h1 class="h4 text-gray-900 mb-4">Edit Category</h1>
                                    </div>
                                    <form @submit.prevent="categoryUpdate">
                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-12">
                                                    <label>Name</label>
                                                    <input type="text" v-model="form.category_name" class="form-control" id="exampleInputFirstName" placeholder="Enter Full Name">
                                                    <span class="text-danger" v-if="errors.name"> {{ errors.category_name[0] }} </span>
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
            this.$router.push({name: '/'})
        }
        let id=this.$route.params.id
        axios.get('/api/category/' + id)
            .then( ({data}) => (this.form=data))
            .catch()
    },
    data(){
        return {
            form: {
                category_name: '',
            },
            errors: {},
        }
    },
    methods:{
        categoryUpdate(){
            let  id= this.$route.params.id
            axios.patch('/api/category/'+ id,this.form)
                .then(() => {
                    Notification.success()
                    this.$router.push({ name: 'category' });
                })
                .catch(error => this.errors= error.response.data.errors)
        },


    }
}
</script>

<style>

</style>
