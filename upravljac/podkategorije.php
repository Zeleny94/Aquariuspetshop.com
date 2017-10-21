<?php
  require_once("session.php");
  require_once("class.user.php");
  $user_id = $_SESSION['user_session'];
?>
<div class="container-fluid" style="margin-top:80px;">
  <div class="container">
    <div class="col-lg-4">
    <hr>
    <h4>Izmeni ili obriši podkategoriju</h4>
    <hr>
      <form method="POST">
      <?php
        $kategorija_lista_izmena = $conn->query("SELECT * FROM kategorija");
        $kategorija_lista_izmena->execute();
        echo '<select class="form-control" name="pkat_lista" onchange="this.form.submit()">';
        echo '<option>Izaberite podkategoriju</option>';
        while ($kat_lis_output=$kategorija_lista_izmena->fetch()){
          echo '<optgroup label="'.$kat_lis_output['ime_kat'].'">';
          $pkat_upit = $conn->prepare("select * from podkategorija where id_kat = :idkat");
          $pkat_upit->execute(array(':idkat' => $kat_lis_output[id_kat]));
          while($pkat_output = $pkat_upit->fetch()){
            echo '<option';
          if($_POST['pkat_lista']==$pkat_output['id_pkat']){
            echo ' selected';
          }
          echo ' value="'.$pkat_output['id_pkat'].'">'.$pkat_output['ime_pkat'].'</option>';
          }
          echo '</optgroup>';
        }
        $kategorija_id0 = $conn->query("SELECT * FROM podkategorija WHERE id_kat='0'");
        $kategorija_id0->execute();
        while ($kategorija_id0_o=$kategorija_id0->fetch()) {
          echo '<optgroup label="Nedodeljene kategorije">';
            echo '<option';
          if($_POST['pkat_lista']==$kategorija_id0_o['id_pkat']){
            echo ' selected';
          }
          echo ' value="'.$kategorija_id0_o['id_pkat'].'">'.$kategorija_id0_o['ime_pkat'].'</option>';

        }
        if(!$kategorija_id0->rowCount() == 0){
          echo '</optgroup>';
        }
        echo '</select>';
      ?>
      </form>
      <?php
      if(isset($_POST['pkat_lista'])){
        echo '<hr><form method="POST">';
        $kategorija_izmena_pod = $conn->prepare("SELECT * FROM podkategorija WHERE id_pkat = :id_pkat");
        $kategorija_izmena_pod->bindParam(':id_pkat', $_POST['pkat_lista'], PDO::PARAM_INT); 
        $kategorija_izmena_pod->execute();
        while ($kategorija_izmena_pod_output=$kategorija_izmena_pod->fetch()){
          $podkat_izmena_kat = $conn->query("SELECT * FROM kategorija");
          $podkat_izmena_kat->execute();
          echo '<label for="podkat_izmena_kat">Izaberite kategoriju u kojoj će se nalaziti podkategorija:</label><br>';
          echo '<select class="form-control" id="podkat_izmena_kat" name="podkat_izmena_kat">';
          echo '<option>Izaberite kategoriju u kojoj će se nalaziti podkategorija</option>';
          while($podkat_izmena_kat_output=$podkat_izmena_kat->fetch()){
            echo '<option value="'.$podkat_izmena_kat_output['id_kat'].'"';
            if($kategorija_izmena_pod_output['id_kat']==$podkat_izmena_kat_output['id_kat']){
              echo ' selected';
            }
            echo '>'.$podkat_izmena_kat_output['ime_kat'].'</option>';
          }
          echo '</select><br>';
          echo '<input type="hidden" name="id_pkat_izmena" value="'.$kategorija_izmena_pod_output['id_pkat'].'">';
          echo '<input type="hidden" name="slika_pkat_brisanje" value="'.$kategorija_izmena_pod_output['slika_pkat'].'">';
          echo '<label for="naslov">Naslov:</label><br>';
          echo '<input class="form-control" type="text" id="naslov" name="ime_pkat" value="'.$kategorija_izmena_pod_output['ime_pkat'].'"> <br>';
          echo '<label for="opis">Opis:</label><br>';
          echo '<textarea row="4"  class="form-control" type="text" id="opis" name="opis_pkat">'.$kategorija_izmena_pod_output['opis_pkat'].'</textarea> <br>';
          echo '<button type="submit" name="izmena_pkategorije" class="btn btn-info" onclick="return ';
          echo "confirm('Da li ste sigurni da želite da izmenite (".$kategorija_izmena_pod_output['ime_pkat'].")')";
          echo '">Sačuvaj promene</button>';
          echo '<button type="submit" name="obrisi_pkategoriju" class="btn btn-danger pull-right" onclick="return ';
          echo "confirm('Da li ste sigurni da želite da obrišete (".$kategorija_izmena_pod_output['ime_pkat'].")')";
          echo '">Obriši</button>';
        }
        echo '</form>';
      }
      //BRISANJE KATEGORIJE
      if(isset($_POST['obrisi_pkategoriju'])){
        $obrisi_pkategoriju_delete = $conn->prepare("DELETE FROM podkategorija where id_pkat = :id_pkat_izmena");
        $obrisi_pkategoriju_delete->bindParam(':id_pkat_izmena', $_POST['id_pkat_izmena'], PDO::PARAM_INT); 
        $obrisi_pkategoriju_delete->execute();
        unlink("../".$_POST['slika_pkat_brisanje']);
        echo '<script type="text/javascript">window.location = "'.$url.'upravljac/podkategorije"</script>';
      }
      //IZMENA KATEGORIJE
      if(isset($_POST['izmena_pkategorije'])){ 
        $izmena_pkategorija_change = $conn->prepare("UPDATE podkategorija SET ime_pkat= :ime_pkate , opis_pkat= :opis_pkate, id_kat= :podkat_izmena_kat WHERE id_pkat= :id_pkat_izmena");
        $izmena_pkategorija_change->bindParam(':id_pkat_izmena', $_POST['id_pkat_izmena'], PDO::PARAM_INT); 
        $izmena_pkategorija_change->bindParam(':ime_pkate', $_POST['ime_pkat'], PDO::PARAM_STR);  
        $izmena_pkategorija_change->bindParam(':opis_pkate', $_POST['opis_pkat'], PDO::PARAM_STR);  
        $izmena_pkategorija_change->bindParam(':podkat_izmena_kat', $_POST['podkat_izmena_kat'], PDO::PARAM_STR);  
        $izmena_pkategorija_change->execute();
        echo '<script type="text/javascript">window.location = "'.$url.'upravljac/podkategorije"</script>';
      }
      ?>
    </div>
    <div class="col-lg-4">
    <hr>
    <h4>Izmeni sliku podkategorije</h4>
    <hr>
      
      <form method="POST">
      <?php
        $kategorija_lista_izmena_slika = $conn->query("SELECT * FROM kategorija");
        $kategorija_lista_izmena_slika->execute();
        echo '<select class="form-control" name="pkat_slika" onchange="this.form.submit()">';
        echo '<option>Izaberite podkategoriju</option>';
        while ($kategorija_lista_izmena_slika_output=$kategorija_lista_izmena_slika->fetch()){
          echo '<optgroup label="'.$kategorija_lista_izmena_slika_output['ime_kat'].'">';
          $pkat_upit_slika = $conn->prepare("select * from podkategorija where id_kat = :idkat");
          $pkat_upit_slika->execute(array(':idkat' => $kategorija_lista_izmena_slika_output[id_kat]));
          while($pkat_upit_slika_output = $pkat_upit_slika->fetch()){
            echo '<option';
          if($_POST['pkat_slika']==$pkat_upit_slika_output['id_pkat']){
            echo ' selected';
          }
          echo ' value="'.$pkat_upit_slika_output['id_pkat'].'">'.$pkat_upit_slika_output['ime_pkat'].'</option>';
          }
          echo '</optgroup>';
        }
        $kategorija_slika_id0 = $conn->query("SELECT * FROM podkategorija WHERE id_kat='0'");
        $kategorija_slika_id0->execute();

        while ($kategorija_slika_id0_o=$kategorija_slika_id0->fetch()) {
          echo '<optgroup label="Nedodeljene kategorije">';
            echo '<option';
          if($_POST['pkat_lista']==$kategorija_slika_id0_o['id_pkat']){
            echo ' selected';
          }
          echo ' value="'.$kategorija_slika_id0_o['id_pkat'].'">'.$kategorija_slika_id0_o['ime_pkat'].'</option>';

        }
        if(!$kategorija_slika_id0->rowCount() == 0){
          echo '</optgroup>';
        }
        echo '</select>';
      ?>
      </form>
      <?php
      if(isset($_POST['pkat_slika'])){
        echo '<hr><form method="POST" enctype="multipart/form-data">';
        $kategorija_izmena_slika = $conn->prepare("SELECT * FROM podkategorija WHERE id_pkat = :id_kat");
        $kategorija_izmena_slika->bindParam(':id_kat', $_POST['pkat_slika'], PDO::PARAM_INT); 
        $kategorija_izmena_slika->execute();
        while ($kategorija_izmena_slika_output=$kategorija_izmena_slika->fetch()){
            echo '<img class="form-control" style="height:auto;" src="'.$url.$kategorija_izmena_slika_output['slika_pkat'].'"><br>';
            echo '<input type="hidden" name="slika_kat_brisanje_izmena" value="'.$kategorija_izmena_slika_output['slika_pkat'].'">';
            echo '<input type="hidden" name="slika_kat_ime" value="'.$kategorija_izmena_slika_output['ime_pkat'].'">';
            echo '<input type="hidden" name="slika_kat_id" value="'.$kategorija_izmena_slika_output['id_pkat'].'">';
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
    <h4>Unesite novu podkategoriju</h4>
    <hr>
      <form method="POST" enctype="multipart/form-data">
      <select id="kat" name="id_kat_new" class="form-control">
      <option>Izaberite kategoriju u kojoj će se nalaziti podkategorija</option>
      <?php
        $new_pkat = $conn->query("SELECT * FROM kategorija");
        $new_pkat->execute();
        while ($new_pkat_output = $new_pkat->fetch()) {
          echo '<option value="'.$new_pkat_output['id_kat'].'">'.$new_pkat_output['ime_kat'].'</option>';
        }
      ?>
      </select><br>
      <label for="naslov_add">Naslov:</label><br>
      <input class="form-control"  type="text" id="naslov_add" name="naslov_add" placeholder="Unesite željeno ime podkategorije"><br>
      <label for="opis_add">Opis:</label><br>
      <textarea class="form-control" id="opis_add" name="opis_add" placeholder="Unesite željeni opis podkategorije" row="4"></textarea><br>
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
      <button type="submit" name="kategorija_add" class="btn btn-info">Dodaj podkategoriju</button>
      <button type="reset" class="btn btn-warning pull-right">Obriši sve</button>  
    </form>
    </div>
  </div>
  <?php
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
  $upfile = '../images/pod_kat/'.$_POST['naslov_add'].$b;
  $up_file = 'images/pod_kat/'.$_POST['naslov_add'].$b;
  if ( is_uploaded_file ($_FILES ['slika_add']['tmp_name'])){
     if ( !move_uploaded_file ($_FILES ['slika_add']['tmp_name'], $upfile)){
        echo greska('Problem','Nije premestena slika u sajt');
        exit;
     }
  }else{
     echo greska('Problem','Nismo ucitali sliku pod nazivom:'.$_FILES ['slika_add']['name']);
     exit;
  }
    $kategorija_add_new = $conn->prepare("INSERT INTO podkategorija (id_pkat, ime_pkat, opis_pkat, slika_pkat, id_kat) VALUES (NULL , :naslov_add, :opis_add, :slika_add, :id_kat)");
    $kategorija_add_new->bindParam(':naslov_add', $_POST['naslov_add'], PDO::PARAM_STR);  
    $kategorija_add_new->bindParam(':opis_add', $_POST['opis_add'], PDO::PARAM_STR);   
    $kategorija_add_new->bindParam(':id_kat', $_POST['id_kat_new'], PDO::PARAM_STR);   
    $kategorija_add_new->bindParam(':slika_add', $up_file, PDO::PARAM_STR);  
    $kategorija_add_new->execute();
    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/podkategorije"</script>';
  }
  //IZMENA SLIKE
          if(isset($_POST['izmena_slike'])){
            unlink("../".$_POST['slika_kat_brisanje_izmena']);
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
          $upfile = '../images/pod_kat/'.$_POST['slika_kat_ime'].$b;
          $up_file = 'images/pod_kat/'.$_POST['slika_kat_ime'].$b;  
            if ( is_uploaded_file ($_FILES ['kat_izmena_slike']['tmp_name'])){

             if (!move_uploaded_file ($_FILES ['kat_izmena_slike']['tmp_name'], $upfile)){
                echo greska('Problem','Nije premestena slika u sajt');
                exit;
             }

          }else{
             echo greska('Problem','Nismo ucitali sliku pod nazivom:'.$_FILES ['kat_izmena_slike']['name']);
             exit;
          }
          $izmena_slike = $conn->prepare("UPDATE podkategorija SET slika_pkat= :slika_kate WHERE id_pkat= :id_kat_izmenas");
          $izmena_slike->bindParam(':slika_kate', $up_file, PDO::PARAM_STR);  
          $izmena_slike->bindParam(':id_kat_izmenas', $_POST['slika_kat_id'], PDO::PARAM_STR);
          $izmena_slike->execute();
          echo '<script type="text/javascript">window.location = "'.$url.'upravljac/podkategorije"</script>';
          }
  ?>
</div>
