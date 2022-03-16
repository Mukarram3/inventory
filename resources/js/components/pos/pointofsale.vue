<template>
    <div>

        <div class="container-fluid" id="container-wrapper">

            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">POS</li>
                </ol>
            </div>

            <div class="row mb-3">

                <!-- Area Chart -->
                <div class="col-xl-5 col-lg-5">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Expense</h6>
                            <a class="btn btn-sm btn-info text-white">Add Customers</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush" style="font-size: 12px;">
                                <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>QTY</th>
                                    <th>Unit</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="cart in carts">
                                    <td>{{cart.pro_name}}</td>
                                    <td>
                                        <input type="text" readonly="" style="width: 15px;" :value="cart.pro_quantity"/>
                                        <button @click.prevent="increment(cart.id)" class="btn btn-success btn-sm">+</button>
                                        <button @click.prevent="decrement(cart.id)" v-if="cart.pro_quantity >1" class="btn btn-danger btn-sm">-</button>
                                        <button @click.prevent="decrement(cart.id)" v-else="" disabled="" class="btn btn-danger btn-sm">-</button>
                                    </td>
                                    <td>{{cart.pro_price}}</td>
                                    <td>{{cart.sub_total}}</td>
                                    <td><a class="btn btn-danger btn-sm text-white" @click="deleteCart(cart.id)">X</a></td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center"> Total Quantity <strong>{{ qty }}</strong></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center"> Sub Total <strong>{{subtotal}}$</strong></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center"> Discount <strong>{{ discount.vat }} $</strong></li>
                                <li class="list-group-item d-flex justify-content-between align-items-center"> Total Quantity <strong>{{ subtotal*discount.vat/100 + subtotal }}$</strong></li>
                            </ul>

                            <br>

                            <form @submit.prevent="orderdone">
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <select class="form-control" v-model="customer_id">
                                        <option v-for="customer in customers" :value="customer.id">{{customer.name}}</option>

                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPay">Pay</label>
                                    <input type="text" class="form-control" @change="dueamount()" v-model="pay" required id="exampleInputPay" >
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputDue">Due</label>
                                    <input type="text" class="form-control" v-model="paydue" required id="exampleInputDue" >
                                </div>
                                <div class="form-group">
                                    <label>Pay By</label>
                                    <select class="form-control" v-model="payby">
                                        <option value="HandCash">Hand Cash</option>
                                        <option value="Cheaque">Cheaque</option>
                                        <option value="GiftCard">Gift Card</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
                <!-- Pie Chart -->
                <div class="col-xl-7 col-lg-7">
                    <div class="card mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>

                        </div>

<!--                        Category Wise Data  -->

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">All Products</button>
                            </li>
                            <li class="nav-item" role="presentation" v-for="category in categories">
                                <button @click="allsubCatProducts(category.id)" class="nav-link" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">{{category.category_name}}</button>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">

                            <!--                            All Product Tab -->

                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                                <div class="card-body">
                                    <input v-model="searchTerm" type="text" placeholder="Search Product Name" class="form-control mb-2" style="width:550px;" />

                                    <div class="row">

                                        <div class="col-lg-4 col-md-4 xol-sm-6 col-6" v-for="product in filterSearch">
                                            <button v-if="product.product_quantity > 0" class="btn btn-sm" @click.prevent="AddToCart(product.id)">
                                                <div class="card mb-3" style="max-width: 540px;">
                                                    <div class="row g-0">
                                                        <div class="col-md-5">
                                                            <img :src="product.image" style="width: 100%; height: 100%;" class="img-fluid rounded-start">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="card-body" style="padding: 0px;">
                                                                <h6 class="card-title">{{product.product_name}}</h6>
                                                                <!--                                                    <small>{{product.category_name}}</small>-->
                                                                <span v-if="product.product_quantity >= 1" class="badge badge-success">Available {{product.product_quantity}}</span>
                                                                <span v-else="" class="badge badge-danger">StockOut</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>
                                            <button v-else="" class="btn btn-sm">
                                                <div class="card mb-3" style="max-width: 540px;">
                                                    <div class="row g-0">
                                                        <div class="col-md-5">
                                                            <img :src="product.image" style="width: 100%; height: 100%;" class="img-fluid rounded-start">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="card-body" style="padding: 0px;">
                                                                <h6 class="card-title">{{product.product_name}}</h6>
                                                                <!--                                                    <small>{{product.category_name}}</small>-->
                                                                <span v-if="product.product_quantity >= 1" class="badge badge-success">Available {{product.product_quantity}}</span>
                                                                <span v-else="" class="badge badge-danger">StockOut</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>


                                        </div>


                                    </div>
                                </div>

                            </div>

<!--                            All Product Tab -->

                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

