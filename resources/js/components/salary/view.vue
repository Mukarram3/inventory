<template>

    <div>

        <div class="row">
            <router-link to="/salary" class="btn btn-primary">Go Back</router-link>
        </div>

        <br>

        <input type="text" placeholder="Search Phone" v-model="searchTerm" class="form-control" style="width:300px;" />

        <br><br>

        <!-- Row -->
        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Employees</h6>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="dataTable">
                            <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Month</th>
                                <th>Salary</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="salary in filterSearch" :key="salary.id">
                                <td>{{salary.name}}</td>
                                <td>{{salary.salary_month}}</td>
                                <td>{{salary.amount}}</td>
                                <td>{{salary.salary_date}}</td>
                                <td>
                                    <router-link :to="{name: 'editsalary', params: {id: salary.id}}" value="" class="btn btn-sm btn-primary">Edit Salary</router-link>
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
            let id=this.$route.params.id;
            axios.get('/api/viewsalary/'+ id)
                .then( ({data})  => (this.salaries = data))
                .catch()
        },
    }

}
</script>

<style>

</style>
