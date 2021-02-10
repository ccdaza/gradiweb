<template>
    <select class="form-control" @change="selectedBrand">
       <option value=""></option>
        <template v-for="brand in brands">
            <option :value="brand.id" :selected="value == brand.id">{{ brand.name }}</option>
        </template>
    </select>
</template>
<script>
    import axios from "axios";
    export default{
        data(){
            return {
                brands: []
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
                this.$emit("input", event.target.value);
            }
        },
        mounted(){
            this.getBrands();
        }
    }
</script>