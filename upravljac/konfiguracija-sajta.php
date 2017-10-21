<?php
  require_once("session.php");
  require_once("class.user.php");
  $user_id = $_SESSION['user_session'];
?>
    <div class="container-fluid" style="margin-top:80px;">
    <div class="container">
    <div class="col-lg-6">
    <hr>
    <h2>Osnovne konfiguracije</h2>
    <hr>
    <?php
    $opsta_konfiguracija = $conn->query("SELECT * FROM konfiguracija");
    $opsta_konfiguracija->execute();
    $brojacx = 1;
    echo '<form method="POST">
    <div class="form-group">';
    while($opsta_konfiguracija_output = $opsta_konfiguracija->fetch()){
      if($opsta_konfiguracija_output['ime_konf']!="background_image"){
        echo '<label for="'.$opsta_konfiguracija_output['ime_konf'].'">'.$opsta_konfiguracija_output['naslov_konf'].':</label><br>';
        if($opsta_konfiguracija_output['ime_konf']=="http_https"){
          echo '<select class="form-control" name="'.$brojacx.'">';
          if($opsta_konfiguracija_output['vrednost_konf']=="http://"){
          echo '
                  <option value="http://">http</option>
                  <option value="https://">https</option>
              </select>';
            }else{
             echo '  
                  <option value="https://">https</option>
                  <option value="http://">http</option>
              </select>';
            }
        }elseif ($opsta_konfiguracija_output['ime_konf']=="desni_sidebar_kategorija") {
          $opsta_konf_desid = $conn->query("SELECT * FROM kategorija");
          $opsta_konf_desid->execute();
          echo '<select class="form-control" name="'.$brojacx.'">';
          while($opsta_konf_desid_oputput=$opsta_konf_desid->fetch()){
            if($opsta_konf_desid_oputput['id_kat']==$opsta_konfiguracija_output['vrednost_konf']){
              echo '<option selected value="'.$opsta_konf_desid_oputput['id_kat'].'">'.$opsta_konf_desid_oputput['ime_kat'].'</option>';
            }else{
                echo '<option value="'.$opsta_konf_desid_oputput['id_kat'].'">'.$opsta_konf_desid_oputput['ime_kat'].'</option>';
            }
          }
          echo '</select>';
        }elseif($opsta_konfiguracija_output['ime_konf']=="valuta"){
          echo '<select class="form-control" name="'.$brojacx.'">';
          echo '<option value="RSD"'; 
          if($opsta_konfiguracija_output['vrednost_konf']=='RSD'){
            echo ' selected';
          } echo '>Dinari</optnion>';
          echo '<option value="EUR"'; if($opsta_konfiguracija_output['vrednost_konf']=='EUR'){
            echo ' selected';
          } echo '>Euri</optnio>';
          echo '</select>';
         
        }else{
        echo '<input class="form-control" type="text" id="'.$opsta_konfiguracija_output['ime_konf'].'" name="'.$brojacx.'" value="'.$opsta_konfiguracija_output['vrednost_konf'].'"> ';
        } echo '<br>';
      }
      ++$brojacx;
    }
        echo '<button type="submit" name="promene_konf" class="btn btn-info" onclick="return ';
           echo "confirm('Da li ste sigurni da želite da napravite promene?')";
           echo '">Sačuvaj promene</button></div></form>';
    ?>
    </div>
    </div>
</div>
 <?php
        if(isset($_POST['promene_konf'])){
          for($i=1; $i<$brojacx; $i++){
            if($i!=2){
              $promena_opsta = $conn->prepare("UPDATE konfiguracija SET vrednost_konf= :vrednost WHERE id_kondiguracija= :id");
              $promena_opsta->bindParam(':id', $i, PDO::PARAM_INT); 
              $promena_opsta->bindParam(':vrednost', $_POST[$i], PDO::PARAM_INT);
              $promena_opsta->execute();
              echo '<script type="text/javascript">window.location = "'.$url.'upravljac/konfiguracija"</script>';
            }
          }
        }
        ?>