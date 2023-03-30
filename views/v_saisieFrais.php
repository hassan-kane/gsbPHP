<h2>Gestion des frais</h2>

<form method="POST" action="index.php?uc=saisieFrais&action=ajoutFrais">
    <div id="contenu">
        <h1>Saisie</h1>
        <p>
            <label for="numero">Numéro de visite :</label>
            <input id="numero" type="text" value="<?php echo $idVisiteur ?>" name="numero" size="8">
        </p>
       
        <p>
            <label for="mois">Mois(2 Chiffres) :</label>
            <input id="mois" type="text" value="<?php echo date("m");?>" name="mois" size="8" required>
            <span></span>
        </p>

        <p>
            <label for="annee">Années(4 Chiffres) :</label>
            <input id="annee" type="text" value="<?php echo date("Y");?>" name="annee" size="8" required>
            <span></span>
        </p>
    </div> 

    <br>

    <div class="piedForm">
        <input type="submit" value="Valider" name="valider">
        <input type="reset" value="Annuler" name="annuler">
    </div>
</form>


