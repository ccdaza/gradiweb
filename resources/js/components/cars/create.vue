<template>
    <div>
        <button type="button" class="btn btn-dark" @click="show">
            Crear carro
        </button>

        <!-- Modal -->
        <div class="modal fade" id="createCarModal" tabindex="-1" >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear un automovil</h5>
                <button type="button" class="close"  @click="hide">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="row" v-if="message.show">
                        <div class="col">
                            <p class="p-3" :class="'alert-' + message.type" v-html="message.value" />
                        </div>
                    </div>
                   <template v-if="!finalized">
                       <div class="row">
                            <div class="col">
                                <label for="plate">Placa</label>
                                <input type="text" v-model="plate" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="plate">Marca</label>
                                <select-brand v-model="brand"></select-brand>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="plate">Tipo</label>
                                <select-type v-model="type"></select-type>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="plate">Propietario</label>
                                <select-owner v-model="owner"></select-owner>
                            </div>
                        </div>
                   </template>
                    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="hide">Cerrar</button>
                <button type="button" class="btn btn-primary" :class="{disable : creating}" @click="create" v-if="!finalized">Crear</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>
<script>
    import jQuery from 'jquery';
    import axios from 'axios';
    import selectBrand from '../brands/selectWithOther'
    import selectOwner from '../owners/select'
    import selectType from '../types/select'
    export default {
        data(){
            return {
                plate: "",
                brand: "",
                type: "",
                owner: "",
                creating: false,
                message: {
                    type: "success",
                    value: "",
                    show: false
                },
                finalized: false
            }
        },
        methods: {
            show(){
                jQuery("#createCarModal").modal("show");
            },
            hide(){
                jQuery("#createCarModal").modal("hide");
            },
            async create(){
                this.creating = true;
                await axios.post("/cars", {
                    plate: this.plate,
                    brand: this.brand,
                    type: this.type,
                    owner: this.owner
                })
                .then(response => {
                    this.finalized = true;
                    this.$set(this.message, "type", "success");
                    this.$set(this.message, "show", true);
                    this.$set(this.message, "value", response.data.success.message.join("<br>"));
                })
                .catch(error => {
                    this.$set(this.message, "type", "danger");
                    this.$set(this.message, "show", true);
                    let messages = [];
                    let errors = error.response.data.errors;
                    for(let field in errors){
                        messages.push(errors[field].join("<br>"));
                    }
                    
                    this.$set(this.message, "value", messages.join("<br>"));
                })
            }
        },
        components: {
            selectBrand,
            selectType,
            selectOwner,
        }
    }
</script>