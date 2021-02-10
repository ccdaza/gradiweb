<template>
   <div>
       <select class="form-control" @change="selectedBrand" v-if="!other">
           <option value=""></option>
            <template v-for="brand in brands">
                <option :value="brand.name" :selected="value == brand.name">{{ brand.name }}</option>
            </template>
            <option value="other">Otro</option>
        </select>
        <div class="input-group mb-3" v-else>
          <input type="text" class="form-control" placeholder="Otro" @change="selectedBrand">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" @click="other=false">Cancelar</button>
          </div>
        </div>
   </div>
</template>
<script>
    import axios from "axios";
    export default{
        data(){
            return {
                brands: [],
                other: false
            }
        },
        props: ["value"],
        methods: {
            getBrands(){
                axios.get("/brands")
                .then(response => {
                    this.brands = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
            },
            selectedBrand(event){
                if(event.target.value == "other"){
                    this.other = true;
                }else{
                    this.$emit("input", event.target.value);
                }
            }
        },
        watch: {
            other(value){
                this.$emit("input", "");    
            }
        },
        mounted(){
            this.getBrands();
        }
    }
</script>