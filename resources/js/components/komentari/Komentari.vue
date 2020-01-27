<template>
    <div class="container mt-5">
        <div v-if="komentari.length!=0">
            <div class="jumbotron" v-for="komentar in komentari" :key="komentar.id">
            <h5 v-if="komentar.user!=null">{{komentar.user.name}}</h5>
            <p>{{komentar.komentar}}</p>
            <p style="font-size:0.85em;">Ocijena<span class="font-weight-bold rounded-circle ocijena">{{komentar.ocijena}}</span></p>
            <span class="text-muted">{{komentar.created_at}}</span>
            <tr v-if="id!=komentar.id && komentar.user_id==user_id"> 
                
                <button class="btn btn-outline-primary btn-sm" @click="brišiKomentar(komentar.id)">Briši</button>
                <button class="btn btn-outline-primary btn-sm" @click="izmijeniKomentar(komentar.id)">Izmijeni</button>
            </tr>
            <div class="form-group" v-if="komentar.user_id==user_id && id==komentar.id">
                <textarea class="form-control" id="komentar" placeholder="tvoj novi komentar..." v-model="novi_komentar" style="margin-bottom:2%;"></textarea>
                <tr>
                    <button type="submit" class="btn btn-outline-primary btn-sm" @click="ažurirajKomentar(komentar.id)">Izmijeni</button>
                    <button type="submit" class="btn btn-outline-secondary btn-sm" @click="odustani()">Odustani</button>
                </tr>
                
            </div>
            
                
            </div>
        </div>
        <div v-else>
            <div class="jumbotron">
                <p>Nema komentara.</p>
            </div>
        </div>
        
    </div>
</template>

<script>
import {store} from '../../store/store';


export default {
    name:'Komentari',
    props:['restoran_id'],
    data(){
        return{
            komentari:[],
            novi_komentar:'',
            user_id: store.state.user_id,
            id: '',
        }
    },
    mounted(){
        
        this.$axios.get('restorani/'+this.restoran_id+'/komentari')
        .then((response)=>{
            this.komentari = response.data;
        });
        this.$root.$on('ažurirajKomentare', () => {
             this.$axios.get('restorani/'+this.restoran_id+'/komentari')
                .then((response)=>{
                    this.komentari = response.data;
                    for(let i=0;i<this.komentari.length;i++){
                    }
                });
            })
    },
    methods:{
        brišiKomentar(id){
             this.$axios.delete('restorani/'+this.restoran_id+'/komentari/'+ id)
            .then((response)=>{
                this.komentari = response.data;
            });
        },
        izmijeniKomentar(id){
            this.id = id;
        },
        odustani(){
            this.id = '';
        },
        ažurirajKomentar(id){
             this.$axios.put('restorani/'+this.restoran_id+'/komentari/'+ id,{
                komentar: this.novi_komentar
            })
            .then((response) => {
                this.komentari = response.data;
                this.id = '';
            });
        },
        ažurirajKomentare(){
            this.$axios.get('restorani/'+this.restoran_id+'/komentari')
            .then((response)=>{
                this.komentari = response.data;
            });
        }
    }
}
</script>

<style scoped>
.btn-outline-primary{
    color:#2f4858;
    border:1px solid #2f4858;
}
.btn-outline-primary:hover,btn-outline-primary:active{
    color:#fff;
    background-color: #ca356d;
    border:1px solid #ca356d;
}
.btn-outline-secondary{
    color:#2f4858;
    border:1px solid #2f4858;
}
.btn-outline-secondary:hover,btn-outline-secondary:active{
    color:#fff;
    background-color: #2f4858;
    border:1px solid #2f4858;
}
hr{
    color: inherit;
    margin-top: 30%;
}
.jumbotron{
    padding: 5% 5%;
    color:#2f4858;
    /* border-radius: 0%; */
    border:1px solid #2f4858;
    /*background-image: linear-gradient(to right, #ffb100, #ff7830, #f23d51, #c9006d, #8b057f); */
    background-color:white;
}
.text-muted{
    font-style: italic;
    font-size: 0.7em;
}
.ocijena{
    background-color:#2f4858;
    color: floralwhite;
    padding: 3px 6px 3px 6px;
    margin-left:2%;
    border-radius: 35px;
    font-size: 0.9em;
    border:none;
}
</style>
