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
            
            <button type="submit" class="btn btn btn-block btn-light" style="margin-top:30%;">Login</button>
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
                password: ''
            }
        },
        mounted() {
            
        },
        methods: {
            prijava(event){
                event.preventDefault();
                this.$axios.post('prijava', {
                    email: this.email,
                    password: this.password
                })
                .then(function (response) {
                    let token = response.data.token.access_token;
                    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                    store.login(true,response.data.korisnik.name,response.data.korisnik.id);//postavi vrijednosti , ----- localStorage nije reaktivan pa prvi put kad se korisnik logira ako ne prosljedim "konstruktoru" neče se prikazati odmah nego korisnik mora napraviti refresh
                    router.push('/restorani');
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
        }




    }
</script>


<style scoped>
.container{
    margin-bottom: 15%;
    height: 450px;
    margin-top:7%;
    width: 25%;
    color:#8b057f;
    background-color: #fff;
    border:1px solid #8b057f;
    padding: 3% 3% 3% 3%;
    -webkit-box-shadow: 0px 10px 20px 0px rgba(50, 50, 50, 0.52);
    -moz-box-shadow:    0px 10px 20px 0px rgba(50, 50, 50, 0.52);
    box-shadow:         0px 10px 20px 0px rgba(50, 50, 50, 0.52);/* 
    background-image: linear-gradient(to right, #ffb100, #ff7830, #f23d51, #c9006d, #8b057f); */
}
.btn-light{
    color:#8b057f;
    border:1px solid #8b057f;
}
.btn-light:hover,btn-light:active{
    color:#fff;
    background-color:#8b057f;
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



    

