import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export default new VueRouter({
    routes: [
        {
            path:'/restorani',
            component: require('./components/restorani/Restorani.vue').default
        },
        /*{
            path:'/restorani/:id',
            component: require('./components/restorani/prikažiRestoran.vue').default
        },*/
        {  
            path:'/restorani/:id/izmijeni',
            component: require('./components/restorani/izmijeniRestoran.vue').default
        },




        {  
            path:'/restorani/:id/upravljanje-sadržajem',
            component: require('./components/restorani/sadržaj/CMS.vue').default
        },
        {  
            path:'/restorani/:id/upravljanje-sadržajem/pregled-narudzbi',
            component: require('./components/restorani/sadržaj/Narudžbe.vue').default
        },
        {  
            path:'/restorani/:id/predaj-narudžbu',
            component: require('./components/restorani/predajNarudžbu.vue').default,
            name:'PredajNarudžbu',
            props: true,
        },


        {
            path:'/restorani/:id/komentiraj',
            component:require('./components/komentari/Komentiraj.vue').default,
            name:'Komentiraj',
            props:true,
        },
        {
            path:'/restorani/:id/komentari',
            component:require('./components/komentari/Komentari.vue').default,
            name:'Komentari',
            props:true,
        },

        {  
            path:'/novi',
            component: require('./components/restorani/NoviOglas.vue').default
        },
        


        {  
            path:'/prijava',
            component: require('./components/Prijava.vue').default
        },
        {  
            path:'/registracija',
            component: require('./components/Registracija.vue').default
        },



        //buttons
        {  
            path:'/restorani/:id',
            component: require('./components/restorani/prikažiRestoran.vue').default,
            name:'Vise',
            props:true,
        },
        
    ]
  });
