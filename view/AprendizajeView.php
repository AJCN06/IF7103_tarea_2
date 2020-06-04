<!-- Otro formulario para adivinar el estilo de aprendizaje de un estudiante 
(divergente, convergente, asimilador, acomodador), donde el usuario podrá 
seleccionar su recinto (Paraíso o Turrialba), su último promedio para matrícula
 y su sexo.  -->

<?php require_once 'public/header.php' ?>
<div class="container">
    <h1>Estilo de aprendizaje</h1>

    <form action="?controlador=Aprendizaje&accion=disc" method="post">
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="Recintoi">Recinto</label>
            <select id="Recintoi" name="recintoi" class="form-control">
                <option value="Turrialba">Turrialba</option>
                <option value="Paraiso">Paraiso</option>
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="promedioi">Ultimo promedio de matricula</label>
            <input type="text" class="form-control" id="promedioi" name="promedioi" placeholder="Digite solo numeros">
        </div>
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="Sexoi">Sexo</label>
            <select id="Sexoi" name="sexoi" class="form-control">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

</div><?php require_once 'public/footer.php' ?>