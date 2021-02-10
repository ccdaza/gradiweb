<template>
    <section>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
              <a class="navbar-brand" href="#">Prueba Gradiweb</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item" :class="{active:showList}">
                    <a class="nav-link" href="#" @click="goList">Listado</a>
                  </li>
                  <li class="nav-item" :class="{active:showDemo}">
                    <a class="nav-link" href="#" @click="goDemo">Demo</a>
                  </li>
                </ul>
              </div>
        </nav>
        
        <main role="main" class="container">
          <div class="jumbotron" v-if="showList">
            <h1>Listado de Automoviles </h1>
            <div class="row my-3">
                <div class="col">
                    <create></create>
                </div>
                <div class="col">
                    <p style="float:right; font-size:15px">Total de automoviles <strong style="color: #4caf50;">({{ total }})</strong></p>
                </div>
            </div>
            
            
            <list @total="total = $event"></list>
          </div>
           <div class="jumbotron" v-if="showDemo">
            <h1>Demo </h1>
            <div class="row my-3">
                <div class="col">
                    <demo></demo>
                </div>
            </div>
          </div>
        </main>
    </section>
</template>
<script>
    import list from "./cars/list"
    import create from './cars/create';
    import demo from './demo';
    export default {
        data(){
            return {
                total: 0,
                showList: true,
                showDemo: false
            }
        },
        methods: {
            goList(){
                this.showList = true;
                this.showDemo = false;
            },
            goDemo(){
                console.log("demo")
                this.showList = false;
                this.showDemo = true;
            }
        },        
        components: {
            list,
            create,
            demo
        }
    }
</script>