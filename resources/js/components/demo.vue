<template>
    <div class="row">
        <div class="col-12 my-3">
            <label>Ingrese el arreglo</label>
            <textarea v-model="array" class="form-control" rows="8"></textarea>
        </div>
        <div class="col-12 my-3">
            <label>Resultado</label>
            <textarea :value="newObject" readonly  class="form-control" rows="8"></textarea>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return {
                array: ""
            }
        },
        computed: {
            newObject(){
                let response =  {};
                let json = null;
                if(this.array.length > 1){
                    try{
                        json = JSON.parse(this.array);
                    }catch(error){
                        console.log(error);  
                        return "Error";
                    }

                    if(typeof json != "object"){
                        return "El valor ingresado debe ser un array";
                    }
                    
                    if(!Array.isArray(json)){
                        return "El valor ingresado debe ser un array";
                    }
                    
                    for(let index in json){
                        const item = json[index];
                        if(typeof item != "object"){
                            return "El valor ingresado debe ser un array y un debe contener un array";
                        }

                        if(!Array.isArray(item)){
                            return "El valor ingresado debe ser un array y un debe contener un array";
                        }
                        
                        if(item.length < 4 || item.length > 4){
                            return "El valor ingresado debe ser un array y un debe contener un array con 4 elementos";
                        }
                        
                        let date = new Date(item[0]);
                        
                        if(date == "Invalid Date"){
                            return "El primer campo del array debe ser una fecha valida";
                        }
                        
                        if(item[1] != "AM" && item[1] != "PM"){
                            return "El segundo campo del array debe ser AM o PM";
                        }
                        
                        const number = parseInt(item[3]);
                        
                        if(!Number.isInteger(number)){
                            return "El cuarto campo del array debe ser un numero";
                        }
                        
                        if(typeof response[item[0]] == "undefined"){
                            response[item[0]] = {};
                        }
                        
                        if(typeof response[item[0]][item[1]] == "undefined"){
                            response[item[0]][item[1]] = 0;
                        }
                        
                        response[item[0]][item[1]] += number;
                        
                        
                    }
                    
                    
                    
                    console.log(json);
                }
                
                
                return JSON.stringify(response);
            }
        }
    }
</script>