<h1 class="nombre-pagina">Recuperar password</h1>
<p class="descripcion-pagina">
    Coloca tu nuevo Password a continuacion
</p>
<?php
include_once __DIR__."/../templates/alertas.php";
?>

<?php if ($error) return;?>
<form class="formulacion" method="post">
    <div class="campo"> 
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu password">
    </div>
    <input type="submit" value="Guardar Nuevo Password" class="boton">

</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear Una</a>
</div>

