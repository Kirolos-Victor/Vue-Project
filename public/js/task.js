Vue.component('coupon',{
    data(){
        return{
            code:'',
            invalides:['notkoko','koko']
        }

    },        template:`<input type="text" :value="code" @input="updateCode($event.target.value)" ref="input">`,
        methods:{
            updateCode(code){
                if(this.invalides.includes(code)){
                    alert("THE BEST");
                    this.$refs.input.value=code='';
                }
                this.$emit('input',code)

            }
        }

});
new Vue({
   el:'#app',
   data:{
       coupon:'coupon',
   }
});
