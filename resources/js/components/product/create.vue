<template>
    <div>

        <div class="row">
            <router-link to="/product" class="btn btn-primary">All Products</router-link>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Add Product</h1>
                                    </div>
                                    <form @submit.prevent="productInsert" enctype="multipart/form-data">
                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-6">
                                                    <label>Name</label>
                                                    <input type="text" v-model="form.product_name" class="form-control" id="exampleInputproductname" placeholder="Enter Product Name">
                                                    <span class="text-danger" v-if="errors.product_name"> {{ errors.product_name }} </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Product Code</label>
                                                    <input type="text" v-model="form.product_code" class="form-control" id="exampleInputproductcode" aria-describedby="emailHelp"
                                                           placeholder="Enter Product Code">
                                                    <span class="text-danger" v-if="errors.product_code"> {{ errors.product_code[0] }} </span>
                                                </div>

                                            </div>


                                        </div>

                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-6">
                                                    <label>Category Id</label>
                                                    <select v-model="form.category_id" class="form-control" id="exampleFormControlSelect1">
                                                        <option :value="category.id" v-for="category in categories">{{category.category_name}}</option>

                                                    </select>
                                                    <span class="text-danger" v-if="errors.category_id"> {{ errors.category_id[0] }} </span>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Supplier Id</label>
                                                    <select v-model="form.supplier_id" class="form-control" id="exampleFormControlSelect2">
                                                        <option :value="supplier.id" v-for="supplier in suppliers">{{supplier.name}}</option>

                                                    </select>
                                                    <span class="text-danger" v-if="errors.supplier_id"> {{ errors.supplier_id[0] }} </span>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-4">
                                                    <label>Product Root</label>
                                                    <input type="text" v-model="form.root" class="form-control"  placeholder="Enter Product Root">
                                                    <span class="text-danger" v-if="errors.root"> {{ errors.root[0] }} </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Buying Price</label>
                                                    <input type="text" v-model="form.buying_price" class="form-control"
                                                           placeholder="Enter Product Buying Price">
                                                    <span class="text-danger" v-if="errors.buying_price"> {{ errors.buying_price[0] }} </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Selling Price</label>
                                                    <input type="text" v-model="form.selling_price" class="form-control"
                                                           placeholder="Enter Product Selling Price">
                                                    <span class="text-danger" v-if="errors.selling_price"> {{ errors.selling_price[0] }} </span>
                                                </div>

                                            </div>


                                        </div>

                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-6">
                                                    <label>Buying Date</label>
                                                    <input type="date" v-model="form.buying_date" class="form-control"  placeholder="Enter Product Buying Date">
                                                    <span class="text-danger" v-if="errors.buying_date"> {{ errors.buying_date[0] }} </span>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>Product Quantity</label>
                                                    <input type="text" v-model="form.product_quantity" class="form-control"  placeholder="Enter Product Product Quantity">
                                                    <span class="text-danger" v-if="errors.product_quantity"> {{ errors.product_quantity[0] }} </span>
                                                </div>

                                            </div>


                                        </div>

                                        <div class="form-group">

                                            <div class="form-row">

                                                <div class="col-md-6">

                                                    <input type="file" @change="onFileSelected" class="custom-file-input" id="customFile">
                                                    <label class="custom-file-label" for="customFile">Choose File</label>
                                                    <span class="text-danger" v-if="errors.image"> {{ errors.image[0] }} </span>
                                                </div>

                                                <div class="col-md-6">
                                                    <img srcset="" style="width: 40px; height: 40px;" :src="form.image" alt="">
                                                </div>

                                            </div>


                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                        </div>


                                    </form>

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
           axios.get('/api/category')
           .then( ({data}) => {this.categories = data} )

           axios.get('/api/supplier')
           .then( ({data}) => {this.suppliers= data})
   },
    data(){
        return {
            form: {
                category_id: null,
                product_name: null,
                product_code: null,
                buying_price: null,
                selling_price: null,
                root: null,
                supplier_id: null,
                buying_date: null,
                image: null,
                product_quantity: null,
            },
            errors: {},
            categories: {},
            suppliers: {}

        }
    },
    methods:{
        onFileSelected(event){
            let file=event.target.files[0];
            if (file.size > 1048770){
                Notification.image_validation();
            }
            else{
                let reader= new FileReader();
                reader.readAsDataURL(file);
                reader.onload= event => {
                    this.form.image = event.target.result;
                    console.log(event.target.result);
                }
            }
        },
        productInsert(){

            axios.post('/api/product',this.form)
                .then(() => {
                    Notification.success()
                    this.$router.push({ name: 'product' });
                })
                .catch(error => this.errors= error.response.data.errors)
        },


    }
}
</script>

<style>

</style>
