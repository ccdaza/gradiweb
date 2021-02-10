<template>
    <select class="form-control" @change="selectedType">
       <option value=""></option>
        <template v-for="type in types">
            <option :value="type.id" :selected="value == type.id">{{ type.name }}</option>
        </template>
    </select>
</template>
<script>
    import axios from "axios";
    export default{
        data(){
            return {
                types: []
            }
        },
        props: ["value"],
        methods: {
            getTypes(){
                axios.get("/types")
                .then(response => {
                    this.types = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
            },
            selectedType(event){
                this.$emit("input", event.target.value);
            }
        },
        mounted(){
            this.getTypes();
        }
    }
</script>