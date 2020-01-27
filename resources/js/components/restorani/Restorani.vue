<template>
    <div>
        <Header /> <!-- :user_id={user_id} -->
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="cold-md-3">
                    <input class="form-control mr-sm-2" type="search" placeholder="pretraži"  v-model="search">
                </div>
            </div>
            
            <div class="row margin-top">
                <div class="col-md-4" v-for="rest in filtriraniRestorani" :key="rest.id">
                        <div class="card mb-4 box-shadow" >
                            <img class="card-img-top" v-if="rest.slika_url!=null" :src="rest.slika_url" >
                            <div class="card-body">
                            <h3 class="card-title border-bottom pb-3">{{rest.naziv}}</h3>
                            <p class="card-text">{{rest.opis}}</p>
                            <router-link :to="'/restorani/'+ rest.id" class="btn btn-outline-secondary btn-block mb-5">Više</router-link>
                            </div>
                        </div>
                    
                </div>
            </div>
        </div>
        
    </div>
    
</template>

<script>
import moment from 'moment';
import {store} from '../../store/store'
import Header from './Header';

    export default {
        name : 'Restorani',
        data () {
            return {
                restorani:[],
                search:'',
            }
                
            
        },
        computed:{
            filtriraniRestorani: function() {
            return this.restorani.filter( (restoran) => {
                return restoran.naziv.toLowerCase().match(this.search) || restoran.naziv.match(this.search) || restoran.kontakt.match(this.search) || restoran.adresa.match(this.search)
                })
            },
            izracunajProsjek: function(){
                
            }
        },
        methods : {
            formatiraj_datum(date){
                return moment(date).format('DD-MM-YYYY HH:mm:ss')
            },
        },
        mounted() {
            this.$axios.get('restorani')
                .then(response => {
                    this.restorani = response.data;
                })
                .catch(error => {
                    //
            });
            this.$root.$on('userLoggedIn',() => {
                this.$alertify.success('success');
            });
            
        },
        components: {
            Header,
        }
        
    }
</script>

<style scoped>

.btn-outline-secondary{
    color:#2f4858;
    border:1px solid #2f4858;
    width: 25%;
    float: left;
}
.btn-outline-secondary:hover,btn-outline-secondary:active{
    color:#fff;
    background-color: #ca356d;
    border:1px solid #ca356d;
}
.margin-top{
    margin-top: 5%;
}
.card-padding-side{
    padding: 0% 1% 0% 1%;
}
.text-italic{
    font-style: italic;
}
@media(max-width: 600px) {
    .btn{
        width:60%;
        margin-left:12%;
    }
    .card{
        max-width:99.5%;
    }
}
.card{
    display: inline; /* zbog preklapanja oglasa */

}
h4{
    font-weight: bold;
    color: #2f4858;
}
.box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
</style>

