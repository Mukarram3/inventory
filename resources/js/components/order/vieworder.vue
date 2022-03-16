<template>
    <div>

        <div class="row">
            <router-link to="/allorder" class="btn btn-primary"> Go Back</router-link>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"> Order Details </h1>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <!-- Simple Tables -->
                                            <div class="card">
                                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                    <h6 class="m-0 font-weight-bold text-primary"> Order Details </h6>
                                                </div>
                                                <div class="table-responsive">

                                                    <ul class="list-group">
                                                        <li class="list-group-item"><b>Name</b> {{orders.name}} </li>
                                                        <li class="list-group-item"><b>Phone</b> {{orders.phone}}</li>
                                                        <li class="list-group-item"><b>Address</b> {{orders.address}}</li>
                                                        <li class="list-group-item"><b>Date</b> {{orders.order_date}}</li>
                                                        <li class="list-group-item"><b>Pay Through</b> {{orders.payby}}</li>
                                                    </ul>

                                                </div>
                                                <div class="card-footer"></div>
                                            </div>
                                        </div>



                                        <div class="col-lg-6 mb-4">
                                            <!-- Simple Tables -->
                                            <div class="card">
                                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                    <h6 class="m-0 font-weight-bold text-primary">Simple Tables</h6>
                                                </div>
                                                <div class="table-responsive">

                                                    <ul class="list-group">
                                                        <li class="list-group-item"><b>Subtotal</b> {{orders.sub_total}} </li>
                                                        <li class="list-group-item"><b>Discount</b> {{orders.discount}}$</li>
                                                        <li class="list-group-item"><b>Total</b> {{orders.total}}$</li>
                                                        <li class="list-group-item"><b>Pay Amount</b> {{orders.pay}}$</li>
                                                        <li class="list-group-item"><b>Due Amount</b> {{orders.paydue}}$</li>
                                                    </ul>

                                                </div>
                                                <div class="card-footer"></div>
                                            </div>
                                        </div>


                                    </div>


                                    <div class="row">
                                        <div class="col-lg-12 mb-4">
                                            <!-- Simple Tables -->
                                            <div class="card">
                                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                    <h6 class="m-0 font-weight-bold text-primary">Simple Tables</h6>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table align-items-center table-flush">
                                                        <thead class="thead-light">
                                                        <tr>
                                                            <th>Product Name</th>
                                                            <th>Product Code</th>
                                                            <th>Image</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Price</th>
                                                            <th>Total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr v-for="orderDetail in myorderDetail">
                                                            <td>{{orderDetail.product_name}}</td>
                                                            <td>{{orderDetail.product_code}}</td>
                                                            <td> <img :src="'/'+orderDetail.image" width="50px" height="50px"></td>
                                                            <td>{{orderDetail.pro_quantity}}</td>
                                                            <td>{{orderDetail.pro_price}}$</td>
                                                            <td>{{orderDetail.pro_subtotal}}$</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="card-footer"></div>
                                            </div>
                                        </div>
                                    </div>

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

        this.allorders();
        this.orderdetails();
    },
    data(){
        return {
            orders: [],
            myorderDetail: [],
        }
    },
    methods:{
        allorders(){
            let id=this.$route.params.id;
            axios.get('/api/orders/' +id)
                .then( ({data})  => (this.orders = data))
                .catch()
        },

        orderdetails(){
            let id=this.$route.params.id;
            axios.get('/api/ordersdetails/' +id)
                .then( ({data})  => (this.myorderDetail = data))
                .catch()
        },

    }
}
</script>

<style>

</style>
