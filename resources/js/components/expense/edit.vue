<template>
    <div>

        <div class="row">
            <router-link to="/expense" class="btn btn-primary">All Expenses</router-link>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Edit Expense</h1>
                                    </div>
                                    <form @submit.prevent="expenseUpdate">
                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-12">
                                                    <label>Expense Details</label>
                                                    <textarea class="form-control" v-model="form.details" id="exampleFormControlTextarea" rows="3"></textarea>
                                                    <span class="text-danger" v-if="errors.details"> {{ errors.category_name[0] }} </span>
                                                </div>


                                            </div>
                                            <br>
                                            <div class="form-row">

                                                <div class="col-md-12">
                                                    <label>Expense Amount</label>
                                                    <input type="text" v-model="form.amount" class="form-control" id="validationServer01"
                                                           placeholder="Enter Expense Amount">
                                                    <span class="text-danger" v-if="errors.amount"> {{ errors.category_name[0] }} </span>
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
        let id=this.$route.params.id
        axios.get('/api/expense/' + id)
            .then( ({data}) => (this.form=data))
            .catch()
    },
    data(){
        return {
            form: {
                details: '',
                amount: '',
            },
            errors: {},
        }
    },
    methods:{
        expenseUpdate(){
            let  id= this.$route.params.id
            axios.patch('/api/expense/'+ id,this.form)
                .then(() => {
                    Notification.success()
                    this.$router.push({ name: 'expense' });
                })
                .catch(error => this.errors= error.response.data.errors)
        },


    }
}
</script>

<style>

</style>
