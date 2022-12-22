<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesion con tus datos</p>

<?php
include_once __DIR__."/../templates/alertas.php";
?>

<form action="/" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email" 
        value="<?php echo s($usuario->nombre); ?>";>
</div>

<div class="campo">
    <label for="password">Password</label>
    <input type="password" placeholder="Tu password" id="password" name="password">
</div>

<input type="submit" name="" id="" class="boton" value="Iniciar Sesion">

</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes una cuenta? Crear Una</a>
    <a href="/olvide">¿Olvidates tu Password?</a>
</div>