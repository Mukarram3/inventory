<template>

    <div>

        <div class="row">
            <router-link to="/salary" class="btn btn-primary">All Salaries</router-link>
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
                                <th>Photo</th>
                                <th>Phone</th>
                                <th>Salery</th>
                                <th>Joining Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="employee in filterSearch" :key="employee.id">
                                <td>{{employee.name}}</td>
                                <td>
                                    <img :src="employee.photo" style="width:50px; height: 50px;">
                                </td>
                                <td>{{employee.phone}}</td>
                                <td>{{employee.salary}}</td>
                                <td>{{employee.joining_date}}</td>
                                <td>
                                    <router-link :to="{name: 'paysalary', params: {id: employee.id}}" value="" class="btn btn-sm btn-primary">Pay Salary</router-link>
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
            employees: [],
            searchTerm: ''
        }
    },
    computed:{
        filterSearch(){
            return this.employees.filter(employee => {
                return employee.phone.match(this.searchTerm)
            })
        }
    },
    methods:{
        allEmployee(){
            axios.get('/api/employee/')
                .then( ({data})  => (this.employees = data))
                .catch()
        },
    }

}
</script>

<style>

</style>
