<template>
    <select class="form-control" @change="selectedOwner">
       <option value=""></option>
        <template v-for="owner in owners">
            <option :value="owner.id" :selected="value == owner.id">{{ owner.name }}</option>
        </template>
    </select>
</template>
<script>
    import axios from "axios";
    export default{
        data(){
            return {
                owners: []
            }
        },
        props: ["value"],
        methods: {
            getOwners(){
                axios.get("/owners")
                .then(response => {
                    this.owners = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
            },
            selectedOwner(event){
                this.$emit("input", event.target.value);
            }
        },
        mounted(){
            this.getOwners();
        }
    }
</script>