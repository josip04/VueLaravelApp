<template>
    <div>
        <div class="container mt-5">
            <div class="row justify-content-center">
            <!-- BUG : u uvjetu je 1 a ne 0 jer ako korisnik kopira link i napravi npr: Ctrl+Z broj znakova je 0 ali i dalje se prikazuje HTML element  -->
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
            
            <!--
            <div class="form-group">
                <label  v-if="slika_url.length <= 191" for="slika_url"></label>
                <label  v-else for="slika_url"><span>Link mora imati manje od 191 znaka</span> </label>
                <input type="text" class="form-control" @change="izborSlike" id="slika_url" placeholder="URL slike" v-model="slika_url">
            </div> 

            <div class="row mt-2 mb-2">
                <div class="col"><hr></div>
                <div class="col-auto mb-2" ><p style="font-size:20px;color:gray">ili</p></div>
                <div class="col"><hr></div>
            </div>
            -->

            <div class="custom-file" id="customFile">
                <input type="file" class="custom-file-input" id="slika" @change="izborSlike">
                <label class="custom-file-label" for="slika">
                    <span v-if="slika_naziv">{{ this.slika_naziv }}</span>
                    <span v-else>Izaberi sliku...</span>
                </label>
            </div>  
           


            <hr>
            
            <button type="submit" class="btn btn btn-block btn-primary">Predaj oglas</button>
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
            slika: '',  //<img class="card-img-top" :src="slika" max-size>
            /*
            slikaBase64 : '',
            
            */
            slika_url: '',
            user_id: store.state.user_id,
            restorani : [], //za validaciju
            error_naziv :'',
        }
    },
    mounted(){
            // popuni restorani : []
            this.$axios.get('restorani')
                .then(response => {
                this.restorani = response.data;
                //console.log(store.restorani);
            });
             
    },
    methods:{
        predajOglas(event){
                event.preventDefault();//spriječi stvarni submit
                this.$axios.post('restorani',{
                    naziv: this.naziv,
                    opis: this.opis,
                    cijenaDst: this.cijenaDst,
                    minNar: this.minNar,
                    adresa:this.adresa,
                    kontakt: this.kontakt,
                    slika: this.slika,
                    /*
                    slika: localStorage.getItem('slika_naziv'), //slika_naziv
                    slikaBase64 : localStorage.getItem('slikaBase64')
                    */
                    user_id: this.user_id,

                    },
                    ).then( response => {
                    router.push('/restorani');
                    /*
                    localStorage.removeItem('slika_naziv');
                    localStorage.removeItem('slikaBase64');
                    */
                    console.log(response.data)
                })
                .catch( error => {
                    localStorage.removeItem('slika_url');
                    if(error.response.status == 422) {
                        let errors = JSON.parse(JSON.stringify(error.response.data.errors));
                        if(errors.naziv.length>0){
                            this.error_naziv = errors.naziv.toString().replace(/"[]/g,""); 
                            console.log(this.error_naziv);
                        }
                        //console.log(error.response.data.errors.naziv);
                    }
                    
                });
            },
          izborSlike (event){ 
            
            let image = event.target.files[0];
            //console.log('event.target OBJ: ' +  event.target);// [object HTMLInputElement]
            //console.log(datoteka);
            this.slika_naziv = image.name;//napravi update u polju Izaberi sliku...
            let reader = new FileReader();
            if(image){
                reader.readAsDataURL(image);
                reader.onload = (event) => { //referencira na slikaBase64 unutar Vue komponente , nije radilo samo zbog ovog : = (event) =>
                this.slika = event.target.result; //i zbog ovog reader.result; , zahtjeva HTML input objekt '[object HTMLInputElement]' a ne base64 string ili file[i] objekt
                //let slikaBase64 = reader.result.replace(/^data:(.*;base64,)?/, '');
                console.log("event.target.result : " + this.slika);
                /*console.log("slikaBase64 : " + slikaBase64);
                localStorage.setItem('slika_naziv', image.name);
                localStorage.setItem('slikaBase64', slikaBase64);*/
            }
            

            }
            
           
            /*
            komentirano jer mogu pohranit sliku na server storage => app => public ali ne mogu dohvatit preko domene + storage path iako sam pokušao sve moguće načine
            npr. https://quickadminpanel.com/blog/file-upload-in-laravel-the-ultimate-guide/   => Storage folder: files are not public?
            
            NOVI NAČIN - LINK URL

            console.log("slika_url : " + slika_url.value);
            */
        },
        validacijaNaziv(event){
            this.error_naziv = '';
            //console.log(store.restorani);
            for(let i=0;i<this.restorani.length;i++){
                if(this.naziv === this.restorani[i].naziv) { 
                   this.error_naziv = "Ime restorana je već zauzeto!";
                   console.log(this.error_naziv);
                }
                //console.log(store.restorani[i].naziv);
                //console.log("Ime restorana je već zauzeto!!!!");
                
            }
        }
    }
}
</script>

<style  scoped>

span{
    color: gray;
    font-weight: bold;
}
label{
    color:gray;
    font-weight: bold;
}

</style>

