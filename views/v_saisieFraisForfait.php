<h2>Gestion des frais</h2>

<form method="POST" action="index.php?uc=saisieFrais&action=ajoutFraisForfait">
<div id="contenu">   
        <h1>Frais au forfait</h1>

        <?php $mois =  $_POST['mois']; $annee =  $_POST['annee']; $date = $annee.$mois; ?>
        
        <input hidden name="mois" value="<?php echo $date;?>">
        <input hidden name="numero" value="<?php echo $_POST['numero'];?>">

        <p>
            <label for="ETP">Forfait Etape :</label>
            <input id="ETP" type="tel" name="ETP" size="8" required>
        </p>

        <p>
            <label for="KM">Frais Kilométrique :</label>
            <input id="KM" type="tel" name="KM" size="8" required>
        </p>

        <p>
            <label for="NUI">Nuitée Hôtel :</label>
            <input id="NUI" type="tel" name="NUI" size="8" required>
        </p>

        <p>
            <label for="REP">Équipe :</label>
            <input id="REP" type="tel" name="REP" size="8" required>
        </p>

    </div>

    <br>
    
    <div class="piedForm">
        <input type="submit" value="Valider" name="valider">
        <input type="reset" value="Annuler" name="annuler">
    </div>

</form>