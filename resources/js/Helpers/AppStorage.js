/**
 * Created by mukar on 9/29/2021.
 */

class AppStorage{

    storeToken(token){
        localStorage.setItem('token',token);
    }
    storeUser(user){
        localStorage.setItem('user',user);
    }
    store(token,user){
        this.storeToken(token)
        this.storeUser(user)
    }
    clear(){
        localStorage.removeItem('token')
        localStorage.removeItem('user')
    }
    getToken(){
        this.getItem('token')
    }
    getUser(){
        this.getItem('user')
    }

}
export default AppStorage= new AppStorage();