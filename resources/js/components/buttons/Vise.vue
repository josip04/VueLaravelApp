<template>
    <div>
        <router-link :to="'/restorani/'+ rest_id" class="btn btn-outline-secondary btn-block">
            Više
        </router-link>
    </div>
</template>

<script>
export default {
    name:'Vise',
    props: ['rest_id'], 
    data(){
        rest_id : props.rest_id
    },

}
</script>

<style scoped>
.btn-outline-secondary{
    color:#8b057f;
    background-color: #fff;
    border:1px solid #8b057f;
}
.btn-secondary:hover,btn-outline-secondary:active{
    color:#fff;
    background-color:#8b057f;
    border:1px solid #8b057f;
}
</style>