<template>

    <div>

        <div class="row">
            <router-link to="/given-salary" class="btn btn-primary">Pay Salary</router-link>
        </div>

        <br>

        <input type="text" placeholder="Search Month" v-model="searchTerm" class="form-control" style="width:300px;" />

        <br><br>

        <!-- Row -->
        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Saalry Details</h6>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="dataTable">
                            <thead class="thead-light">
                            <tr>
                                <th>Salary Month</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="salary in filterSearch" :key="salary.id">
                                <td>{{salary.salary_month}}</td>

                                <td>
                                    <router-link :to="{name: 'viewsalary', params: {id: salary.salary_month}}" value="" class="btn btn-sm btn-primary">View Salary</router-link>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!--Row-->
    </div>

</template>

<script>
export default {
    created(){
        if(!User.loggedIn()){
            this.$router.push({name: 'home'})
        }
        this.allEmployee();
    },
    data(){
        return {
            salaries: [],
            searchTerm: ''
        }
    },
    computed:{
        filterSearch(){
            return this.salaries.filter(salary => {
                return salary.salary_month.match(this.searchTerm)
            })
        }
    },
    methods:{
        allEmployee(){
            axios.get('/api/salary/')
                .then( ({data})  => (this.salaries = data))
                .catch()
        },
    }

}
</script>

<style>

</style>
