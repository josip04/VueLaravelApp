<template>
<div>
        <div class="container mt-2">
            <div id="button">
                <div class="btn-group" role="group">
                <router-link :to="'/restorani/'+ this.restoran_id" class="btn btn-outline-secondary">Natrag</router-link>
                <router-link :to="'/restorani/'+this.restoran_id+'/upravljanje-sadržajem/pregled-narudzbi'" class="btn btn-outline-secondary">Pregled narudžbi</router-link>
                </div>
            </div>
            
          

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <td>
                            <div class="form-group">
                                <label for="kategorija" v-if="this.error_poruka.length==0">Naziv kategorije</label>
                                <label for="kategorija" v-else><span>{{this.error_poruka}}</span></label>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="kategorija" placeholder="naziv kategorije" v-model="nova_kategorija">
                            </div>
                        </td>

                        <td>
                            <button type="submit" @click="ubaciKategoriju()" class="btn btn-outline-secondary" >Spremi</button>
                        </td>
                    </tr>


                    <tr>
                    <th scope="col">Naziv kategorije</th>
                    <th scope="col">Datum kreiranja</th>
                    <th scope="col">Prikaži proizvode</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    <tr v-for="kat in kategorije" :key="kat.id">
                    <th>{{kat.kategorija_naziv}}</th>
                    <td>{{kat.created_at}}</td>
                    <td><button class="btn btn-outline-secondary" @click="prikažiProizvod(kat.id)">Prikaži</button></td>
                    <td><button class="btn btn-outline-danger" @click="izbrišiKategoriju(kat.id)">Briši</button></td>
                    </tr>
                </tbody>
            </table>


            <hr/>

            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <td>
                            <div class="form-group">
                                <select name="kategorija" id="#" class="custom-select" v-model="kategorija_id">
                                    <option for="kategorija" class="form-control" v-for="kat in kategorije" :key="kat.id" :value="kat.id">{{kat.kategorija_naziv}}</option>
                                </select>
                            </div>
                        </td>

                        <td>
                            <div class="form-group">
                                <input type="text" class="form-control" id="proizvod" placeholder="ime proizvoda" v-model="proizvod_naziv">
                            </div>
                        </td>

                        <td>
                             <div class="form-group">
                                <input type="text" class="form-control" id="cijena" placeholder="cijena" v-model="cijena">
                            </div>
                        </td>

                        <td>
                             <button type="submit" @click="ubaciProizvod()" class="btn btn-outline-secondary" >Spremi</button>
                        </td>
                    </tr>

                    
                    <tr v-if="prikaži">
                    <th scope="col">Naziv proizvoda</th>
                    <th scope="col">Cijena (kn)</th>
                    <th scope="col">Datum kreiranja</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <tr v-for="proizvod in proizvodi" :key="proizvod.id">
                    <th scope="row">{{proizvod.proizvod_naziv}}</th>
                    <td>{{proizvod.cijena}}</td>
                    <td>{{proizvod.created_at}}</td>
                    <td><button class="btn btn-outline-danger" @click="izbrišiProizvod(proizvod.id)">Briši</button></td>
                    </tr>
                </tbody>
            </table>


        </div>
    </div>

</template>


<script>
export default {
    name:'CMS',
    data(){
        return {           
            nova_kategorija : '',
            kategorije:[],
            kategorija_id:'',
            kat: '',
            error_poruka : '', 

            proizvod_naziv:'',
            cijena:'',
            proizvodi:[],
            proizvod:'',
            restoran_id: this.$route.params.id,
            error_poruka2: '',
            prikaži: false 
        }
        
    },
    mounted(){
        this.$axios.get('kategorije/'+ this.restoran_id)
        .then(response => {
            this.kategorije = response.data;
        });
        

    },
    methods : {
        ubaciKategoriju(){
            if(this.nova_kategorija.length>0){
                this.error_poruka='';
                this.$axios.post('kategorije',{
                    kategorija_naziv : this.nova_kategorija,
                    restoran_id: this.restoran_id,
                })
                .then(response => {
                    this.kategorije = response.data;
                })
            }else{
                this.error_poruka = 'Kategorija ne smije biti prazna!';
            }
        },
        izbrišiKategoriju(kat_id){
            this.$axios.delete('kategorije/'+ kat_id,{
                params: {
                    restoran_id: this.restoran_id
                }
            })
            .then(response => {
                this.kategorije = response.data; 
                this.proizvodi = null;
                this.prikaži=false;
            });
        },
        ubaciProizvod(){
            this.prikaži = true;
             if(this.proizvod_naziv.length>0){
                this.error_poruka2='';
                this.$axios.post('proizvodi',{
                    proizvod_naziv : this.proizvod_naziv,
                    cijena: this.cijena,
                    kategorija_id: this.kategorija_id,
                    restoran_id: this.restoran_id
                })
                .then(response => {
                    this.proizvodi = response.data;
                });
            }else{
                this.error_poruka2 = 'Naziv proizvoda ne smije biti prazan!';
            } 
        },
        prikažiProizvod(kat_id){
            this.prikaži = true;
            this.$axios.get('proizvodi/' + kat_id)
            .then(response => {
                this.proizvodi = response.data; 
            });
        },
        izbrišiProizvod(proizvod_id){
            this.$axios.delete('proizvodi/'+ proizvod_id)
            .then(response => {
                this.proizvodi = response.data; 
            });
        },
    },
}
</script>

<style scoped>
#button{
    margin-bottom: 5%;
}
.btn-outline-danger{
    color:#ca356d;
    background-color: #fff;
    border:1px solid #ca356d;
}
.btn-outline-danger:hover,btn-outline-danger:active{
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
h2{
    margin-bottom: 2%;
}
span{
    color: red;
    font-weight: bold;
}
hr{
    margin: 5% 0% 5% 0%;
}
.custom-select {
    height: auto ;
    padding: 3% 1.5% !important;
    margin-bottom: 2% ;
}

</style>