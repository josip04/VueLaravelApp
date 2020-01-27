<template>
    <div class="container mt-2">
        <div id="button">
            <div class="btn-group" role="group">
            <router-link :to="'/restorani/'+ this.restoran_id+'/upravljanje-sadržajem'" class="btn btn-outline-secondary">Natrag</router-link>
            </div>
        </div>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <td>
                        <div class="form-group">
                                <input type="text" class="form-control" placeholder="email/adresa/datum/status" v-model="search">
                        </div>
                    </td>
                </tr>

                <tr>
                <th scope="col">Id</th>
                <th scope="col">Narudžba</th>
                <th scope="col">Iznos(kn)</th>
                <th scope="col">Email</th>
                <th scope="col">Adresa</th>
                <th scope="col">Kontakt</th>
                <th scope="col">Zaprimljena</th>
                <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="narudzba in filtriraneNarudzbe" :key="narudzba.id" @click="prikažiStatus(narudzba.id)">
                    <td>{{narudzba.id}}</td>
                    <td>{{narudzba.narudzba}}</td>
                    <td>{{narudzba.iznos}},00</td>
                    <td>{{narudzba.user_email}}</td>
                    <td>{{narudzba.adresa}}</td>
                    <td>0{{narudzba.kontakt}}</td>
                    <td>{{narudzba.created_at}}</td>
                    <td v-if="narudzba.status=='u tijeku'"><span class="badge badge-warning">{{narudzba.status}}</span></td>
                    <td v-else-if="narudzba.status=='gotovo'"><span class="badge badge-primary">{{narudzba.status}}</span></td>
                    <td v-else-if="narudzba.status=='rješeno'"><span class="badge badge-success">{{narudzba.status}}</span></td>
                    <td v-else><span class="badge badge-danger">{{narudzba.status}}</span></td>
                </tr>
                <tr v-if="search.length>0 && izračunajTotal>0">
                    <td>Ukupno : {{izračunajTotal}},00 kn </td>
                </tr>

            </tbody>
        </table>



        <table class="table col-md-6" style="margin-top:5%;" v-if="narudzba_id">
            <thead>
                <tr>
                    <td>
                        Izmijeni status za narudžbu (Id - {{narudzba_id}})
                    </td>
                    <td>
                         <div class="form-group">
                            <select name="kategorija" id="#" class="custom-select" v-model="narudzba_status">
                                <option for="kategorija" class="form-control" value="u tijeku">U tijeku</option>
                                <option for="kategorija" class="form-control" value="gotovo">Gotovo</option>
                                <option for="kategorija" class="form-control" value="rješeno">Riješeno</option>
                                <option for="kategorija" class="form-control" value="otkazano">Otkazano</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <button type="submit" @click="spremiStatus()" class="btn btn-outline-secondary" >Spremi</button>
                    </td>
                </tr>
            </thead>
        </table>

    </div>
</template>

<script>

export default {
    data(){
        return {
            narudzbe:[],
            restoran_id: this.$route.params.id,
            narudzba_id:'',
            narudzba_status:'',
            search:'u tijeku',
        }
    },
    computed: {
        filtriraneNarudzbe: function() {
            return this.narudzbe.filter( (narudzba) => {
                return narudzba.user_email.match(this.search) || narudzba.status.match(this.search) || narudzba.created_at.match(this.search) || narudzba.adresa.match(this.search)
            })
        },
        izračunajTotal: function(){
            let narudzbe = this.filtriraneNarudzbe,total = 0;
            for(let index in narudzbe){
                total += narudzbe[index].iznos;
            }
            return total;
        }
    },
    mounted(){
        this.$axios.get('narudzbe/'+this.restoran_id)
        .then((response) => {
            this.narudzbe = response.data;
        });
    },
    methods:{
        prikažiStatus(narudzba_id){
            this.narudzba_id = narudzba_id;
        },
        spremiStatus(narudzba_id){
            this.$axios.put('narudzbe/'+ this.narudzba_id,{
                restoran_id: this.restoran_id,
                status:this.narudzba_status,
            })
            .then((response)=>{
                this.narudzbe = response.data;
            });
        },
    },
}
</script>

<style scoped>
.btn-outline-secondary{
    color:#2f4858;
    border:1px solid #2f4858;
}
.btn-outline-secondary:hover,btn-outline-secondary:active{
    color:#fff;
    background-color: #2f4858;
    border:1px solid #2f4858;
}
#button{
    margin-bottom: 5%;
}
table tbody tr {
    cursor: pointer;
}
.container{
    margin-bottom: 25%;
}
</style>
