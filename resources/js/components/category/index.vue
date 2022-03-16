<template>

    <div>

        <div class="row">
            <router-link to="/store-category" class="btn btn-primary">Add Category</router-link>
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
                        <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
                    </div>
                    <div class="table-responsive p-3">
                        <table class="table align-items-center table-flush" id="dataTable">
                            <thead class="thead-light">
                            <tr>
                                <th>Name</th>

                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="category in filterSearsch" :key="category.id">
                                <td>{{category.category_name}}</td>

                                <td>
                                    <router-link :to="{name: 'editcategory', params: {id:category.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                                    <a @click="deleteCategory(category.id)" class="btn btn-sm btn-danger">Delete</a>
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
            this.$router.push({name: '/'})
        }
        this.allCategories();
    },
    data(){
        return {
            searchTerm: '',
            categories: [],
        }
    },
    computed:{
        filterSearsch(){
            return this.categories.filter(category => {
                return category.category_name.match(this.searchTerm)
            })
        },
    },
    methods:{
        allCategories(){
            axios.get('/api/category/')
                .then( ({data})  => (this.categories = data),

                )
                .catch()
        },
        deleteCategory(id){
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

                    axios.delete('/api/category/' + id)
                        .then( this.allCategories() )
                        .catch( () => {
                            this.$router.push({name: 'category'})
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
