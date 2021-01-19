<template>
    <a href="/cart" class="nav-link">
    <span class="fas fa-shopping-cart fa-1x">
      Cart {{totalQty}}
    </span>
    </a>
</template>

<script>
    export default {
        data(){
            return{
                totalQty:'',
            }
        },
        methods:{
            loadQty(){
                Vue.axios.get('/totalQty').then((data)=>{
                    this.totalQty=data.data;
                })
            }
        },
        created(){
            this.loadQty();
            Fire.$on('reloadCart',()=>{
                this.loadQty();
            })

        },
        name: "NavBarCart"
    }
</script>

<style scoped>

</style>
