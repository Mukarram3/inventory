<template>

    <div>

        <input type="text" placeholder="Search Amount" v-model="searchTerm" class="form-control" style="width:300px;" />

        <br>

        <!-- Row -->
        <div class="row">
            <!-- Datatables -->
            <div class="col-lg-12">

                <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Today Orders</h6>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="dataTable">
                            <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Total Amount</th>
                                <th>Pay</th>
                                <th>Pay By</th>
                                <th>Due</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="order in filterSearsch" :key="order.id">
                                <td>{{order.name}}</td>
                                <td>{{order.qty}}</td>
                                <td>{{order.total}}</td>
                                <td>{{order.pay}}</td>
                                <td>{{order.payby}}</td>
                                <td>{{order.paydue}}</td>

                                <td>
                                    <router-link :to="{name: 'vieworder', params: {id:order.id}}" class="btn btn-sm btn-primary">View</router-link>
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
        this.allOrders();
    },
    data(){
        return {
            searchTerm: '',
            orders: [],
        }
    },
    computed:{
        filterSearsch(){
            return this.orders.filter(order => {
                return order.name.match(this.searchTerm)
            })
        },
    },
    methods:{
        allOrders(){
            axios.get('/api/allOrders')
                .then( ({data})  => (this.orders = data))
                .catch()
        },

    }

}
</script>

<style>

</style>
