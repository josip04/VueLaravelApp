<template>
        <div class="container">
        <div class="row">
            
            <div class="col-md-3">
            <div class="card cardRestoran">
            <img class="card-img-top" v-if="restoran.slika_url!=null" :src="restoran.slika_url" :alt="restoran.naziv">
            <div class="card-body">
                <h3 class="card-title" v-if="avgOcijena>0"> {{restoran.naziv}} <span class="btn ocijena">{{avgOcijena}}</span> </h3>
                <h3 class="card-title" v-else> {{restoran.naziv}}</h3>
                <p class="card-text"> {{restoran.opis}} </p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Cijena dostave : <span>{{restoran.cijenaDst}}</span> </li>
                <li class="list-group-item">Minimalna narudžba : <span>{{restoran.minNar}}</span> </li>
                <li class="list-group-item"> <span>{{restoran.adresa}}</span> </li>
                <li class="list-group-item"> <span>{{restoran.kontakt}}</span> </li>
            </ul>
            <div class="card-body">
               <router-link to="/restorani"  class="btn btn-secondary btn-block">Natrag</router-link>
            </div>
            </div>

            </div>

            

            <!-- Prikaz proizvoda za kategoriju -->
            <div class="col-md-6" v-if="proizvodi.length>0">
            <table class="table">
                <thead class="thead">
                    <tr v-if="izabrana_kategorija">
                        <th colspan="4"><button class="btn btn-outline-dark btn-block" disabled>{{izabrana_kategorija}}</button></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="proizvod in proizvodi" :key="proizvod.id">
                    <th scope="row">{{proizvod.proizvod_naziv}}</th>
                    <td>{{proizvod.cijena}}(kn)</td>
                    <td>
                        <!-- <div class="form-group">
                            <input tyoe="text" class="form-control w-50" :id="proizvod.id" placeholder="0">
                        </div> -->
                    </td>
                        <td>
                            <button class="btn btn-outline-secondary" @click="smanjiKolicinu(proizvod)"> - </button>
                            <button class="btn btn-outline-secondary" @click="dodajProizvod(proizvod)"> + </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Komentari -->
            
            <Komentari :restoran_id="restoran_id"/>
            <Komentiraj :restoran_id="restoran_id" v-if="store.user_id"/>

            <!-- Komentari kraj -->
            </div>

            <div class="col-md-6" v-else>
                <div class="jumbotron">
                    <p>Trenutno ne postoje proizvodi za odabrani oglas/kategoriju.</p>
                </div>
            </div>
            <!-- Proizvodi Kraj -->





            <!-- Uprvaljanje sadržajem i košarica za korisnika -->
            <div class="col-md-3 mt-2">
            <div class="card" v-if="mojiProizvodi.length>0"> 
            <ul class="list-group list-group-flush" v-for="element in mojiProizvodi" :key="element.id">
                <li class="list-group-item">
                    <span>x{{element.kolicina}}</span> - {{element.proizvod_naziv}} <span>{{element.kolicina*element.cijena}},00 </span>  
                    
                    <span type="button" @click="izbaciProizvod(element,element.kolicina)" class="badge badge-danger rounded-circle" style="font-size:14px;">X</span>
                    
                </li>
            </ul>
             <div class="card-body">
                Ukupno : <span>{{total}}</span> ,00 kn
                <router-link
                v-if="restoran.minNar<total"
                :to="{ name: 'PredajNarudžbu', params: { mojiProizvodi: mojiProizvodi,total:total,restoran_id:restoran_id}}"  
                class="btn btn-danger btn-block" 
                style="margin-top:2%;">Naruči
                </router-link>
            </div>
            </div>

            <!-- Upravljanje oglasom - vidljivo samo za vlasnika oglasa koji mora biti logiran -->
            <div class="card" style="border:none">
            <div class="card-body" v-if="store.user && restoran.user_id===store.user_id">
               <router-link :to="'/restorani/'+ this.restoran_id + '/upravljanje-sadržajem'" class="btn btn-outline-secondary btn-block">Upravljanje sadržajem</router-link>
               <router-link :to="'/restorani/'+ this.restoran_id + '/izmijeni'" class="btn btn-outline-primary btn-block">Izmijeni</router-link>
               <button type="button" @click="izbrišiOglas()" class="btn btn-outline-danger btn-block"> Briši </button>
               <hr/>
            </div>
            <!-- Kraj -->

            

            <div class="card-body">
                <button class="btn btn-outline-secondary mr-2 mb-2" style="margin-top:2%;" @click="prikažiSveProizvode()" v-if="proizvodi.length>0"> Sve kategorije </button>
                <div class="btn-group" style="margin-top:2%;" role="group" v-for="kat in kategorije" :key="kat.id" >
                <button class="btn btn-outline-secondary mr-2 mb-2"  @click="prikažiProizvode(kat.id,kat.kategorija_naziv)">{{kat.kategorija_naziv}}</button>
                </div>
            </div>
            </div>

            </div>
            <!-- Kraj -->

            
        
        </div>
    </div>
</template>

<script>
import router from '../../routes';
import {store} from '../../store/store';
import Komentiraj from '../komentari/Komentiraj.vue';
import Komentari from '../komentari/Komentari.vue';

