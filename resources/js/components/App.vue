<template>
    <nav class="navbar navbar-expand-lg navbar-light">
        <router-link to="/restorani" class="navbar-brand">BrzaHrana.hr</router-link>
        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
            <span class="navbar-toggler-icon"></span>
        </button> -->

        <!-- class="collapse navbar-collapse" id="navbar" -->
            <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <router-link to="/restorani" class="btn btn-outline-light" id="restorani">Restorani</router-link>
            </li>
            <!-- <li class="nav-item">
                <router-link to="/onama" class="nav-link">O nama</router-link>
            </li> -->
            </ul>


            <ul class="navbar-nav ml-auto" v-if="!store.logiran">
            <li class="nav-item">
                <router-link to="/prijava"  class="btn btn-outline-light">Prijava</router-link>
            </li>
            <li class="nav-item">
                <router-link to="/registracija" v-if="!store.logiran" class="btn btn-outline-light" id="registracija">Registracija</router-link>
            </li>
            
            </ul>
            
            <ul class="navbar-nav ml-auto" v-else>
                <li class="nav-item">
                <span class="nav-link">{{ store.user }}</span>
                </li>
                <li class="nav-item">
                <router-link to="/prijava" @click.native="odjava" class="btn btn-outline-light">Odjava</router-link>
                
                </li>
            </ul>
    </nav>
    
</template>

<script>
import {store} from '../store/store';

    export default {
        name:'app',
        data(){
            return{
               store : store.state
            }
        },
        methods : {
            odjava(){
                store.state.logiran = false;
                this.$alertify.success('Logged out!');
            }
        },
        mounted() {
            
        },
        
    }
</script>


<style scoped>
.navbar {
    background-color: #2f4858;
    /*
    background-image: linear-gradient(to right, #ffb100, #ff7830, #f23d51, #c9006d, #8b057f);
    */
}
.navbar .navbar-brand,
.navbar .navbar-nav .nav-link {
    color: floralwhite;
}
.nav-item{
    margin-right: 5%;
}
@media(max-width: 600px) {
    #restorani{
        display: none;
    }
    #registracija{
        display: none;
    }
}
@media (min-width: 600px) and (max-width: 1024px){
    #registracija{
        display: none;
    }
}
</style>
