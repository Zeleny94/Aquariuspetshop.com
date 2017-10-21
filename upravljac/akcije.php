<?php
  require_once("session.php");
  require_once("class.user.php");
  $user_id = $_SESSION['user_session'];
?>
    <div class="container-fluid" style="margin-top:80px;">
      <div class="container">
        <div class="row"><div class="col-lg-4">
            <hr>
            <h2>Izmenite akciju</h2>
            <hr>
            <?php
            $izmena_akcije = $conn->query("SELECT * FROM akcije");
            $izmena_akcije->execute();
            echo '<form method="POST">';
            echo '<select class="form-control" name="izmena_akcije" onchange="this.form.submit()">';
            echo '<option>Izaberite akciju</option>';
            while($izmena_akcije_o=$izmena_akcije->fetch()){
              echo '<option';
              if($_POST['izmena_akcije']==$izmena_akcije_o['id_akcije']){
                echo ' selected';
              }
              echo ' value="'.$izmena_akcije_o['id_akcije'].'">';
              echo $izmena_akcije_o['naslov_akcije'];
              echo '</option>';
            }
            echo '</select>';
            echo '</form>';
            if(isset($_POST['izmena_akcije'])){
              $izmena_akcije_forma = $conn->prepare("SELECT * FROM akcije WHERE id_akcije = :idakcije");
              $izmena_akcije_forma->bindParam(':idakcije', $_POST['izmena_akcije'], PDO::PARAM_INT); 
              $izmena_akcije_forma->execute();
              echo '<hr>';
              echo '<form method="POST">';
              while($izmena_akcije_forma_o=$izmena_akcije_forma->fetch()){
                echo'        
                  <input type="hidden" name="slika_za_brisanje" value="'.$izmena_akcije_forma_o['slika'].'">       
                  <input type="hidden" name="id_izmena" value="'.$izmena_akcije_forma_o['id_akcije'].'">
                  <label for="naslov_izmena">Naziv Akcije</label>
                  <input type="text" id="naslov_izmena" name="naslov_izmena" class="form-control" value="'.$izmena_akcije_forma_o['naslov_akcije'].'">
                  <label for="cena_izmena">Cena</label>
                  <input id="cena_izmena" type="text" name="cena_izmena" class="form-control" value="'.$izmena_akcije_forma_o['cena_akcije'].'"><br>
                  <label for="opis_izmena"></label>';
                  echo '<label class="checkbox-inline"><input type="checkbox" name="status_izmena" value="'.$izmena_akcije_forma_o['status'].'" ';
                  if($izmena_akcije_forma_o['status']=='1'){
                    echo 'checked';
                  }
                  echo '>Status akcije</label><br>';
                echo '  <textarea id="opis_izmena" name="opis_izmena">'.$izmena_akcije_forma_o['opis'].'</textarea><br>';
                  
                echo '<button type="submit" name="izmena_akcije_potvrda" class="btn btn-info" onclick="return ';
                echo "confirm('Da li ste sigurni da želite da izmenite (".$izmena_akcije_forma_o['naslov_akcije'].")')";
                echo '">Sačuvaj promene</button>';
                echo '<button type="submit" name="obrisi_akciju" class="btn btn-danger pull-right" onclick="return ';
                echo "confirm('Da li ste sigurni da želite da obrišete (".$izmena_akcije_forma_o['naslov_akcije'].")')";
                echo '">Obriši</button>';
                }
                echo '</form>';
            }

          if(isset($_POST['izmena_akcije_potvrda'])){
            $status = (isset($_POST['status_izmena'])) ? 1 : 0;
            $izmena_unos = $conn->prepare("UPDATE akcije SET naslov_akcije= :naslov_akcije , cena_akcije = :cena_akcije , opis= :opis, status = :status WHERE id_akcije= :id_akcije");
            $izmena_unos->bindParam(':naslov_akcije', $_POST['naslov_izmena'], PDO::PARAM_STR);
            $izmena_unos->bindParam(':cena_akcije', $_POST['cena_izmena'], PDO::PARAM_STR);
            $izmena_unos->bindParam(':opis', $_POST['opis_izmena'], PDO::PARAM_STR);
            $izmena_unos->bindParam(':status', $status, PDO::PARAM_INT);
            $izmena_unos->bindParam(':id_akcije', $_POST['id_izmena'], PDO::PARAM_INT);
            $izmena_unos->execute();
            echo '<script type="text/javascript">window.location = "'.$url.'upravljac/akcije"</script>';
            }
            if(isset($_POST['obrisi_akciju'])){
              $obrisi_akciju_delete = $conn->prepare("DELETE FROM akcije where id_akcije = :id_izmena");
              $obrisi_akciju_delete->bindParam(':id_izmena', $_POST['id_izmena'], PDO::PARAM_INT); 
              $obrisi_akciju_delete->execute();
              unlink("../".$_POST['slika_za_brisanje']);
            echo '<script type="text/javascript">window.location = "'.$url.'upravljac/akcije"</script>';
            }
                 ?>
          </div>
          <div class="col-lg-4">
            <hr>
            <h2>Izmenite sliku akcije</h2>
            <hr>
            <?php
            $izmena_slike_upit = $conn->query("SELECT * FROM akcije");
            $izmena_slike_upit->execute();
            echo '<form method="POST">';
            echo '<select class="form-control" name="izmena_slike_upit" onchange="this.form.submit()">';
            echo '<option>Izaberite akciju</option>';
            while($izmena_slike_upit_o=$izmena_slike_upit->fetch()){
               echo '<option';
              if($_POST['izmena_slike_upit']==$izmena_slike_upit_o['id_akcije']){
                echo ' selected';
              }
              echo ' value="'.$izmena_slike_upit_o['id_akcije'].'">';
              echo $izmena_slike_upit_o['naslov_akcije'];
              echo '</option>';
            }
            echo '</select>';
            echo '</form>';
            if(isset($_POST['izmena_slike_upit'])){

              echo '<hr><form method="POST" enctype="multipart/form-data">';
              $slika_izmena = $conn->prepare("SELECT * FROM akcije WHERE id_akcije= :idakcije");
              $slika_izmena->bindParam(':idakcije', $_POST['izmena_slike_upit'], PDO::PARAM_INT);
              $slika_izmena->execute();
              while($slika_izmena_o=$slika_izmena->fetch()){
                echo '<img class="form-control" style="height:auto;" src="'.$url.$slika_izmena_o['slika'].'"><br>';
                echo '<input type="hidden" name="slika_ime" value="'.$slika_izmena_o['naslov_akcije'].'">';
                echo '<input type="hidden" name="slika_id" value="'.$slika_izmena_o['id_akcije'].'">';
                echo '<label for="izmena_slike_slanje">Izaberite drugu željenu sliku:</label><br>
                      <div class="input-group">
                          <label class="input-group-btn">
                              <span class="btn btn-primary">
                                  Browse&hellip; <input type="file" name="izmena_slike_slanje" style="display: none;">
                              </span>
                          </label>
                          <input type="text" class="form-control" readonly>
                      </div><br>
                  <input type="hidden" name="MAX_FILE_SIZE" value="20480"><br>
                  <button type="submit" name="izmena_slike" class="btn btn-info">Dodajte drugu sliku</button>';
              }
              echo '</form>';
            }
            if(isset($_POST['izmena_slike'])){
                  if ($_FILES ['izmena_slike_slanje']['error'] > 0){
                   switch ($_FILES ['izmena_slike_slanje']['error']){
                      case 1: echo greska('Problem','Slika je prevelika pokusajte ponovo'); break;
                      case 2: echo greska('Problem','Slika je prevelika pokusajte ponovo'); break;
                      case 3: echo greska('Problem','Slika nije potpuno ucitana, pokusajte ponovo'); break;
                      case 4: echo greska('Problem','Slika nije ucitana, pokusajte ponovo'); break;
                      case 6: echo greska('Problem','Serverska greska, pokusajte ponovo'); break;
                      case 7: echo greska('Problem','Slika nije ucitana, pokusajte ponovo'); break;
                      case 8: echo greska('Problem','Slika nije ucitana, pokusajte ponovo'); break;
                    }
                    exit;
                }
                if ($_FILES ['izmena_slike_slanje']['size'] > 1048576*$max_vrednost) { echo greska('Problem','Slika je prevelika pokusajte ponovo'); exit;}
                if ($_FILES ['izmena_slike_slanje']['type']=='image/jpeg'){ $a="ok"; $b=".jpg";}
                if ($_FILES ['izmena_slike_slanje']['type']=='image/png'){ $a="ok"; $b=".png";}
                if ($a!="ok"){ echo greska('Problem','Problem: slika nije u okviru ponudjenih formata jpg i png, pokusajte ponovo'); exit;}
                $upfile = '../images/slike_proizvoda/akcije/'.str_replace(',','',$_POST['slika_ime']).$b;
                $up_file = 'images/slike_proizvoda/akcije/'.str_replace(',','',$_POST['slika_ime']).$b;
                if ( is_uploaded_file ($_FILES ['izmena_slike_slanje']['tmp_name'])){
                   if ( !move_uploaded_file ($_FILES ['izmena_slike_slanje']['tmp_name'], $upfile)){
                      echo greska('Problem','Nije premestena slika u sajt');
                      exit;
                   }
                }else{
                   echo greska('Problem','Nismo ucitali sliku pod nazivom:'.$_FILES ['izmena_slike_slanje']['name']);
                   exit;
                }
                $slika_izmena_ruta = $conn->prepare("UPDATE akcije SET slika= :slika WHERE id_akcije= :id_akcije");
                $slika_izmena_ruta->bindParam(':slika', $up_file, PDO::PARAM_STR);
                $slika_izmena_ruta->bindParam(':id_akcije', $_POST['slika_id'], PDO::PARAM_INT);
                $slika_izmena_ruta->execute();
            }
            ?>

          </div>
          <div class="col-lg-4">
          <hr>
            <h2>Unesite novu akciju</h2>
            <hr>
            <form method="POST" enctype="multipart/form-data">
              <label for="naslov">Naziv Akcije</label>
              <input type="text" name="naslov" class="form-control">
              <label for="cena">Cena</label>
              <input type="text" name="cena" class="form-control"><br>
              <label for="opis"></label>
              <label class="checkbox-inline"><input type="checkbox" name="status">Status akcije</label><br>
              <textarea name="opis"></textarea><br>
              <label for="slika_akcije_nova">Izaberite željenu sliku:</label><br>
                      <div class="input-group">
                          <label class="input-group-btn">
                              <span class="btn btn-primary">
                                  Browse&hellip; <input type="file" name="slika_akcije_nova" style="display: none;">
                              </span>
                          </label>
                          <input type="text" class="form-control" readonly>
                      </div><br>
              <input type="hidden" name="MAX_FILE_SIZE" value="20480">
              <button type="submit" name="add_akciju" class="btn btn-info">Unesi novu akciju</button>
            </form>
          <?php
            if(isset($_POST['add_akciju'])){
               if ($_FILES ['slika_akcije_nova']['error'] > 0){
                   switch ($_FILES ['slika_akcije_nova']['error']){
                      case 1: echo greska('Problem','Slika je prevelika pokusajte ponovo'); break;
                      case 2: echo greska('Problem','Slika je prevelika pokusajte ponovo'); break;
                      case 3: echo greska('Problem','Slika nije potpuno ucitana, pokusajte ponovo'); break;
                      case 4: echo greska('Problem','Slika nije ucitana, pokusajte ponovo'); break;
                      case 6: echo greska('Problem','Serverska greska, pokusajte ponovo'); break;
                      case 7: echo greska('Problem','Slika nije ucitana, pokusajte ponovo'); break;
                      case 8: echo greska('Problem','Slika nije ucitana, pokusajte ponovo'); break;
                    }
                    exit;
                }
                if ($_FILES ['slika_akcije_nova']['size'] > 1048576*$max_vrednost) { echo greska('Problem','Slika je prevelika pokusajte ponovo'); exit;}
                if ($_FILES ['slika_akcije_nova']['type']=='image/jpeg'){ $a="ok"; $b=".jpg";}
                if ($_FILES ['slika_akcije_nova']['type']=='image/png'){ $a="ok"; $b=".png";}
                if ($a!="ok"){ echo greska('Problem','Problem: slika nije u okviru ponudjenih formata jpg i png, pokusajte ponovo'); exit;}
                $upfile = '../images/slike_proizvoda/akcije/'.str_replace(',','',$_POST['naslov']).$b;
                $up_file = 'images/slike_proizvoda/akcije/'.str_replace(',','',$_POST['naslov']).$b;
                if ( is_uploaded_file ($_FILES ['slika_akcije_nova']['tmp_name'])){
                   if ( !move_uploaded_file ($_FILES ['slika_akcije_nova']['tmp_name'], $upfile)){
                      echo greska('Problem','Nije premestena slika u sajt');
                      exit;
                   }
                }else{
                   echo greska('Problem','Nismo ucitali sliku pod nazivom:'.$_FILES ['slika_akcije_nova']['name']);
                   exit;
                }

              $status = (isset($_POST['status'])) ? 1 : 0;
                $nova_akcija = $conn->prepare("INSERT INTO akcije (id_akcije ,naslov_akcije ,cena_akcije ,status ,slika ,opis)VALUES (NULL , :naslov, :cena, :status, :slika, :opis)");
                $nova_akcija->bindParam(':naslov',$_POST['naslov'],PDO::PARAM_STR);
                $nova_akcija->bindParam(':cena',$_POST['cena'],PDO::PARAM_STR);
                $nova_akcija->bindParam(':status',$status,PDO::PARAM_STR);
                $nova_akcija->bindParam(':slika',$up_file,PDO::PARAM_STR);
                $nova_akcija->bindParam(':opis',$_POST['opis'],PDO::PARAM_STR);
                $nova_akcija->execute();
            }

?>
          </div>
        </div>
      </div>
    </div>