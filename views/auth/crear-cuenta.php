<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">LLena el siguente formulario
    para crear una cuenta
</p>

<?php
include_once __DIR__."/../templates/alertas.php";
?>

<form action="/crear-cuenta"  method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" placeholder="Tu nombre">
       
    </div>
    <div class="campo"> <label for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido" placeholder="Tu apellido"
        value="<?php echo s($usuario->apellido); ?>">
        
    </div>
    <div class="campo"><label for="telefono">Telefono</label>
        <input type="tel" name="telefono" id="telefono" placeholder="Tu telefono"
        value="<?php echo s($usuario->telefono); ?>">
        
    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Tu email"
        value="<?php echo s($usuario->email); ?>">
        
    </div>
    <div class="campo"> <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu password">
    </div>

    <input type="submit" value="Crear Cuenta" class="boton">


</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/olvide">¿Olvidates tu Password?</a>
</div>