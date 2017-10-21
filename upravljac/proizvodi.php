<?php
  require_once("session.php");
  require_once("class.user.php");
  $user_id = $_SESSION['user_session'];
?>
    <div class="container-fluid" style="margin-top:80px;"> 
      <div class="container">
        <div class="col-lg-4">
          <hr>
          <h4>Izmente informacije o proizvodu</h4>
          <hr>
          <?php
            echo '<form method="POST">';  // Ovde otvaram formu
            echo '<label id="odabir_pkat">Izaberite podkategoriju:</label><br>';
            echo '<select class="form-control" name="odabir_pkat" id="odabir_pkat" onchange="this.form.submit()">'; // Otvaram SELECT tag u kome ce $_POST['odabir_pkat'] sadrzati ID od odabrane podkategorje
            echo '<option value="none">Izaberite podkategoriju</option>';
            // Sada pravimo upit da bi ispisali prvo kategorije u kojima se nalaze podkategorije
            $odabir_kat = $conn->query("SELECT ime_kat, id_kat FROM kategorija");
            $odabir_kat->execute();
            while($odabir_kat_o=$odabir_kat->fetch()){
              echo '<optgroup label="'.$odabir_kat_o['ime_kat'].'">';
              $odabir_pkat = $conn->prepare("SELECT id_pkat, ime_pkat, id_kat FROM podkategorija WHERE id_kat= :id_kat");
              $odabir_pkat->bindParam(':id_kat', $odabir_kat_o['id_kat'], PDO::PARAM_INT);
              $odabir_pkat->execute();
              while($odabir_pkat_o=$odabir_pkat->fetch()){
                echo '<option value="'.$odabir_pkat_o['id_pkat'].'"';
                  // POCETAK KODA ZA SELECTED
                if(isset($_POST['odabir_pkat'])){
                  if($_POST['odabir_pkat']==$odabir_pkat_o['id_pkat']){ // Ovde proveravam da li je id_pkat jednak sa $_POST['odabir_pkat']
                    echo ' selected';
                  }
                }elseif (isset($_POST['odabir_ppkat'])) { // Sada proveravam da li je postavljen $_POST['odabir_ppkat']
                  // Pitamo bazu 'ppkategorija' da nam izbaci jedan rekor iz nje gde se poklapa id_ppkat da bi dobili id_pkat
                  $ppkat_upit_odabir_selected = $conn->prepare("SELECT id_pkat FROM ppkategorija WHERE id_ppkat= :id_ppkat");
                  $ppkat_upit_odabir_selected->bindParam(':id_ppkat', $_POST['odabir_ppkat'], PDO::PARAM_INT);
                  $ppkat_upit_odabir_selected->execute();
                  while ($ppkat_upit_odabir_selected_o=$ppkat_upit_odabir_selected->fetch()) {
                    if ($ppkat_upit_odabir_selected_o['id_pkat']==$odabir_pkat_o['id_pkat']) {
                      echo ' selected';
                    }
                  }
                }elseif (isset($_POST['odabir_proiz'])) { // Sada proveravam da li je postavljen $_POST['odabir_proiz']
                  // Pitamo bazu 'kat_pkat_ppkat_proiz' da nam izbaci jedan rekor iz nje gde se poklapa id_ppkat da bi dobili id_pkat
                  $proiz_upit_odabir_selected = $conn->prepare("SELECT id_pkat FROM kat_pkat_ppkat_proiz WHERE id_proiz= :id_proiz");
                  $proiz_upit_odabir_selected->bindParam(':id_proiz', $_POST['odabir_proiz'], PDO::PARAM_INT);
                  $proiz_upit_odabir_selected->execute();
                  while ($proiz_upit_odabir_selected_o=$proiz_upit_odabir_selected->fetch()) {
                    if($proiz_upit_odabir_selected_o['id_pkat']==$odabir_pkat_o['id_pkat'])
                      echo ' selected';
                  }
                }
                // KRAJ KODA ZA SELECTED
                echo '>'.$odabir_pkat_o['ime_pkat'].'</option>';
              }
              echo '</optgroup>';
            }
            echo '</select>';
            echo '</form>';
            if(isset($_POST['odabir_pkat']) OR isset($_POST['odabir_ppkat']) OR isset($_POST['odabir_proiz'])){
              echo '<br>';
              echo '<form method="POST">';
              echo '<label for="odabir_ppkat">Izaberite pod-podkategoriju</label><br>';
              echo '<select class="form-control" name="odabir_ppkat" id="odabir_ppkat" onchange="this.form.submit()">';
              echo '<option>Izaberite pod-podkategoriju</option>';
              $ppkat_upit_odabir = $conn->prepare("SELECT id_ppkat, ime_ppkat, id_pkat FROM ppkategorija WHERE id_pkat= :id_pkat");
              if(isset($_POST['odabir_pkat'])){  
                $ppkat_upit_odabir->bindParam(':id_pkat', $_POST['odabir_pkat'], PDO::PARAM_INT);
              }elseif(isset($_POST[odabir_ppkat])) {
                $upit_za_id_pkat_odabir = $conn->prepare("SELECT id_ppkat, id_pkat FROM kat_pkat_ppkat WHERE id_ppkat= :id_ppkat");
                $upit_za_id_pkat_odabir->bindParam(':id_ppkat', $_POST[odabir_ppkat], PDO::PARAM_INT);
                $upit_za_id_pkat_odabir->execute();
                while ($upit_za_id_pkat_odabir_o=$upit_za_id_pkat_odabir->fetch()){
                  $ppkat_upit_odabir->bindParam(':id_pkat', $upit_za_id_pkat_odabir_o['id_pkat'], PDO::PARAM_INT);
                }
              }elseif(isset($_POST['odabir_proiz'])){
                $upit_za_id_pkat_odabir_proiz = $conn->prepare("SELECT id_proiz, id_pkat FROM kat_pkat_ppkat_proiz WHERE id_proiz= :id_proiz");
                $upit_za_id_pkat_odabir_proiz->bindParam(':id_proiz', $_POST['odabir_proiz'], PDO::PARAM_INT);
                $upit_za_id_pkat_odabir_proiz->execute();
                while ($upit_za_id_pkat_odabir_proiz_o=$upit_za_id_pkat_odabir_proiz->fetch()){
                  $ppkat_upit_odabir->bindParam(':id_pkat', $upit_za_id_pkat_odabir_proiz_o['id_pkat'], PDO::PARAM_INT);
                }
              }
              $ppkat_upit_odabir->execute();
              while($ppkat_upit_odabir_o=$ppkat_upit_odabir->fetch()){
                echo '<option value="'.$ppkat_upit_odabir_o['id_ppkat'].'"';
                  if(isset($_POST['odabir_ppkat'])){
                    if($ppkat_upit_odabir_o['id_ppkat']==$_POST['odabir_ppkat']){
                      echo ' selected';
                    }
                  }elseif (isset($_POST['odabir_proiz'])) { 
                    $proiz_upit_odabir_selected_p = $conn->prepare("SELECT id_ppkat FROM kat_pkat_ppkat_proiz WHERE id_proiz= :id_proiz");
                    $proiz_upit_odabir_selected_p->bindParam(':id_proiz', $_POST['odabir_proiz'], PDO::PARAM_INT);
                    $proiz_upit_odabir_selected_p->execute();
                    while ($proiz_upit_odabir_selected_p_o=$proiz_upit_odabir_selected_p->fetch()) {
                      if($ppkat_upit_odabir_o['id_ppkat']==$proiz_upit_odabir_selected_p_o['id_ppkat']){
                        echo ' selected';
                      }
                    }
                  }
                echo '>'.$ppkat_upit_odabir_o['ime_ppkat'].'</option>';
              }
              echo '</select>';
              echo '</form>';
              if($ppkat_upit_odabir->rowCount() == 0){
                greska("Trenutno", "u ovoj podkategoriji nema pod-podkategorija");
              }
            }
            if(isset($_POST['odabir_ppkat']) OR isset($_POST['odabir_proiz'])){
              echo '<br>';
              echo '<form method="POST">';
              echo '<label for="odabir_proiz">Izaberite proizvod</label><br>';
              echo '<select class="form-control" name="odabir_proiz" id="odabir_proiz" onchange="this.form.submit()">';
              echo '<option>Izaberite proizvod</option>';
              $odabir_proiz = $conn->prepare("SELECT id_proiz, ime_proiz, id_ppkat FROM proizvod WHERE id_ppkat= :id_ppkat");
              if(isset($_POST['odabir_ppkat'])){
                $odabir_proiz->bindParam(':id_ppkat', $_POST['odabir_ppkat'], PDO::PARAM_INT);
              }elseif(isset($_POST['odabir_proiz'])){
                $odabir_proiz_u = $conn->prepare("SELECT id_proiz, id_ppkat FROM kat_pkat_ppkat_proiz WHERE id_proiz= :id_proiz");
                $odabir_proiz_u->bindParam(':id_proiz', $_POST['odabir_proiz'], PDO::PARAM_INT);
                $odabir_proiz_u->execute();
                while ($odabir_proiz_u_o=$odabir_proiz_u->fetch()) {
                  $odabir_proiz->bindParam(':id_ppkat', $odabir_proiz_u_o['id_ppkat'], PDO::PARAM_INT);
                }
              }
              $odabir_proiz->execute();
              while($odabir_proiz_o=$odabir_proiz->fetch()){
                echo '<option value="'.$odabir_proiz_o['id_proiz'].'"';
                if($odabir_proiz_o['id_proiz']==$_POST['odabir_proiz']){
                  echo ' selected';
                }
                echo '>'.$odabir_proiz_o['ime_proiz'].'</option>';
              }
              echo '</select>';
              echo '</form>';
              if($odabir_proiz->rowCount() == 0){
                greska("Trenutno", "u ovoj pod-podkategoriji nema proizvoda");
              }
            }
            if(isset($_POST['odabir_proiz'])){
              echo '<hr>';
              echo '<form method="POST">';
              $izmena_proiz = $conn->prepare("SELECT * FROM proizvod WHERE id_proiz= :id_proiz");
              $izmena_proiz->bindParam(':id_proiz', $_POST['odabir_proiz'], PDO::PARAM_INT);
              $izmena_proiz->execute();
              while($izmena_proiz_o=$izmena_proiz->fetch()){
                echo '<input type="hidden" name="id_proizv" value="'.$izmena_proiz_o['id_proiz'].'">';
                echo '<input type="hidden" name="slika_proiz_brisanje" value="'.$izmena_proiz_o['slika_proiz'].'">';
                echo '<label for="ime_proiz">Naziv proizvoda</label><br>';
                echo '<input class="form-control" type="text" name="ime_proiz" id="ime_proiz" value="'.$izmena_proiz_o['ime_proiz'].'"><br>';
                echo '<label for="cena_proiz">Cena proizvoda</label><br>';
                echo '<input class="form-control" type="text" name="cena_proiz" id="cena_proiz" value="'.$izmena_proiz_o['cena_proiz'].'"><br>';
                echo '<label for="opis_proiz">Opis proizvoda</label>';
                echo '<textarea name="opis_proiz" id="opis_proiz">'.$izmena_proiz_o['opis_proiz'].'</textarea><br>';
                echo '<button type="submit" name="izmena_proiz" class="btn btn-info" onclick="return ';
                echo "confirm('Da li ste sigurni da želite da izmenite (".$izmena_proiz_o['ime_proiz'].")')";
                echo '">Sačuvaj promene</button>';
                echo '<button type="submit" name="obrisi_proiz" class="btn btn-danger pull-right" onclick="return ';
                echo "confirm('Da li ste sigurni da želite da obrišete (".$izmena_proiz_o['ime_proiz'].")')";
                echo '">Obriši</button>';
              }
              echo '</form>';
            }
          ?>
        </div> 
        <div class="col-lg-4">
          <hr>
          <h4>Izmente sliku proizvoda</h4>
          <hr>
                  <?php
            echo '<form method="POST">';  // Ovde otvaram formu
            echo '<label id="odabir_slike_pkat">Izaberite podkategoriju:</label><br>';
            echo '<select class="form-control" name="odabir_slike_pkat" id="odabir_slike_pkat" onchange="this.form.submit()">'; // Otvaram SELECT tag u kome ce $_POST['odabir_slike_pkat'] sadrzati ID od odabrane podkategorje
            echo '<option value="none">Izaberite podkategoriju</option>';
            // Sada pravimo upit da bi ispisali prvo kategorije u kojima se nalaze podkategorije
            $odabir_slike_kat = $conn->query("SELECT ime_kat, id_kat FROM kategorija");
            $odabir_slike_kat->execute();
            while($odabir_slike_kat_o=$odabir_slike_kat->fetch()){
              echo '<optgroup label="'.$odabir_slike_kat_o['ime_kat'].'">';
              $odabir_slike_pkat = $conn->prepare("SELECT id_pkat, ime_pkat, id_kat FROM podkategorija WHERE id_kat= :id_kat");
              $odabir_slike_pkat->bindParam(':id_kat', $odabir_slike_kat_o['id_kat'], PDO::PARAM_INT);
              $odabir_slike_pkat->execute();
              while($odabir_slike_pkat_o=$odabir_slike_pkat->fetch()){
                echo '<option value="'.$odabir_slike_pkat_o['id_pkat'].'"';
                  // POCETAK KODA ZA SELECTED
                if(isset($_POST['odabir_slike_pkat'])){
                  if($_POST['odabir_slike_pkat']==$odabir_slike_pkat_o['id_pkat']){ // Ovde proveravam da li je id_pkat jednak sa $_POST['odabir_slike_pkat']
                    echo ' selected';
                  }
                }elseif (isset($_POST['odabir_slike_ppkat'])) { // Sada proveravam da li je postavljen $_POST['odabir_slike_ppkat']
                  // Pitamo bazu 'ppkategorija' da nam izbaci jedan rekor iz nje gde se poklapa id_ppkat da bi dobili id_pkat
                  $ppkat_upit_odabir_slike_selected = $conn->prepare("SELECT id_pkat FROM ppkategorija WHERE id_ppkat= :id_ppkat");
                  $ppkat_upit_odabir_slike_selected->bindParam(':id_ppkat', $_POST['odabir_slike_ppkat'], PDO::PARAM_INT);
                  $ppkat_upit_odabir_slike_selected->execute();
                  while ($ppkat_upit_odabir_slike_selected_o=$ppkat_upit_odabir_slike_selected->fetch()) {
                    if ($ppkat_upit_odabir_slike_selected_o['id_pkat']==$odabir_slike_pkat_o['id_pkat']) {
                      echo ' selected';
                    }
                  }
                }elseif (isset($_POST['odabir_slike_proiz'])) { // Sada proveravam da li je postavljen $_POST['odabir_slike_proiz']
                  // Pitamo bazu 'kat_pkat_ppkat_proiz' da nam izbaci jedan rekor iz nje gde se poklapa id_ppkat da bi dobili id_pkat
                  $proiz_upit_odabir_slike_selected = $conn->prepare("SELECT id_pkat FROM kat_pkat_ppkat_proiz WHERE id_proiz= :id_proiz");
                  $proiz_upit_odabir_slike_selected->bindParam(':id_proiz', $_POST['odabir_slike_proiz'], PDO::PARAM_INT);
                  $proiz_upit_odabir_slike_selected->execute();
                  while ($proiz_upit_odabir_slike_selected_o=$proiz_upit_odabir_slike_selected->fetch()) {
                    if($proiz_upit_odabir_slike_selected_o['id_pkat']==$odabir_slike_pkat_o['id_pkat'])
                      echo ' selected';
                  }
                }
                // KRAJ KODA ZA SELECTED
                echo '>'.$odabir_slike_pkat_o['ime_pkat'].'</option>';
              }
              echo '</optgroup>';
            }
            echo '</select>';
            echo '</form>';
            if(isset($_POST['odabir_slike_pkat']) OR isset($_POST['odabir_slike_ppkat']) OR isset($_POST['odabir_slike_proiz'])){
              echo '<br>';
              echo '<form method="POST">';
              echo '<label for="odabir_slike_ppkat">Izaberite pod-podkategoriju</label><br>';
              echo '<select class="form-control" name="odabir_slike_ppkat" id="odabir_slike_ppkat" onchange="this.form.submit()">';
              echo '<option>Izaberite pod-podkategoriju</option>';
              $ppkat_upit_odabir_slike = $conn->prepare("SELECT id_ppkat, ime_ppkat, id_pkat FROM ppkategorija WHERE id_pkat= :id_pkat");
              if(isset($_POST['odabir_slike_pkat'])){  
                $ppkat_upit_odabir_slike->bindParam(':id_pkat', $_POST['odabir_slike_pkat'], PDO::PARAM_INT);
              }elseif(isset($_POST[odabir_slike_ppkat])) {
                $upit_za_id_pkat_odabir_slike = $conn->prepare("SELECT id_ppkat, id_pkat FROM kat_pkat_ppkat WHERE id_ppkat= :id_ppkat");
                $upit_za_id_pkat_odabir_slike->bindParam(':id_ppkat', $_POST[odabir_slike_ppkat], PDO::PARAM_INT);
                $upit_za_id_pkat_odabir_slike->execute();
                while ($upit_za_id_pkat_odabir_slike_o=$upit_za_id_pkat_odabir_slike->fetch()){
                  $ppkat_upit_odabir_slike->bindParam(':id_pkat', $upit_za_id_pkat_odabir_slike_o['id_pkat'], PDO::PARAM_INT);
                }
              }elseif(isset($_POST['odabir_slike_proiz'])){
                $upit_za_id_pkat_odabir_slike_proiz = $conn->prepare("SELECT id_proiz, id_pkat FROM kat_pkat_ppkat_proiz WHERE id_proiz= :id_proiz");
                $upit_za_id_pkat_odabir_slike_proiz->bindParam(':id_proiz', $_POST['odabir_slike_proiz'], PDO::PARAM_INT);
                $upit_za_id_pkat_odabir_slike_proiz->execute();
                while ($upit_za_id_pkat_odabir_slike_proiz_o=$upit_za_id_pkat_odabir_slike_proiz->fetch()){
                  $ppkat_upit_odabir_slike->bindParam(':id_pkat', $upit_za_id_pkat_odabir_slike_proiz_o['id_pkat'], PDO::PARAM_INT);
                }
              }
              $ppkat_upit_odabir_slike->execute();
              while($ppkat_upit_odabir_slike_o=$ppkat_upit_odabir_slike->fetch()){
                echo '<option value="'.$ppkat_upit_odabir_slike_o['id_ppkat'].'"';
                  if(isset($_POST['odabir_slike_ppkat'])){
                    if($ppkat_upit_odabir_slike_o['id_ppkat']==$_POST['odabir_slike_ppkat']){
                      echo ' selected';
                    }
                  }elseif (isset($_POST['odabir_slike_proiz'])) { 
                    $proiz_upit_odabir_slike_selected_p = $conn->prepare("SELECT id_ppkat FROM kat_pkat_ppkat_proiz WHERE id_proiz= :id_proiz");
                    $proiz_upit_odabir_slike_selected_p->bindParam(':id_proiz', $_POST['odabir_slike_proiz'], PDO::PARAM_INT);
                    $proiz_upit_odabir_slike_selected_p->execute();
                    while ($proiz_upit_odabir_slike_selected_p_o=$proiz_upit_odabir_slike_selected_p->fetch()) {
                      if($ppkat_upit_odabir_slike_o['id_ppkat']==$proiz_upit_odabir_slike_selected_p_o['id_ppkat']){
                        echo ' selected';
                      }
                    }
                  }
                echo '>'.$ppkat_upit_odabir_slike_o['ime_ppkat'].'</option>';
              }
              echo '</select>';
              echo '</form>';
              if($ppkat_upit_odabir_slike->rowCount() == 0){
                greska("Trenutno", "u ovoj podkategoriji nema pod-podkategorija");
              }
            }
            if(isset($_POST['odabir_slike_ppkat']) OR isset($_POST['odabir_slike_proiz'])){
              echo '<br>';
              echo '<form method="POST">';
              echo '<label for="odabir_slike_proiz">Izaberite proizvod</label><br>';
              echo '<select class="form-control" name="odabir_slike_proiz" id="odabir_slike_proiz" onchange="this.form.submit()">';
              echo '<option>Izaberite proizvod</option>';
              $odabir_slike_proiz = $conn->prepare("SELECT id_proiz, ime_proiz, id_ppkat FROM proizvod WHERE id_ppkat= :id_ppkat");
              if(isset($_POST['odabir_slike_ppkat'])){
                $odabir_slike_proiz->bindParam(':id_ppkat', $_POST['odabir_slike_ppkat'], PDO::PARAM_INT);
              }elseif(isset($_POST['odabir_slike_proiz'])){
                $odabir_slike_proiz_u = $conn->prepare("SELECT id_proiz, id_ppkat FROM kat_pkat_ppkat_proiz WHERE id_proiz= :id_proiz");
                $odabir_slike_proiz_u->bindParam(':id_proiz', $_POST['odabir_slike_proiz'], PDO::PARAM_INT);
                $odabir_slike_proiz_u->execute();
                while ($odabir_slike_proiz_u_o=$odabir_slike_proiz_u->fetch()) {
                  $odabir_slike_proiz->bindParam(':id_ppkat', $odabir_slike_proiz_u_o['id_ppkat'], PDO::PARAM_INT);
                }
              }
              $odabir_slike_proiz->execute();
              while($odabir_slike_proiz_o=$odabir_slike_proiz->fetch()){
                echo '<option value="'.$odabir_slike_proiz_o['id_proiz'].'"';
                if($odabir_slike_proiz_o['id_proiz']==$_POST['odabir_slike_proiz']){
                  echo ' selected';
                }
                echo '>'.$odabir_slike_proiz_o['ime_proiz'].'</option>';
              }
              echo '</select>';
              echo '</form>';
              if($odabir_slike_proiz->rowCount() == 0){
                greska("Trenutno", "u ovoj pod-podkategoriji nema proizvoda");
              }
            }
            if(isset($_POST['odabir_slike_proiz'])){
              echo '<hr>';
              echo '<form method="POST" enctype="multipart/form-data">';
              $odabir_slike = $conn->prepare("SELECT * FROM proizvod WHERE id_proiz = :id_proiz");
              $odabir_slike->bindParam(':id_proiz', $_POST['odabir_slike_proiz'], PDO::PARAM_INT); 
              $odabir_slike->execute();
              while ($odabir_slike_o=$odabir_slike->fetch()){
                  echo '<img class="form-control" style="height:auto;" src="'.$url.$odabir_slike_o['slika_proiz'].'"><br>';
                  echo '<input type="hidden" name="slika_proiz_brisanje_izmena" value="'.$odabir_slike_o['slika_proiz'].'">';
                  echo '<input type="hidden" name="slika_proiz_ime" value="'.$odabir_slike_o['ime_proiz'].'">';
                  echo '<input type="hidden" name="slika_proiz_id" value="'.$odabir_slike_o['id_proiz'].'">';
                  echo '<label for="kat_izmena_slike">Izaberite drugu željenu sliku:</label><br>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary">
                                    Browse&hellip; <input type="file" name="proiz_izmena_slike" style="display: none;">
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
          <h4>Unesite novi proizvod</h4>
          <hr>
           <?php
            echo '<form method="POST">';  // Ovde otvaram formu
            echo '<label id="odabir_novi_pkat">Izaberite podkategoriju:</label><br>';
            echo '<select class="form-control" name="odabir_novi_pkat" id="odabir_novi_pkat" onchange="this.form.submit()">'; // Otvaram SELECT tag u kome ce $_POST['odabir_novi_pkat'] sadrzati ID od odabrane podkategorje
            echo '<option value="none">Izaberite podkategoriju</option>';
            // Sada pravimo upit da bi ispisali prvo kategorije u kojima se nalaze podkategorije
            $odabir_novi_kat = $conn->query("SELECT ime_kat, id_kat FROM kategorija");
            $odabir_novi_kat->execute();
            while($odabir_novi_kat_o=$odabir_novi_kat->fetch()){
              echo '<optgroup label="'.$odabir_novi_kat_o['ime_kat'].'">';
              $odabir_novi_pkat = $conn->prepare("SELECT id_pkat, ime_pkat, id_kat FROM podkategorija WHERE id_kat= :id_kat");
              $odabir_novi_pkat->bindParam(':id_kat', $odabir_novi_kat_o['id_kat'], PDO::PARAM_INT);
              $odabir_novi_pkat->execute();
              while($odabir_novi_pkat_o=$odabir_novi_pkat->fetch()){
                echo '<option value="'.$odabir_novi_pkat_o['id_pkat'].'"';
                  // POCETAK KODA ZA SELECTED
                if(isset($_POST['odabir_novi_pkat'])){
                  if($_POST['odabir_novi_pkat']==$odabir_novi_pkat_o['id_pkat']){ // Ovde proveravam da li je id_pkat jednak sa $_POST['odabir_novi_pkat']
                    echo ' selected';
                  }
                }elseif (isset($_POST['odabir_novi_ppkat'])) { // Sada proveravam da li je postavljen $_POST['odabir_novi_ppkat']
                  // Pitamo bazu 'ppkategorija' da nam izbaci jedan rekor iz nje gde se poklapa id_ppkat da bi dobili id_pkat
                  $ppkat_upit_odabir_novi_selected = $conn->prepare("SELECT id_pkat FROM ppkategorija WHERE id_ppkat= :id_ppkat");
                  $ppkat_upit_odabir_novi_selected->bindParam(':id_ppkat', $_POST['odabir_novi_ppkat'], PDO::PARAM_INT);
                  $ppkat_upit_odabir_novi_selected->execute();
                  while ($ppkat_upit_odabir_novi_selected_o=$ppkat_upit_odabir_novi_selected->fetch()) {
                    if ($ppkat_upit_odabir_novi_selected_o['id_pkat']==$odabir_novi_pkat_o['id_pkat']) {
                      echo ' selected';
                    }
                  }
                }
                // KRAJ KODA ZA SELECTED
                echo '>'.$odabir_novi_pkat_o['ime_pkat'].'</option>';
              }
              echo '</optgroup>';
            }
            echo '</select>';
            echo '</form>';
            if(isset($_POST['odabir_novi_pkat']) OR isset($_POST['odabir_novi_ppkat'])){
              echo '<br>';
              echo '<form method="POST">';
              echo '<label for="odabir_novi_ppkat">Izaberite pod-podkategoriju</label><br>';
              echo '<select class="form-control" name="odabir_novi_ppkat" id="odabir_novi_ppkat" onchange="this.form.submit()">';
              echo '<option>Izaberite pod-podkategoriju</option>';
              $ppkat_upit_odabir_novi = $conn->prepare("SELECT id_ppkat, ime_ppkat, id_pkat FROM ppkategorija WHERE id_pkat= :id_pkat");
              if(isset($_POST['odabir_novi_pkat'])){  
                $ppkat_upit_odabir_novi->bindParam(':id_pkat', $_POST['odabir_novi_pkat'], PDO::PARAM_INT);
              }elseif(isset($_POST[odabir_novi_ppkat])) {
                $upit_za_id_pkat_odabir_novi = $conn->prepare("SELECT id_ppkat, id_pkat FROM kat_pkat_ppkat WHERE id_ppkat= :id_ppkat");
                $upit_za_id_pkat_odabir_novi->bindParam(':id_ppkat', $_POST[odabir_novi_ppkat], PDO::PARAM_INT);
                $upit_za_id_pkat_odabir_novi->execute();
                while ($upit_za_id_pkat_odabir_novi_o=$upit_za_id_pkat_odabir_novi->fetch()){
                  $ppkat_upit_odabir_novi->bindParam(':id_pkat', $upit_za_id_pkat_odabir_novi_o['id_pkat'], PDO::PARAM_INT);
                }
              }
              $ppkat_upit_odabir_novi->execute();
              while($ppkat_upit_odabir_novi_o=$ppkat_upit_odabir_novi->fetch()){
                echo '<option value="'.$ppkat_upit_odabir_novi_o['id_ppkat'].'"';
                if($_POST['odabir_novi_ppkat']==$ppkat_upit_odabir_novi_o['id_ppkat']){
                  echo ' selected';
                }
                echo '>'.$ppkat_upit_odabir_novi_o['ime_ppkat'].'</option>';
              }
              echo '</select>';
              echo '</form>';
              if($ppkat_upit_odabir_novi->rowCount() == 0){
                greska("Trenutno", "u ovoj podkategoriji nema pod-podkategorija");
              }
            }
          ?>
          <br>
            <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_ppkat_add" value="<?php echo $_POST['odabir_novi_ppkat']; ?>">
            <label for="ime_add">Naziv proizvoda</label>
            <input class="form-control" type="text" name="ime_add" id="ime_add" placeholder="Naziv proizvoda"><br>
            <label for="cena_add">Cena proizvoda (<?php echo $valuta; ?>)</label>
            <input class="form-control" type="text" id="cena_add" name="cena_add" placeholder="Cena proizvoda"><br>
            <label for="opis_add">Opis proizvoda</label>
            <textarea placeholder="Opis proizvoda" name="opis_add"></textarea><br>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse&hellip; <input type="file" name="slika_add" style="display: none;">
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div><br>
            <button type="submit" name="proizvod_add" class="btn btn-info">Dodaj proizvod</button>
            <button type="reset" class="btn btn-warning pull-right">Obriši sve</button>  

          </form>
        </div>
      </div>
      <br><br><br>
      <hr>
    </div>
    <?php
  //BRISANJE Proizvoda
  if(isset($_POST['obrisi_proiz'])){
    $obrisi_kategoriju_delete = $conn->prepare("DELETE FROM proizvod where id_proiz = :id_proiz");
    $obrisi_kategoriju_delete->bindParam(':id_proiz', $_POST['id_proizv'], PDO::PARAM_INT); 
    $obrisi_kategoriju_delete->execute();
    unlink("../".$_POST['slika_proiz_brisanje']);
    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/proizvodi"</script>';
  }
  //IZMENA PROIZVODA
  if(isset($_POST['izmena_proiz'])){ 
    $izmena_proiz_change = $conn->prepare("UPDATE proizvod SET ime_proiz= :ime_proiz , cena_proiz= :cena_proiz, opis_proiz= :opis_proiz WHERE id_proiz= :id_proizv");
    $izmena_proiz_change->bindParam(':id_proizv', $_POST['id_proizv'], PDO::PARAM_INT); 
    $izmena_proiz_change->bindParam(':cena_proiz', $_POST['cena_proiz'], PDO::PARAM_STR);
    $izmena_proiz_change->bindParam(':ime_proiz', $_POST['ime_proiz'], PDO::PARAM_STR);   
    $izmena_proiz_change->bindParam(':opis_proiz', $_POST['opis_proiz'], PDO::PARAM_STR);   
    $izmena_proiz_change->execute();
    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/proizvodi"</script>';
  }
  //DODAVANJE KATEGORIJE
  if(isset($_POST['proizvod_add'])){
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
  $upfile = '../images/slike_proizvoda/'.$_POST['ime_add'].$b;
  $up_file = 'images/slike_proizvoda/'.$_POST['ime_add'].$b;
  if ( is_uploaded_file ($_FILES ['slika_add']['tmp_name'])){
     if ( !move_uploaded_file ($_FILES ['slika_add']['tmp_name'], $upfile)){
        echo greska('Problem','Nije premestena slika u sajt');
        exit;
     }
  }else{
     echo greska('Problem','Nismo ucitali sliku pod nazivom:'.$_FILES ['slika_add']['name']);
     exit;
  }
    $proizvod_add_new = $conn->prepare("INSERT INTO proizvod (id_proiz, ime_proiz, cena_proiz, opis_proiz, slika_proiz, id_ppkat) VALUES (NULL , :ime_add, :cena_add, :opis_add, :slika_add, :id_ppkat)");
    $proizvod_add_new->bindParam(':ime_add', $_POST['ime_add'], PDO::PARAM_STR);   
    $proizvod_add_new->bindParam(':cena_add', $_POST['cena_add'], PDO::PARAM_STR); 
    $proizvod_add_new->bindParam(':opis_add', $_POST['opis_add'], PDO::PARAM_STR);    
    $proizvod_add_new->bindParam(':slika_add', $up_file, PDO::PARAM_STR);    
    $proizvod_add_new->bindParam(':id_ppkat', $_POST['id_ppkat_add'], PDO::PARAM_INT); 
    $proizvod_add_new->execute();
    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/proizvodi"</script>';
  }
  //IZMENA SLIKE
 if(isset($_POST['izmena_slike'])){
    if ($_FILES ['proiz_izmena_slike']['error'] > 0){
     switch ($_FILES ['proiz_izmena_slike']['error']){
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
  if ($_FILES ['proiz_izmena_slike']['size'] > 1048576*$max_vrednost) { echo greska('Problem','Slika je prevelika pokusajte ponovo'); exit;}
  if ($_FILES ['proiz_izmena_slike']['type']=='image/jpeg'){ $a="ok"; $b=".jpg";}
  if ($_FILES ['proiz_izmena_slike']['type']=='image/png'){ $a="ok"; $b=".png";}
  if ($a!="ok"){ echo greska('Problem','Problem: slika nije u okviru ponudjenih formata jpg i png, pokusajte ponovo'); exit;}
  $upfile = '../images/slike_proizvoda/'.$_POST['slika_proiz_ime'].$b;
  $up_file = 'images/slike_proizvoda/'.$_POST['slika_proiz_ime'].$b;  
    if ( is_uploaded_file ($_FILES ['proiz_izmena_slike']['tmp_name'])){
     if ( !move_uploaded_file ($_FILES ['proiz_izmena_slike']['tmp_name'], $upfile)){
        echo greska('Problem','Nije premestena slika u sajt');
        exit;
     }
  }else{
     echo greska('Problem','Nismo ucitali sliku pod nazivom:'.$_FILES ['proiz_izmena_slike']['name']);
     exit;
  }
  $izmena_slike = $conn->prepare("UPDATE proizvod SET slika_proiz= :slika_proiz WHERE id_proiz= :slika_proiz_id");
  $izmena_slike->bindParam(':slika_proiz', $up_file, PDO::PARAM_STR);  
  $izmena_slike->bindParam(':slika_proiz_id', $_POST['slika_proiz_id'], PDO::PARAM_STR);
  $izmena_slike->execute();
  echo '<script type="text/javascript">window.location = "'.$url.'upravljac/proizvodi"</script>';
  }
?>