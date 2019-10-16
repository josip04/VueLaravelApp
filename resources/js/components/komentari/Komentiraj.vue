<template>
    <div class="container">
        <form @submit="komentiraj">
            <div class="form-group">
                <label for="komentar"></label>
                <textarea class="form-control" id="komentar" rows="3" placeholder="tvoj komentar..." v-model="komentar"></textarea>
            </div>
            <div class="form-group">
                <label for="ocijena" >Ocijena</label>
                <select name="ocijena" id="" class="custom-select col-md-2" v-model="ocijena">
                    <option class="form-control" value="1">1</option>
                    <option class="form-control" value="2">2</option>
                    <option class="form-control" value="3">3</option>
                    <option class="form-control" value="4">4</option>
                    <option class="form-control" selected value="5">5</option>
                </select>
            </div>
            <button type="submit" class="btn btn-outline-primary">Komentiraj</button>
        </form>
    </div>
</template>

<script>
import {store} from '../../store/store';

export default {
    name:'Komentiraj',
    data(){
        return{
            komentar:'',
            ocijena:'',
            user_id: store.state.user_id,
        }
    },
    mounted(){

    },
    props:['restoran_id'],
    methods:{
        komentiraj(event){
            event.preventDefault();
            this.$axios.post('restorani/'+this.restoran_id+'/komentari',{
                komentar:this.komentar,
                ocijena:this.ocijena,
                restoran_id: this.restoran_id,
                user_id: this.user_id
            })
            .then((response)=>{
                this.$root.$emit('ažurirajKomentare')
            });
        }
    },
}
</script>

<style scopd>

button{
    margin-bottom:5%;
}

</style>
