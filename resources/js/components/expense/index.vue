<template>

    <div>

        <div class="row">
            <router-link to="/store-expense" class="btn btn-primary">Add Expense</router-link>
        </div>

        <br>

        <input type="text" placeholder="Search Amount" v-model="searchTerm" class="form-control" style="width:300px;" />

        <br><br>

        <!-- Row -->
        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">

                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Expenses</h6>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="dataTable">
                            <thead class="thead-light">
                            <tr>
                                <th>Details</th>
                                <th>Amount</th>
                                <th>Expense Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="expense in filterSearsch" :key="expense.id">
                                <td>{{expense.details}}</td>
                                <td>{{expense.amount}}</td>
                                <td>{{expense.expense_date}}</td>

                                <td>
                                    <router-link :to="{name: 'editexpense', params: {id:expense.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                                    <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger">Delete</a>
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
        this.allExpenses();
    },
    data(){
        return {
            searchTerm: '',
            expenses: [],
        }
    },
    computed:{
        filterSearsch(){
            return this.expenses.filter(expense => {
                return expense.amount.match(this.searchTerm)
            })
        },
    },
    methods:{
        allExpenses(){
            axios.get('/api/expense/')
                .then( ({data})  => (this.expenses = data))
                .catch()
        },
        deleteExpense(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {

                    axios.delete('/api/expense/' + id)
                        .then( this.allExpenses() )
                        .catch( () => {
                            this.$router.push({name: 'expense'})
                        })
                    Swal.fire(
                        'Deleted!',
                        'Record has been deleted.',
                        'success'
                    )
                }
            })
        },

    }

}
</script>

<style>

</style>
