<template>
    <section>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
              <a class="navbar-brand" href="#">Prueba Gradiweb</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item active">
                    <a class="nav-link" href="#">Listado</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Demo</a>
                  </li>
                </ul>
              </div>
        </nav>
        
        <main role="main" class="container">
          <div class="jumbotron">
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
        </main>
    </section>
</template>
<script>
    import list from "./cars/list"
    import create from './cars/create';
    export default {
        data(){
            return {
                total: 0
            }
        },
        components: {
            list,
            create
        }
    }
</script>