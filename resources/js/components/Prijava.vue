<template>
    <div class="container rounded">
        <h2 class="textCenter">Login</h2>
            <form @submit="prijava">
            <div class="form-group">
                <label for="email">Email </label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" v-model="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" v-model="password">
            </div>
           
            <button type="submit" class="btn btn btn-block btn-light">Login</button>
            </form>
    </div>
</template>

<script>
import {store} from '../store/store';
import router from '../routes';

    export default {
        name: 'prijava',
        data(){
            return {
                storeState: store.state,
                email: '',
                password: '',
            }
        },
        mounted() {
            
        },
        methods: {
            prijava(event){
                let password_error;

                event.preventDefault();
                this.$axios.post('prijava', {
                    email: this.email,
                    password: this.password
                })
                .then((response) => {
                    this.$alertify.error(response.data.Password);
                    let token = response.data.token.access_token;
                    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                    store.login(true,response.data.korisnik.name,response.data.korisnik.id);
                    router.push('/restorani');
                })
                .then((response) => {
                    this.$root.$emit('userLoggedIn');
                })
                .catch( (error) => {
                    let email_error , pass_error;
                    if(error.response != undefined){//undefined if password does not exists
                        if(error.response.data.errors != undefined){
                            if(error.response.data.errors.email != undefined){
                                email_error = error.response.data.errors.email[0];
                            }
                            if(error.response.data.errors.password != undefined){
                                pass_error = error.response.data.errors.password[0];
                            }
                        }
                    }

                    if(email_error && pass_error){
                        this.$alertify.error(email_error);
                        this.$alertify.error(pass_error);
                    }else if(email_error){
                        this.$alertify.error(email_error);
                    }
                    
                });
            },
        }




    }
</script>


<style scoped>
.container{
    height: 400px;
    margin-top:7%;
    width: 25%;
    color:#2f4858;
    background-color: #fff;
    border:1px solid #ca356d;
    padding: 3% 3% 0% 3%;
    -webkit-box-shadow: 0px 10px 20px 0px rgba(50, 50, 50, 0.52);
    -moz-box-shadow:    0px 10px 20px 0px rgba(50, 50, 50, 0.52);
    box-shadow:         0px 10px 20px 0px rgba(50, 50, 50, 0.52);/* 
    background-image: linear-gradient(to right, #ffb100, #ff7830, #f23d51, #c9006d, #8b057f); */
}
.btn-light{
    color:#ca356d;
    border:1px solid #ca356d;
}
.btn-light:hover,btn-light:active{
    color:#fff;
    background-color:#ca356d;
}
.textCenter{
    text-align: center;
}
@media (max-width: 350px){
    .container{
        width: 100%;
    }
}
@media (min-width: 350px) and (max-width: 600px){
    .container{
       width: 75%;
    }
}
@media (min-width: 600px) and (max-width: 1024px){
    .container{
       width: 45%;
    }
}
</style>



    

