<?php
  require_once("session.php");
  require_once("class.user.php");
  $user_id = $_SESSION['user_session'];
?>
<div class="container-fluid" style="margin-top:80px;">
  <div class="container">
    <div class="col-lg-4">
      <hr>
      <h4>Izmeni ili obriši kategoriju</h4>
      <hr>
      <form method="POST">
      <?php
        $kategorija_lista_izmena = $conn->query("SELECT * FROM kategorija");
        $kategorija_lista_izmena->execute();
        echo '<select class="form-control" name="kat_lista" onchange="this.form.submit()">';
        echo '<option>Izaberite kategoriju</option>';
        while ($kat_lis_output=$kategorija_lista_izmena->fetch()){

          echo '<option';
          if($_POST['kat_lista']==$kat_lis_output['id_kat']){
            echo ' selected';
          }
          echo ' value="'.$kat_lis_output['id_kat'].'">';
          echo $kat_lis_output['ime_kat'];
          echo '</option>';
        }
        echo '</select>';
      ?>
      </form>
      <?php
      if(isset($_POST['kat_lista'])){
        echo '<hr><form method="POST">';
        $kategorija_izmena = $conn->prepare("SELECT * FROM kategorija WHERE id_kat = :id_kat");
        $kategorija_izmena->bindParam(':id_kat', $_POST['kat_lista'], PDO::PARAM_INT); 
        $kategorija_izmena->execute();
        while ($kategorija_izmena_output=$kategorija_izmena->fetch()){
          echo '<input type="hidden" name="id_kat_izmena" value="'.$kategorija_izmena_output['id_kat'].'">';
          echo '<input type="hidden" name="slika_kat_brisanje" value="'.$kategorija_izmena_output['slika_kat'].'">';
          echo '<label for="naslov">Naslov:</label><br>';
          echo '<input class="form-control" type="text" id="naslov" name="ime_kat" value="'.$kategorija_izmena_output['ime_kat'].'"> <br>';
          echo '<label for="opis">Opis:</label><br>';
          echo '<textarea row="4"  class="form-control" type="text" id="opis" name="opis_kat">'.$kategorija_izmena_output['opis_kat'].'</textarea> <br>';
          echo '<button type="submit" name="izmena_kategorije" class="btn btn-info" onclick="return ';
          echo "confirm('Da li ste sigurni da želite da izmenite (".$kategorija_izmena_output['ime_kat'].")')";
          echo '">Sačuvaj promene</button>';
          echo '<button type="submit" name="obrisi_kategoriju" class="btn btn-danger pull-right" onclick="return ';
          echo "confirm('Da li ste sigurni da želite da obrišete (".$kategorija_izmena_output['ime_kat'].")')";
          echo '">Obriši</button>';
        }
        echo '</form>';
      }
      ?>
    </div>
    <div class="col-lg-4">
    <hr>
    <h4>Izmeni sliku kategorije</h4>
    <hr>
      <form method="POST">
      <?php
        $izmena_slike_kategorije = $conn->query("SELECT * FROM kategorija");
        $izmena_slike_kategorije->execute();
        echo '<select class="form-control" name="kat_slika_izmena" onchange="this.form.submit()">';
        echo '<option>Izaberite kategoriju</option>';
        while ($izmena_slike_kategorije_output=$izmena_slike_kategorije->fetch()){
          echo '<option';
          if($_POST['kat_slika_izmena']==$izmena_slike_kategorije_output['id_kat']){
            echo ' selected';
          }
          echo ' value="'.$izmena_slike_kategorije_output['id_kat'].'">';
          echo $izmena_slike_kategorije_output['ime_kat'];
          echo '</option>';
        }
        echo '</select>';
      ?>
      </form>

      <?php
      if(isset($_POST['kat_slika_izmena'])){
        echo '<hr><form method="POST" enctype="multipart/form-data">';
        $kategorija_izmena_slika = $conn->prepare("SELECT * FROM kategorija WHERE id_kat = :id_kat");
        $kategorija_izmena_slika->bindParam(':id_kat', $_POST['kat_slika_izmena'], PDO::PARAM_INT); 
        $kategorija_izmena_slika->execute();
        while ($kategorija_izmena_slika_output=$kategorija_izmena_slika->fetch()){
            echo '<img class="form-control" style="height:auto;" src="'.$url.$kategorija_izmena_slika_output['slika_kat'].'"><br>';
            echo '<input type="hidden" name="slika_kat_brisanje_izmena" value="'.$kategorija_izmena_slika_output['slika_kat'].'">';
            echo '<input type="hidden" name="slika_kat_ime" value="'.$kategorija_izmena_slika_output['ime_kat'].'">';
            echo '<input type="hidden" name="slika_kat_id" value="'.$kategorija_izmena_slika_output['id_kat'].'">';
            echo '<label for="kat_izmena_slike">Izaberite drugu željenu sliku:</label><br>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse&hellip; <input type="file" name="kat_izmena_slike" style="display: none;">
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div><br>
                  <input type="hidden" name="MAX_FILE_SIZE" value="20480"><br>
                  <button type="submit" name="izmena_slike" class="btn btn-info">Dodajte drugu sliku</button>';
        }
        echo '</form>';
      }
      ?>
    </div>
    <div class="col-lg-4">
    <hr>
    <h4>Unesite novu kategoriju</h4>
    <hr>
    <form method="POST" enctype="multipart/form-data">
      <label for="naslov_add">Naslov:</label><br>
      <input class="form-control"  type="text" id="naslov_add" name="naslov_add" placeholder="Unesite željeno ime kategorije"><br>
      <label for="opis_add">Opis:</label><br>
      <textarea class="form-control" id="opis_add" name="opis_add" placeholder="Unesite željeni opis kategorije" row="4"></textarea><br>
      <label for="slika_add">Izaberite željenu sliku:</label><br>
      <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse&hellip; <input type="file" name="slika_add" style="display: none;">
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div><br>
      <input type="hidden" name="MAX_FILE_SIZE" value="20480">
      <button type="submit" name="kategorija_add" class="btn btn-info">Dodaj kategoriju</button>
      <button type="reset" class="btn btn-warning pull-right">Obriši sve</button>  
    </form>
    </div>
    </div>
