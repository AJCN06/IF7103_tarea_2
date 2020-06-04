<!-- Otro formulario para adivinar el sexo de un estudiante, donde el usuario 
podrá seleccionar su estilo de aprendizaje de los cuatro usados (divergente, 
convergente, asimilador, acomodador), su último promedio para matrícula y su 
recinto (Paraíso o Turrialba).  -->

<?php require_once 'public/header.php' ?>
<div class="container">
    <h1>Sexo del estudiante</h1>

    <form action="?controlador=Sexo&accion=disc" method="post">
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="Estiloi">Estilo de aprendizaje</label>
            <select id="Estiloi" class="form-control" name="estiloi">
                <option value="ASIMILADOR">Asimilador</option>
                <option value="ACOMODADOR">Acomodador</option>
                <option value="DIVERGENTE">Divergente</option>
                <option value="CONVERGENTE">Convergente</option>
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="promedioi">Ultimo promedio de matricula</label>
            <input type="text" class="form-control" id="promedioi" name="promedioi" placeholder="Digite solo numeros">
        </div>
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="Recintoi">Recinto</label>
            <select id="Recintoi" class="form-control" name="recintoi">
                <option value="Turrialba">Turrialba</option>
                <option value="Paraiso">Paraiso</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

</div>

<?php require_once 'public/footer.php' ?>