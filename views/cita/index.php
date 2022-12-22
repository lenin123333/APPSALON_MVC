<h1 class="nombre-pagina">Crear una nueva cita</h1>
<p class="descripcion-pagina"> Elige tus servicios y coloca tus datos</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
?>

<div id="app">

    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicos</button>
        <button type="button" data-paso="2">Informacion Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicos acontinuacion</p>
        <div class="listado-servicios" id="servicios"></div>
    </div>
    <div class="seccion" id="paso-2">
        <h2>Tus datos y Citas</h2>
        <p class="text-center">Coloca tus daots y fecha de cita</p>
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo $nombre; ?>"
                    disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha"
                min="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" name="hora" id="hora">
            </div>
            <input type="hidden" name="" id="id" value="<?php echo $id; ?>">
        </form>
    </div>
    <div class="seccion contenido-resumen" id="paso-3">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton"> Siguiente &raquo;</button>
    </div>
   

    <?php
    echo $script ="
     <script src='build/js/app.js'> </script>
     <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'> </script>
     ";?>

</div>