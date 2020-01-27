<template>
    <!-- <div class="container"> -->
        <div class="row justify-content-center">
            <div class="col-md-12">
                    <div class="jumbotron">
                        <div class="container">
                        <h1>BrzaHrana.hr</h1>
                        <p class="lead">Jednostavno i brzo naručite dostavu iz vašeg omiljenog restorana!</p>
                        <hr class="my-4">
                        <p class="lead"> Želiš postaviti oglas za svoj restoran?  Može , samo se još moraš prijaviti ili registrirati.</p>
                        <div v-if="!user_id">
                            <router-link to="/prijava">
                            <button type="button" class="btn btn-outline-light" id="prijava">Prijava</button>
                            </router-link>
                            <router-link to="/registracija">
                            <button type="button" class="btn btn-outline-light">Registracija</button>
                            </router-link>
                        </div>
                        
                        <div v-if="user_id">
                            <router-link to="/novi">
                            <button type="button" class="btn btn-outline-light">Predaj oglas</button>
                            </router-link>
                        </div>
                        </div>
                    </div>
            </div>
            
        </div>
    <!-- </div> -->
</template>

<script>
import {store} from '../../store/store';

export default {
    name: 'Header',
    data(){
        return{
            user_id : store.state.user_id
        }
    },
    mounted(){
        this.user_id = store.state.user_id
    },
    computed:{
        
    },
}
</script>
    
<style scoped>
.container{
    width:60%;
}
.jumbotron{
    background-image: linear-gradient(to right top, #e23d3d, #df374b, #da3457, #d33363, #ca356d);
    /*
    background-image: linear-gradient(to right, #ffb100, #ff7830, #f23d51, #c9006d, #8b057f);
    */
    color: floralwhite;
    border-radius: 0;
}
.btn btn-outline-primary{
    color: floralwhite;
}
@media(max-width: 600px) {
    h1 {
        font-size: 25px;
    }
    p{
        font-size:15px;
    }
    #prijava{
       display: none;
    }
}
@media (min-width: 600px) and (max-width: 1024px){
    #prijava{
       display: none;
    }
}
</style>


