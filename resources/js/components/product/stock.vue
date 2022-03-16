<template>

    <div>

        <div class="row">
            <router-link to="/store-product" class="btn btn-primary">Add Product</router-link>
        </div>

        <br>

        <input v-model="searchTerm" type="text" placeholder="Search Product Name" class="form-control" style="width:300px;" />

        <br><br>

        <!-- Row -->
        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Products</h6>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="dataTable">
                            <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Photo</th>
                                <th>Category</th>
                                <th>Buying Price</th>
                                <th>Status</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="product in filterSearch">
                                <td>{{product.product_name}}</td>
                                <td>{{product.product_code}}</td>
                                <td>
                                    <img :src="product.image" style="width:50px; height: 50px;">
                                </td>
                                <td>{{product.category_name}}</td>
                                <td>{{product.buying_price}}</td>
                                <td v-if="product.product_quantity >= 1"> <span class="badge badge-success">Available</span> </td>
                                <td v-else=""> <span class="badge badge-danger">StockOut</span></td>
                                <td>{{product.product_quantity}}</td>
                                <td>
                                    <router-link :to="{name: 'editstock', params: {id:product.id}}" value="" class="btn btn-sm btn-primary">Edit</router-link>

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
        this.allproducts()
    },
    data(){
        return {
            products: [],
            searchTerm: '',
        }
    },
    computed:{
        filterSearch(){
            return this.products.filter(product => {
                return product.product_name.match(this.searchTerm)
            })
        }
    },
    methods:{
        allproducts(){
            axios.get('/api/product/')
                .then( ({data})  => (this.products = data))
                .catch()
        }
    }

}
</script>

<style>

</style>
