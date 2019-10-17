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
                    <div class="card" >
                        <img class="card-img-top" style="max-height:30%" v-if="rest.slika_url!=null" :src="rest.slika_url" >
                        <div class="card-body">
                        <h5 class="card-title border-bottom pb-3">{{rest.naziv}}</h5>
                        <p class="card-text">{{rest.opis}}</p>
                        <router-link :to="'/restorani/'+ rest.id" class="btn btn-outline-secondary btn-block">Više</router-link>
                        </div>
                    </div>
                
            </div>
        </div>

        </div>
    </div>
    
</template>

<script>
import moment from 'moment';
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
                return restoran.naziv.match(this.search) || restoran.kontakt.match(this.search) || restoran.adresa.match(this.search)
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
        },
        components: {
            Header,
        }
        
    }
</script>

<style scoped>
.btn-outline-secondary{
    color:#8b057f;
    border:1px solid #8b057f;
    width: 25%;
    float: right;
}
.btn-outline-secondary:hover,btn-outline-secondary:active{
    color:#fff;
    background-color:#8b057f;
    border:1px solid #8b057f;
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
</style>

