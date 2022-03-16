/**
 * Created by mukar on 9/30/2021.
 */

import AppStorage from './AppStorage.js';
import Token from './Token.js';

class User{

    responseAfterLogin(res){

        const access_token = res.data.access_token;
        const user = res.data.name;
        if (Token.isValid(access_token)){
            AppStorage.store(access_token,user);

        }

    }

    hasToken(){
        const storeToken = localStorage.getItem('token');
        if (storeToken){
            return Token.isValid(storeToken) ? true : false
        }

    }
    loggedIn(){
        return this.hasToken();
    }

    name(){
        if (this.loggedIn()){
            return localStorage.getItem('user');
        }
    }

    id(){
        if (this.loggedIn()){
            const payload = Token.payload(localStorage.getItem('token'))
            return payload.sub;
        }

    }

}
export default User = new User();