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
?>

<form action="index.php?uc=validerFrais&action=corrigerFrais" role="form" method="post">
   <div class="col-md-4">
        <?php//Liste déroulante des visiteurs?>
        <div class="form-group" style="display: inline-block">
            <label for="lstVisiteurs" accesskey="n">Choisir le visiteur : </label>
            <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                <?php
                foreach ($lesVisiteurs as $unVisiteur) {
                    $id = $unVisiteur['id'];
                    $nom = $unVisiteur['nom'];
                    $prenom = $unVisiteur['prenom'];
                    if ($id == $visiteurASelectionner) {
                        ?>
                        <option selected value="<?php echo $id ?>">
                            <?php echo $nom . ' ' . $prenom ?> </option>
                        <?php
                    } else {
                        ?>
                        <option value="<?php echo $id ?>">
                            <?php echo $nom . ' ' . $prenom ?> </option>
                        <?php
                    }
                }
                ?>    

            </select>
        </div>
           
        <?php//liste déroulante des mois?>          
        &nbsp;<div class="form-group" style="display: inline-block">
            <label for="lstMois" accesskey="n">Mois : </label>
            <select id="lstMois" name="lstMois" class="form-control">
                <?php
                foreach ($lesMois as $unMois) {
                    $mois = $unMois['mois'];
                    $numAnnee = $unMois['numAnnee'];
                    $numMois = $unMois['numMois'];
                    if ($mois == $moisASelectionner) {
                        ?>
                        <option selected value="<?php echo $mois ?>">
                            <?php echo $numMois . '/' . $numAnnee ?> </option>
                        <?php
                    } else {
                        ?>
                        <option value="<?php echo $mois ?>">
                            <?php echo $numMois . '/' . $numAnnee ?> </option>
                        <?php
                    }
                }
                ?>    

            </select>
        </div>
    </div> <br><br><br><br>
   <?php//elements forfaitisés?>
   
 <div class="valide">
   <div class="row"> 
     <h2 style="color:orange">&nbsp;Valider la fiche de frais</h2>
     <h3>&nbsp;&nbsp;Eléments forfaitisés</h3>
     <div class="col-md-4">   
               <?php
               foreach ($lesFraisForfait as $unFrais) {
                   $idFrais = $unFrais['idfrais'];
                   $libelle = htmlspecialchars($unFrais['libelle']);
                   $quantite = $unFrais['quantite']; ?>
                   <div class="form-group">
                       <label for="idFrais"><?php echo $libelle ?></label>
                       <input type="text" id="idFrais"
                               name="lesFrais[<?php echo $idFrais ?>]"
                              size="10" maxlength="5"
                              value="<?php echo $quantite ?>"
                              class="form-control">
                   </div>
                   <?php
               }
               ?>
               <button class="btn btn-success" type="edit" >Corriger</button>
               <button class="btn btn-danger" type="reset">Reinitialiser</button>
     </div>
     </div>
  </div>
</form>

<?php//elements non forfaitises?>
<form action="index.php?uc=validerFrais&action=corrigerFraisHF" role="form" method="post">
    <input type="hidden" name="leMois" id="leMois" size="10" value="<?php echo $moisASelectionner ?>" class="form-control"/>
    <input type="hidden" name="leVisiteur" id="leVisiteur" size="10" value="<?php echo $visiteurASelectionner ?>" class="form-control"/>
     <h3>Eléments non forfaitisés</h3>
    <div class="panel panel-info1" >
        <div class="panel-heading" style="color:white">Descriptif des éléments hors forfait</div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th class="date" style="border-bottom: 1px solid #ff6f02; border-right:1px solid #ff6f02; " >Date</th>
                    <th class="libelle" style="border-bottom: 1px solid #ff6f02;border-right:1px solid #ff6f02;">Libellé</th>  
                    <th class="montant" style="border-bottom: 1px solid #ff6f02; border-right:1px solid #ff6f02;">Montant</th>  
                    <th class="action" style="border-bottom: 1px solid #ff6f02; ">&nbsp;</th>
                </tr>
            </thead> 
            <tbody >
            <?php
            foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                $date = $unFraisHorsForfait['date'];
                $montant = $unFraisHorsForfait['montant'];
                $id = $unFraisHorsForfait['id']; ?>    
            <input type="hidden" name="frais" id="frais" size="10" value="<?php echo $id ?>" class="form-control"/>
                <tr > 
                    <td style="border-right:1px solid #ff6f02;"><input type="text" name="date" id="date" size="10" value="<?php echo $date ?>" class="form-control"/></td>
                    <td style="border-right:1px solid #ff6f02;"><input type="text" name="libelle" id="libelle" size="10" value="<?php echo $libelle ?>" class="form-control"/></td>
                    <td style="border-right:1px solid #ff6f02;"><input type="text" name="montant" id="montant" size="10" value="<?php echo $montant ?>" class="form-control"/></td>
                    
                    <td><button class="btn btn-success" type="edit">Corriger</button>
                        <button class="btn btn-danger" type="reset">Reinitialiser</button>
                        <a href="index.php?uc=validerFrais&action=supprimerFrais&idFrais=<?php echo $id ?>&mois=<?php echo $unFraisHorsForfait['mois']?>&idVisiteur=<?php echo $visiteurASelectionner?>" 
                           type="reset" class="btn btn-danger" role="button"
                           onclick="return confirm('Voulez-vous vraiment supprimer ou reporter ce frais hors forfait?');">Supprimer</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</form>
    
    
     <div><label for="justf">Nombre de justificatifs:</label> <input type="text" name="justf" id="justf" size="1" value="<?php echo $nbJustificatifs?>" /></div><br>
     <form action="index.php?uc=validerFrais&action=validerFrais" role="form" method="post">
     <input type="hidden" name="leMois" id="leMois" size="10" value="<?php echo $moisASelectionner ?>" class="form-control"/>
     <input type="hidden" name="leVisiteur" id="leVisiteur" size="10" value="<?php echo $visiteurASelectionner ?>" class="form-control"/>
     <input id="ok" type="submit" value="Valider" class="btn btn-success" role="button">
     <input id="annuler" type="reset" value="Reinitialiser" class="btn btn-danger" role="button"><br><br>
     </form>

