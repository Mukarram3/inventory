<template>

    <div>

        <div class="row">
            <router-link to="/store-customer" class="btn btn-primary">Add Cuctomers</router-link>
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
                        <h6 class="m-0 font-weight-bold text-primary">Cuctomers</h6>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="dataTable">
                            <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Photo</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="customer in filterSearch" :key="customer.id">
                                <td>{{customer.name}}</td>
                                <td>{{customer.email}}</td>
                                <td>{{customer.phone}}</td>
                                <td>{{customer.address}}</td>
                                <td>
                                    <img :src="customer.photo" style="width:50px; height: 50px;">
                                </td>
                                <td>
                                    <router-link :to="{name: 'editcustomer', params: {id: customer.id}}" value="" class="btn btn-sm btn-primary">Edit</router-link>
                                    <a @click="deleteCustomer(customer.id)" class="btn btn-sm btn-danger">Delete</a>
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
        this.allCustomer();
    },
    data(){
        return {
            customers: [],
            searchTerm: ''
        }
    },
    computed:{
        filterSearch(){
            return this.customers.filter(customer => {
                return customer.phone.match(this.searchTerm)
            })
        }
    },
    methods:{
        allCustomer(){
            axios.get('/api/customer/')
                .then( ({data})  => (this.customers = data))
                .catch()
        },
        deleteCustomer(id){
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

                    axios.delete('/api/customer/' + id)
                        .then( this.allCustomer() )
                        .catch( () => {
                            this.$router.push({name: 'customer'})
                        })
                    Swal.fire(
                        'Deleted!',
                        'Record has been deleted.',
                        'success'
                    )
                }
            })
        }
    }

}
</script>

<style>

</style>