export default {
    name:'prikažiRestoran',
    components:{
        Komentiraj,
        Komentari,
    },
    data(){
        return {
            kategorije:[],
            kategorija_naziv:'',
            izabrana_kategorija:'',

            restoran: [],
            restoran_id: this.$route.params.id,

            proizvodi:[],
            total:0,
            mojiProizvodi:[],
            narudžba:'',

            store: store.state,

            avgOcijena:0,
        }
    },
    methods:{
        izbrišiOglas(){
            //console.log("this.restoran_id : " + this.restoran_id);
            this.$axios.delete('restorani/'+ this.restoran_id )
            .then( response => {
                router.push('/restorani');
            });
        },
        prikažiProizvode(kat_id,kat_naziv){
            this.$axios.get('proizvodi/' + kat_id)
            .then(response => {
                this.proizvodi = JSON.parse(JSON.stringify(response.data)); 
                this.izabrana_kategorija = kat_naziv;
            });
        },
        prikažiSveProizvode(){
            this.$axios.get('proizvodi/restoran/'+ this.restoran_id)
            .then( response => {
                this.proizvodi = JSON.parse(JSON.stringify(response.data)); 
                this.izabrana_kategorija = 'Sve';
            });
        },
         
        dodajProizvod(proizvod){
            let index = this.pronađiProizvod(proizvod);
            if(index==undefined){
                proizvod.kolicina = 1;
                this.mojiProizvodi.push(proizvod);
                this.ažurirajProizvode(proizvod,true,1);
                //console.log("Kolicina : " +  proizvod.kolicina + " Naziv : " + proizvod.proizvod_naziv);
            }
            if(index>=0){
                this.mojiProizvodi[index].kolicina++;
                this.ažurirajProizvode(proizvod,true,1);

                //console.log("Kolicina : " +  this.mojiProizvodi[index].kolicina + " Naziv : " + this.mojiProizvodi[index].proizvod_naziv);
            }
            
        },
        smanjiKolicinu(proizvod){
            let index = this.pronađiProizvod(proizvod);
            if(index!=undefined){//kada se izbaci proizvod tj. kad je kolicina 0, on više nema indeks a pokušavam izbacit proizvod bez indexa!
                let kolicina = this.mojiProizvodi[index].kolicina;
                if(kolicina>1){
                    this.mojiProizvodi[index].kolicina--;
                    this.ažurirajProizvode(proizvod,false,1);
                    //console.log("Količina : "+this.mojiProizvodi[index].kolicina + ", Naziv : " + this.mojiProizvodi[index].proizvod_naziv);
                }else{
                    this.izbaciProizvod(proizvod,1);
                }
            }
            
        },
        izbaciProizvod(proizvod,kol){
                let stog = this.mojiProizvodi,stog2 = [];
                while(stog.length!=0){
                    let element = stog.pop();
                    if(element.id!=proizvod.id){
                        stog2.push(element);
                    }else{
                        this.ažurirajProizvode(proizvod,false,kol);
                    }
                    //console.log("Element : "+element.proizvod_naziv);
                }
                while(stog2.length!=0){
                    stog.push(stog2.pop());
                }
                /* for(let i=0;i<stog.length;i++){
                    console.log("["+i+"] , Količina : "+stog[i].kolicina+" , Naziv : " +stog[i].proizvod_naziv);
                } */
        },
        pronađiProizvod(proizvod){
            let length = this.mojiProizvodi.length;
            for(let index=0;index<length;index++){
                if(this.mojiProizvodi[index].id==proizvod.id){
                    return index;
                }
            }
        },
        ažurirajProizvode(proizvod,isTrue,kol){
            //ažuriraj količinu za UI na ovaj način
            this.mojiProizvodi.push(proizvod);
            this.mojiProizvodi.pop();
            

            //ažuriraj ukupnu cijenu
            if(isTrue){
                this.total+=kol*proizvod.cijena;
            }else{
                this.total-=kol*proizvod.cijena;
            }
            /* 
            for(let i=0;i<this.mojiProizvodi.length;i++){
                this.total += this.mojiProizvodi[i].kolicina*this.mojiProizvodi[i].cijena;
            } */
        },
    },




    mounted(){

        this.$axios.get('restorani/'+ this.restoran_id )
        .then( response => {
            console.log(response.data);
            this.restoran = response.data;
        });

        //dohvati sve kategorije i za svaku kategoriju prikaži proizvode 
        this.$axios.get('kategorije/'+ this.restoran_id)
        .then(response => {
            this.kategorije = response.data;
        });
        this.$axios.get('proizvodi/restoran/'+ this.restoran_id)
            .then( response => {
                this.proizvodi = JSON.parse(JSON.stringify(response.data)); 
                this.izabrana_kategorija = 'Sve';
        });

        this.$axios.get('restorani/'+this.restoran_id+'/komentari')
        .then((response)=>{
            for(let ocijena in response.data){
                    this.avgOcijena += response.data[ocijena].ocijena;
                }
            this.avgOcijena/=response.data.length;
            console.log(this.avgOcijena);
        });
    },
}
</script>

<style scoped>
.ocijena{
    background-color:#8b057f;
    color: floralwhite;
    width: 50px;
    height: 50px;
    padding: 12.5px 3px 3px 3px;
    border-radius: 35px;
    font-size: 0.6em;
    border:none;
}
.btn-secondary{
    color:#8b057f;
    background-color: #fff;
    border:1px solid #8b057f;
}
.btn-secondary:hover,btn-outline-secondary:active{
    color:#fff;
    background-color:#8b057f;
    border:1px solid #8b057f;
}
.jumbotron{
    margin-top:2%;
}
span{
    font-weight: bold;
}
table thead tr th{
    border:none;
}
.cardRestoran{
    margin-top: 2%;
    margin-bottom: 80%; /* "za sticky footer" */
}
</style>
