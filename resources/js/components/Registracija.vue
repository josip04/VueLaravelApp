<template>
    <div class="container rounded">
        <h2 class="textCenter">Sign up!</h2>
            <form @submit="registracija">
                <div class="form-group">
                <label for="name">Username </label>
                <input type="name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter username" v-model="name">
                </div>
                <div class="form-group">
                    <label for="email">Email </label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" v-model="email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Password" v-model="password">
                </div>
                
                <button type="submit" class="btn btn btn-block btn-light">Sign up!</button>
            </form>
    </div>
</template>

<script>
import router from '../routes';


    export default {

        mounted() {
            
        },
         data(){
            return {
                name:'',
                email: '',
                password: ''
            }
        },
        methods: {
                registracija(e){
                e.preventDefault();
                this.$axios.post('registracija', {
                    name: this.name,
                    email: this.email,
                    password: this.password
                })
                .then(function (response) {
                    router.push('/prijava');
                })
                .catch(function (error) {
                    router.push('/registracija');
                });

            }
        }
    }
</script>



<style scoped>

.container{
    margin-bottom: 15%;
    height: 450px;
    margin-top:7%;
    width: 25%;
    color:#2f4858;
    background-color: #fff;
    border:1px solid #ca356d;
    padding: 3% 3% 3% 3%;
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