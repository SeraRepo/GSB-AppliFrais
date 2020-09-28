<?php

/**
 * Controleur Valider Frais
 *
 * PHP Version 7
 *
* @category  PPE
 * @package   GSB
 * @author    Gustave JULIEN
 */

$uc = filter_input(INPUT_GET, 'uc', FILTER_SANITIZE_STRING);//Verifie le contenu de uc
if ($uc=='analyserFrais'){   
?>
    <h2>Valider les fiches de frais</h2>
    <div class="row">
        <div class="col-md-4"><?php //col-md-4 prend 1/4 de la page ?>

            <form action="index.php?uc=validerFrais&action=afficheFrais" 
                  method="post" role="form">
<?php
}else{
?> 
    <h2>Suivre le paiement des fiches de frais</h2>
    <div class="row">
        <div class="col-md-4"><?php //col-md-4 prend 1/4 de la page ?>
      
            <form action="index.php?uc=annalyserFrais&action=afficheFraisNonVal" 
                method="post" role="form">
<?php
}
?>           
             <?php //liste deroulante du mois ?>
              <div class="form-group">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                
                    foreach ($lesMois as $unMois) {

                        $moisDeux = $unMois['mois'];                       
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        
                        if ($moisDeux == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $moisDeux ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $moisDeux ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?> 
                    

                </select>
            </div>
            
             <?php //liste deroulante du mois ?>
              <div class="form-group">
                <label for="lstMois" accesskey="n">Mois : </label>
                <select id="lstMois" name="lstMois" class="form-control">
                    <?php
                
                    foreach ($lesMois as $unMois) {

                        $moisUn = $unMois['mois'];                       
                        $numAnnee = $unMois['numAnnee'];
                        $numMois = $unMois['numMois'];
                        
                        if ($moisUn == $moisASelectionner) {
                            ?>
                            <option selected value="<?php echo $moisUn ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        } else {
                            ?>
                            <option value="<?php echo $moisUn ?>">
                                <?php echo $numMois . '/' . $numAnnee ?> </option>
                            <?php
                        }
                    }
                    ?> 
                    

                </select>
            </div>
           <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
            <input id="annuler" type="reset" value="Effacer" class="btn btn-danger" 
                   role="button">
        </form>

    </div>
</div>

           


