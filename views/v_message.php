<?php

echo <<<HTML
    <!DOCTYPE HTML>
    <html>
    <div id="contenu">
        <h1>Frais enregistré</h1> 
        
        <p>Vous trouverez ci-dessous le détail des quantité</p>

        <table border="1">
        <tr>
            <th>Quantité étape</th>
            <th>Quantité kilométrique</th>
            <th>Quantité hôtel</th>
            <th>Quantité équipe</th>
        </tr>
        <tr>
            <td>{$_POST["ETP"]}</td>
            <td>{$_POST["KM"]}</td>
            <td>{$_POST["NUI"]}</td>
            <td>{$_POST["REP"]}</td>
        </tr>
        </table>
    </div>
    </html>

HTML;


