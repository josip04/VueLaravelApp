<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <ul class="list-group list-group-flush" v-for="proizvod in mojiProizvodi" :key="proizvod.id">
                    <li class="list-group-item">
                    {{proizvod.proizvod_naziv}} -
                    {{proizvod.kolicina*proizvod.cijena}},00 kn
                    <span class="badge badge-danger rounded-circle" style="font-size:14px;">{{proizvod.kolicina}}</span>
                    </li>
                </ul>
                <ul class="list-group list-group-flush" >
                    <li class="list-group-item" v-if="narudžba.length>0">Ukupno : <span>{{total}},00 kn</span></li>
                </ul>
            </div>


            <div class="col-md-4">
            <form @submit="predaj">
            <div class="form-group">
                <label for="adresa">Adresa </label>
                <input type="text" class="form-control" placeholder="unesi adresu" v-model="adresa">
            </div>
            <div class="form-group">
                <label for="kontakt">Kontakt</label>
                <input type="text" class="form-control" placeholder="unesi tel/mob" v-model="kontakt">
            </div>
            <button type="submit" class="btn btn btn-block btn-danger" v-if="narudžba.length>0">Naruči</button>
            <button type="submit" class="btn btn btn-block btn-danger" v-else disabled>Naruči</button>
            <router-link :to="'/restorani/'+ this.restoran_id" class="btn btn-outline-dark btn-block">Natrag</router-link>
            </form>
            </div>
        </div>
    </div>
</template>

<script>
import router from '../../routes';

export default {

    name:'PredajNarudžbu',
    data(){
        return{
            adresa:'',
            kontakt:'',
            //user_email:'',
            narudžba:'',
        }
    },
    props: ['mojiProizvodi','total','restoran_id'], 
    mounted(){
        for(let proizvod in this.mojiProizvodi){
            this.narudžba += this.mojiProizvodi[proizvod].proizvod_naziv+" - x"+this.mojiProizvodi[proizvod].kolicina+", \n";
        }
    },
    methods:{
        predaj(){
            this.$axios.post('narudzbe',{
                narudzba: this.narudžba,
                iznos: this.total,
                user_email: 'test@mail.com',
                adresa: this.adresa,
                kontakt:this.kontakt,
                restoran_id: this.restoran_id,
                status: 'u tijeku'
            })
            .then((response) => {
                console.log(response.data);
                router.push('/restorani/'+this.restoran_id);
            })
            .catch((error) => {
                console.log(error);
            });
        }
    },
}
</script>

<style scoped>
span{
    font-weight: bold;
}
.container{
    margin-bottom:25%;
}
</style>
