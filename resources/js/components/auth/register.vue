<template>
    <div>
         <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Register</h1>
                  </div>
                  <form @submit.prevent="signup">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" v-model="form.name" class="form-control" id="exampleInputFirstName" placeholder="Enter Full Name">
                      <span class="text-danger" v-if="errors.name"> {{ errors.name[0] }} </span>
                    </div>

                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" v-model="form.email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Enter Email Address">
                      <span class="text-danger" v-if="errors.email"> {{ errors.email[0] }} </span>
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" v-model="form.password" class="form-control" id="exampleInputPassword" placeholder="Password">
                      <span class="text-danger" v-if="errors.password"> {{ errors.password[0] }} </span>
                    </div>
                    <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="password" v-model="form.password_confirmation" class="form-control" id="exampleInputPasswordRepeat"
                        placeholder="Conform Password">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>


                  </form>
                  <hr>
                  <div class="text-center">
                    <router-link to="/">Already Have an A/C</router-link>
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
       if(User.loggedIn()){
           this.$router.push({name: 'home'})
       }
   },
  data(){
    return {
      form: {
        name: null,
        email: null,
        password: null
      },
        errors: {}
    }
  },
  methods: {
    signup(){
      axios.post('api/auth/signup',this.form)
      .then(res => {
          User.responseAfterLogin(res)
          this.$router.push({ name: 'home' })
          Toast.fire({
              icon: 'success',
              title: 'Register & Signed in successfully'
          })
      })
          .catch(error => this.errors= error.response.data.errors)
    }
  }
}
</script>

<style>

</style>
