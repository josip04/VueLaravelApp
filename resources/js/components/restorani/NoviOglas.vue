<template>
    <div>
        <div class="container mt-5">
            <div class="row justify-content-center">
           
            <div  v-if="(naziv || opis || slika_url.length > 1 || slika.length > 1)"  class="card" style="width: 18rem;">
            <img class="card-img-top" v-if="slika.length > 1" :src="slika" max-size>
            <div class="card-body">
                <h4 class="card-title" :v-if="naziv"> {{ this.naziv }} </h4>
                <p class="card-text"  :v-if="opis">{{this.opis}}</p>
            </div>
            </div>
            
            <div class="col-md-4">
            <form @submit="predajOglas">
            
            <div class="form-group">
            <label for="naziv" v-if="error_naziv.length==0" >Ime restorana </label>
            <label for="naziv" v-if="error_naziv.length>0"> <span>{{error_naziv}}</span> </label>
            <input type="text" class="form-control" @change="validacijaNaziv" id="naziv" v-model="naziv">
            </div>
            <div class="form-group">
                <label for="opis">Kratak opis</label>
                <input type="text" class="form-control" id="opis"  v-model="opis">
            </div>

            <div class="form-group">
                <label for="cijenaDst">Cijena dostave</label>
                <input type="text" class="form-control" id="cijenaDst" min="0" max="100" placeholder="0" v-model="cijenaDst">
            </div>
            <div class="form-group">
                <label for="minNar">Minimalna narudžba</label>
                <input type="text" class="form-control" id="minNar" min="0" placeholder="0" v-model="minNar">
            </div>
            
            <div class="form-group">
                <label for="kontakt">Telefon/Mobiltel</label>
                <input type="text" class="form-control" id="kontakt" v-model="kontakt">
            </div>

            <div class="form-group">
                <label for="adresa">Adresa</label>
                <input type="text" class="form-control" id="adresa"  v-model="adresa">
            </div>

            <div class="custom-file" id="customFile">
                <input type="file" class="custom-file-input" id="slika" @change="izborSlike">
                <label class="custom-file-label" for="slika">
                    <span v-if="slika_naziv">{{ this.slika_naziv }}</span>
                    <span v-else>Izaberi sliku...</span>
                </label>
            </div>  
           


            <hr>
            
            <button type="submit" class="btn btn-block btn-outline-primary">Predaj oglas</button>
            </form>
            </div>

        </div>
    </div>
    </div>
</template>

<script>
import router from '../../routes';
import {store} from '../../store/store';

export default {
    name: 'NoviOglas',
    data(){
        return{
            naziv : '',
            opis : '',
            cijenaDst : '',
            minNar : '',
            kontakt : '',
            adresa : '', 
            slika_naziv : '',
            slika: '', 
            slika_url: '',
            user_id: store.state.user_id,
            restorani : [], 
            error_naziv :'',
        }
    },
    mounted(){
            this.$axios.get('restorani')
                .then(response => {
                this.restorani = response.data;
            });
             
    },
    methods:{
        predajOglas(event){
            event.preventDefault();
            this.$axios.post('restorani',{
                naziv: this.naziv,
                opis: this.opis,
                cijenaDst: this.cijenaDst,
                minNar: this.minNar,
                adresa:this.adresa,
                kontakt: this.kontakt,
                slika: this.slika,
                user_id: this.user_id,
                })
                .then( response => {
                    router.push('/restorani');
                })
                .catch( error => {
                    localStorage.removeItem('slika_url');
                    if(error.response.status == 422) {
                        let errors = JSON.parse(JSON.stringify(error.response.data.errors));
                        if(errors.naziv.length>0){
                            this.error_naziv = errors.naziv.toString().replace(/"[]/g,""); 
                    }
                }
            });
        },
        izborSlike (event){ 
        let image = event.target.files[0];
        this.slika_naziv = image.name;
        let reader = new FileReader();
            if(image){
                reader.readAsDataURL(image);
                reader.onload = (event) => {
                this.slika = event.target.result;
                }
            }
        },
        validacijaNaziv(event){
            this.error_naziv = '';
            for(let i=0;i<this.restorani.length;i++){
                if(this.naziv === this.restorani[i].naziv) { 
                   this.error_naziv = "Ime restorana je već zauzeto!";
                }
            }
        }
    }
}
</script>

<style  scoped>
.btn-outline-primary{
    color:#2f4858;
    border:1px solid #2f4858;
}
.btn-outline-primary:hover,btn-outline-primary:active{
    color:#fff;
    background-color: #ca356d;
    border:1px solid #ca356d;
}
span{
    color: gray;
    font-weight: bold;
}
label{
    color:gray;
    font-weight: bold;
}

</style>

