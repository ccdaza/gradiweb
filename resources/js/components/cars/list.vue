<template>
    <div>
        <table class="table  table-striped">
            <thead class="thead-dark">
                <tr>
                  <th scope="col">Placa</th>
                  <th scope="col">Marca</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Nombre Propietario</th>
                  <th scope="col">Cedula Propietario</th>
                </tr>
                 <tr>
                    <th scope="col">
                        <input type="text" class="form-control" v-model="plate">
                    </th>
                    <th scope="col">
                        <brand-select v-model="brand"></brand-select>
                    </th>
                    <th scope="col">
                        
                   </th>
                    <th scope="col">
                        <input type="text" class="form-control" v-model="name">
                   </th>
                    <th scope="col">
                        <input type="text" class="form-control" v-model="document">
                   </th>
                </tr>
                </thead>
                <tbody>
                <template v-for="car in filtredCars">
                    <tr>
                        <td>{{ uppercase(car.plate) }}</th>
                        <td>{{ capitalize(car.brand.name) }}</td>
                        <td>{{ capitalize(car.type.name) }}</td>
                        <td>{{ car.owner.name }}</td>
                        <td>{{ car.owner.document }}</td>
                    </tr>
               </template>
                
            </tbody>
        </table>
    </div>
</template>


<script>
    import axios from 'axios';
    import brandSelect from '../brands/select';
    export default{
        data(){
            return {
                cars: [],
                error: false,
                message: "",
                plate: "",
                type: "",
                brand: "",
                name: "",
                document: ""
            }
        },
        methods: {
            async getCars(){
                await axios.get("/cars")
                .then(response => {
                    this.cars = response.data;
                })
                .catch(error => {
                    this.error = true;
                    this.message = error.response.data,message;
                })
            },
            uppercase(text){
                return text.toUpperCase();
            },
            capitalize(text){
                return text.substring(0, 1).toUpperCase() + text.substring(1, text.length).toLowerCase();
            }
        },
        computed: {
            filtredCars(){
                const response = this.cars.filter(car => {
                    let show = true;
                    if(this.plate.length > 0){
                        show = car.plate.toLowerCase().indexOf(this.plate.toLowerCase()) >= 0;
                    }
                    if(this.name.length > 0 && show){
                        show = car.owner.name.toLowerCase().indexOf(this.name.toLowerCase()) >= 0;
                    }
                    if(this.brand != "" && show){
                        show = car.brand.id == this.brand;
                    }
                    if(this.document.length > 0 && show){
                        show = car.owner.document.toString().toLowerCase().indexOf(this.document.toLowerCase()) >= 0;
                    }
                    return show;
                })
                this.$emit("total", response.length);
                return response;
                
            }
        },
        components: {
            brandSelect 
        },
        mounted(){
            this.getCars();
        }
    }
</script>