<!--                                Categorised Data  -->

                                <div class="card-body">
                                    <input v-model="getsearchTerm" type="text" placeholder="Search Product Name" class="form-control mb-2" style="width:550px;" />

                                    <div class="row">

                                        <div class="col-lg-4 col-md-4 xol-sm-6 col-6" v-for="subcatproduct in getfilterSearch" :key="subCatProduct.id">
                                            <button class="btn btn-sm" @click.prevent="AddToCart(subcatproduct.id)">
                                                <div class="card mb-3" style="max-width: 540px;">
                                                    <div class="row g-0">
                                                        <div class="col-md-5">
                                                            <img :src="subcatproduct.image" style="width: 100%; height: 100%;" class="img-fluid rounded-start">
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="card-body" style="padding: 0px;">
                                                                <h6 class="card-title">{{subcatproduct.product_name}}</h6>
                                                                <!--                                                    <small>{{subCatProduct.category_name}}</small>-->
                                                                <span v-if="subcatproduct.product_quantity >= 1" class="badge badge-success">Available {{subcatproduct.product_quantity}}</span>
                                                                <td v-else=""> <span class="badge badge-danger">StockOut</span></td>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </button>

                                        </div>


                                    </div>
                                </div>

<!--                               Categorised Data -->

                            </div>
                           </div>

                        <!--                        Category Wise Data  -->


                    </div>
                </div>

            </div>
            <!--Row-->

        </div>

    </div>
</template>

<script>
export default {
    created(){
        if(!User.loggedIn()){
            this.$router.push({name: 'home'})
        }
        this.allproducts();
        this.allCategory();
        this.allCustomers();
        this.cartProducts();
        this.ProductDiscount();
    },
    data(){
        return {
            customer_id: '',
            pay: '',
            paydue: '',
            payby: '',

            products: [],
            searchTerm: '',
            getsearchTerm: '',
            categories: [],
            subcatproducts: [],
            customers: [],
            carts: [],
            discount: '',
        }
    },
    computed:{
        filterSearch(){
            return this.products.filter(product => {
                return product.product_name.match(this.searchTerm)
            })
        },
        // getfilterSearch(){
        //     return this.subCatProducts.filter(subcatproduct => {
        //         return order.product_name.match(this.searchTerm)
        //     })
        // },
        qty(){
            let sum=0;
            for (let i=0; i<this.carts.length; i++){
                sum += (parseFloat(this.carts[i].pro_quantity))
            }
            return sum;
        },
        subtotal(){
            let sum=0;
            for (let i=0; i<this.carts.length; i++){
                sum += (parseFloat(this.carts[i].pro_quantity) * parseFloat(this.carts[i].pro_price))
            }
            return sum;
        },
    },
    methods:{
        // Card Methods
        dueamount(){
          this.paydue=this.subtotal-this.pay;
        },
        orderdone(){
          let total= this.subtotal* this.discount.vat/100 + this.subtotal;
          var data= {customer_id: this.customer_id,pay: this.pay, payby: this.payby,paydue: this.paydue,total: total,qty: this.qty,subtotal: this.subtotal,discount: this.discount.vat}

            axios.post('/api/orderdone', data)
            .then( () => {
                Notification.success();
                this.$router.push({name: 'home'})
            })

        },
        AddToCart(id){
            axios.get('/api/addToCart/' +id)
                .then( ()  => {
                    Notification.cart_success()
                    this.cartProducts();
                    this.allproducts();
                })
                .catch()
        },
        deleteCart(id){
            axios.get('/api/deleteCart/' +id)
                .then( ()  => {
                    Notification.cart_deleted()
                    this.cartProducts();
                })
                .catch()
        },
        increment(id){
            axios.get('/api/increment/' +id)
                .then( ()  => {
                    Notification.success()
                    this.cartProducts();
                    this.allproducts();
                })
                .catch()
        },
        decrement(id){
            axios.get('/api/decrement/' +id)
                .then( ()  => {
                    Notification.success()
                    this.cartProducts();
                    this.allproducts();
                })
                .catch()
        },
        cartProducts(){
            axios.get('/api/cart/product')
                .then( ({data})  => (this.carts = data))
                .catch()
        },
        ProductDiscount(){
            axios.get('/api/discount')
                .then( ({data})  => (this.discount = data))
                .catch()
        },

        //  Card Methods
        allproducts(){
            axios.get('/api/product/')
                .then( ({data})  => (this.products = data))
                .catch()
        },
        allCategory(){
            axios.get('/api/category/')
                .then( ({data})  => (this.categories = data))
                .catch()
        },
        allsubCatProducts(id){
            axios.get('/api/category/products/' +id)
                .then( ({data})  => (this.subcatproducts = data))
                .catch()
        },
        allCustomers(){
            axios.get('/api/customer/')
                .then( ({data})  => (this.customers = data))
                .catch()
        },
    }

}
</script>

<style scoped>

a:hover{
    text-decoration: none;
}

</style>