<?php
  //BRISANJE KATEGORIJE
  if(isset($_POST['obrisi_kategoriju'])){
    $provera_pkat = $conn->prepare("SELECT * FROM podkategorija WHERE id_kat= :id_kat");
    $provera_pkat->bindParam(':id_kat', $_POST['id_kat_izmena'], PDO::PARAM_INT); 
    $provera_pkat->execute();
    if(count($provera_pkat) > 0){
      $promeni_id_kat = $conn->prepare("UPDATE podkategorija SET id_kat ='0'  WHERE id_kat= :id_kat");
      $promeni_id_kat->bindParam(':id_kat', $_POST['id_kat_izmena'], PDO::PARAM_INT);
      $promeni_id_kat->execute();
    }
    $obrisi_kategoriju_delete = $conn->prepare("DELETE FROM kategorija where id_kat = :id_kat_izmena");
    $obrisi_kategoriju_delete->bindParam(':id_kat_izmena', $_POST['id_kat_izmena'], PDO::PARAM_INT); 
    $obrisi_kategoriju_delete->execute();
    unlink("../".$_POST['slika_kat_brisanje']);
    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/kategorije"</script>';
  }
  //IZMENA KATEGORIJE
  if(isset($_POST['izmena_kategorije'])){ 
    $izmena_kategorija_change = $conn->prepare("UPDATE kategorija SET ime_kat= :ime_kate , opis_kat= :opis_kate WHERE id_kat= :id_kat_izmena");
    $izmena_kategorija_change->bindParam(':id_kat_izmena', $_POST['id_kat_izmena'], PDO::PARAM_INT); 
    $izmena_kategorija_change->bindParam(':ime_kate', $_POST['ime_kat'], PDO::PARAM_STR);  
    $izmena_kategorija_change->bindParam(':opis_kate', $_POST['opis_kat'], PDO::PARAM_STR);  
    $izmena_kategorija_change->execute();
    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/kategorije"</script>';
  }
  //DODAVANJE KATEGORIJE
  if(isset($_POST['kategorija_add'])){
     if ($_FILES ['slika_add']['error'] > 0){
     switch ($_FILES ['slika_add']['error']){
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
  if ($_FILES ['slika_add']['size'] > 1048576*$max_vrednost) { echo greska('Problem','Slika je prevelika pokusajte ponovo'); exit;}
  if ($_FILES ['slika_add']['type']=='image/jpeg'){ $a="ok"; $b=".jpg";}
  if ($_FILES ['slika_add']['type']=='image/png'){ $a="ok"; $b=".png";}
  if ($a!="ok"){ echo greska('Problem','Problem: slika nije u okviru ponudjenih formata jpg i png, pokusajte ponovo'); exit;}
  $upfile = '../images/kat_slike/'.$_POST['naslov_add'].$b;
  $up_file = 'images/kat_slike/'.$_POST['naslov_add'].$b;
  if ( is_uploaded_file ($_FILES ['slika_add']['tmp_name'])){
     if ( !move_uploaded_file ($_FILES ['slika_add']['tmp_name'], $upfile)){
        echo greska('Problem','Nije premestena slika u sajt');
        exit;
     }
  }else{
     echo greska('Problem','Nismo ucitali sliku pod nazivom:'.$_FILES ['slika_add']['name']);
     exit;
  }
    $kategorija_add_new = $conn->prepare("INSERT INTO kategorija (id_kat, ime_kat, opis_kat, slika_kat) VALUES (NULL , :naslov_add, :opis_add, :slika_add)");
    $kategorija_add_new->bindParam(':naslov_add', $_POST['naslov_add'], PDO::PARAM_STR);  
    $kategorija_add_new->bindParam(':opis_add', $_POST['opis_add'], PDO::PARAM_STR);   
    $kategorija_add_new->bindParam(':slika_add', $up_file, PDO::PARAM_STR);  
    $kategorija_add_new->execute();
    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/kategorije"</script>';
  }
  //IZMENA SLIKE
  if(isset($_POST['izmena_slike'])){
    if ($_FILES ['kat_izmena_slike']['error'] > 0){
     switch ($_FILES ['kat_izmena_slike']['error']){
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
  if ($_FILES ['kat_izmena_slike']['size'] > 1048576*$max_vrednost) { echo greska('Problem','Slika je prevelika pokusajte ponovo'); exit;}
  if ($_FILES ['kat_izmena_slike']['type']=='image/jpeg'){ $a="ok"; $b=".jpg";}
  if ($_FILES ['kat_izmena_slike']['type']=='image/png'){ $a="ok"; $b=".png";}
  if ($a!="ok"){ echo greska('Problem','Problem: slika nije u okviru ponudjenih formata jpg i png, pokusajte ponovo'); exit;}
  $upfile = '../images/kat_slike/'.$_POST['slika_kat_ime'].$b;
  $up_file = 'images/kat_slike/'.$_POST['slika_kat_ime'].$b;  
    if ( is_uploaded_file ($_FILES ['kat_izmena_slike']['tmp_name'])){
     if ( !move_uploaded_file ($_FILES ['kat_izmena_slike']['tmp_name'], $upfile)){
        echo greska('Problem','Nije premestena slika u sajt');
        exit;
     }
  }else{
     echo greska('Problem','Nismo ucitali sliku pod nazivom:'.$_FILES ['kat_izmena_slike']['name']);
     exit;
  }
  $izmena_slike = $conn->prepare("UPDATE kategorija SET slika_kat= :slika_kate WHERE id_kat= :id_kat_izmenas");
  $izmena_slike->bindParam(':slika_kate', $up_file, PDO::PARAM_STR);  
  $izmena_slike->bindParam(':id_kat_izmenas', $_POST['slika_kat_id'], PDO::PARAM_STR);
  $izmena_slike->execute();
  echo '<script type="text/javascript">window.location = "'.$url.'upravljac/kategorije"</script>';
  }
?>
</div>
