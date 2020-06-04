<!-- Otro formulario para determinar el tipo de profesor (beginner, intermediate, 
advanced), a partir de los siguientes criterios que el usuario podrá definir 
gracias a la interfaz. -->
<?php require_once 'public/header.php' ?>
<div class="container">

    <h1>Tipo de profesor</h1>
    <form action="?controlador=Profesor&accion=disc" method="post">
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="edadi">Edad</label>
            <select id="edadi" name="ai" class="form-control">
                <option value="1">Menor o igual a 30</option>
                <option value="2">Mayor a 30 y Menor o igual a 55</option>
                <option value="3">Mayor a 55</option>
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="Sexoi">Genero</label>
            <select id="Sexoi" name="bi" class="form-control">
                <option value="F">Femenino</option>
                <option value="M">Masculino</option>
                <option value="NA">No disponible</option>
            </select>
        </div>
        <h3>Background</h3>
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="ci">Teacher’s self-evaluation of his skill or experience teaching the selected subject.</label>
            <select id="ci" name="ci" class="form-control">
                <option value="B">Beginner</option>
                <option value="I">Intermediate</option>
                <option value="A">Advanced</option>
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="di">Number of times the teacher has taught this type of course. </label>
            <select id="di" name="di" class="form-control">
                <option value="1">Never </option>
                <option value="2">1 to 5 times </option>
                <option value="3">More than 5 times </option>
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="ei">Teacher’s background discipline or area of expertise. </label>
            <select id="ei" name="ei" class="form-control">
                <option value="DM">Decision-making </option>
                <option value="ND">Network design </option>
                <option value="O">Other </option>
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="fi">Teacher’s skills using computers. </label>
            <select id="fi" name="fi" class="form-control">
                <option value="L">Low</option>
                <option value="A">Average</option>
                <option value="H">High</option>
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="gi">Teacher’s experience using Web-based technology for teaching.</label>
            <select id="gi" name="gi" class="form-control">
                <option value="N">Never </option>
                <option value="S">Sometimes </option>
                <option value="O">Often </option>
            </select>
        </div>
        <div class="form-group col-lg-6 col-md-8 col-sm-12">
            <label for="hi">Teacher’s experience using a Web site</label>
            <select id="hi" name="hi" class="form-control">
                <option value="N">Never </option>
                <option value="S">Sometimes </option>
                <option value="O">Often </option>
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
</div>
<?php require_once 'public/footer.php' ?>