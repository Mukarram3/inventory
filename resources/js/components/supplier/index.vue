<template>

    <div>

        <div class="row">
            <router-link to="/store-supplier" class="btn btn-primary">Add Supplier</router-link>
        </div>

        <br>

        <input type="text" placeholder="Search Name" v-model="searchTerm" class="form-control" style="width:300px;" />

        <br><br>

        <!-- Row -->
        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Suppliers</h6>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="dataTable">
                            <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Photo</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Shop Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="supplier in filterSearsch" :key="supplier.id">
                                <td>{{supplier.name}}</td>
                                <td>
                                    <img :src="supplier.photo" style="width:50px; height: 50px;">
                                </td>
                                <td>{{supplier.phone}}</td>
                                <td>{{supplier.email}}</td>
                                <td>{{supplier.shopname}}</td>
                                <td>
                                    <router-link :to="{name: 'editsupplier', params: {id:supplier.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                                    <a @click="deleteSupplier(supplier.id)" class="btn btn-sm btn-danger">Delete</a>
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
            this.allSupplier();
        },
        data(){
            return {
                searchTerm: '',
                suppliers: [],
            }
        },
        computed:{
            filterSearsch(){
                return this.suppliers.filter(supplier => {
                    return supplier.name.match(this.searchTerm)
                })
            },
        },
        methods:{
            allSupplier(){
                axios.get('/api/supplier/')
                    .then( ({data})  => (this.suppliers = data))
                    .catch()
            },
            deleteSupplier(id){
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

                        axios.delete('/api/supplier/' + id)
                            .then( this.allSupplier() )
                            .catch( () => {
                                this.$router.push({name: 'supplier'})
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
