<?php
  require_once("session.php");
  require_once("class.user.php");
  $user_id = $_SESSION['user_session'];
?>
<div class="container-fluid" style="margin-top:80px;">
	<div class="container">
        <div class="col-lg-4">
		    <hr>
		    <h4>Izmeni ili obriši pod-podkategoriju</h4>
		    <hr>
		    <?php
		    	$pri_kat = $conn->query("SELECT * FROM kategorija");
		    	$pri_kat->execute();
		    	echo '<form method="POST">';
		    	echo '<select class="form-control" name="izmena_ppkat" onchange="this.form.submit()">';
		    	echo '<option>Izaberite pod-podkategoriju</option>';
		    	while ($pri_kat_o=$pri_kat->fetch()) {
		    		 echo '<optgroup label="'.$pri_kat_o['ime_kat'].'">';
		    		 	$pri_pkat = $conn->prepare("SELECT * FROM podkategorija WHERE id_kat= :id_kat");
		    		 	$pri_pkat->bindParam(':id_kat', $pri_kat_o['id_kat'], PDO::PARAM_INT);
		    		 	$pri_pkat->execute();
		    		 	while ($pri_pkat_o=$pri_pkat->fetch()) {
				    		echo '<optgroup label="&nbsp;&nbsp;'.$pri_pkat_o['ime_pkat'].'">';
				    			$pri_ppkat = $conn->prepare("SELECT * FROM ppkategorija WHERE id_pkat = :id_pkat");
				    			$pri_ppkat->bindParam(':id_pkat', $pri_pkat_o['id_pkat'], PDO::PARAM_INT);
				    			$pri_ppkat->execute();
				    			while($pri_ppkat_o=$pri_ppkat->fetch()){
				    				echo '<option';
							          if($_POST['izmena_ppkat']==$pri_ppkat_o['id_ppkat']){
							            echo ' selected';
							          }
							          echo '  value="'.$pri_ppkat_o['id_ppkat'].'">'.$pri_ppkat_o['ime_ppkat'].'</option>';
				    			}
				    		echo '</optgroup>';
		    		 	}
		    		  echo '</optgroup>';
		    	}
		    	echo '</select>';
		    	echo '</form>';
		    	if(isset($_POST['izmena_ppkat'])){
		    		$pri_ppkat_izmena = $conn->prepare("SELECT * FROM ppkategorija WHERE id_ppkat= :id_ppkat");
		    		$pri_ppkat_izmena->bindParam(':id_ppkat',$_POST['izmena_ppkat'], PDO::PARAM_INT);
		    		$pri_ppkat_izmena->execute();
		    		echo '<hr>
		    		<form method="POST">';
		    		while ($pri_ppkat_izmena_o=$pri_ppkat_izmena->fetch()){
		    		echo '<label for="promeni_kategoriju">Izaberite podkategoriju u kojoj će se nalaziti pod-podkategorija:</label>
		    		<select class="form-control" name="promeni_ppkategoriju" id="promeni_kategoriju">';
		    			$kategorija_ls_ppkat = $conn->query("SELECT * FROM kategorija");
		    			$kategorija_ls_ppkat->execute();
		    			while ($kategorija_ls_o_ppkat=$kategorija_ls_ppkat->fetch()) {
		    				echo '<optgroup label="'.$kategorija_ls_o_ppkat['ime_kat'].'">';
			    			$podkategorija_ls_ppkat = $conn->prepare("SELECT * FROM podkategorija WHERE id_kat= :id_kat");
			    			$podkategorija_ls_ppkat->bindParam(':id_kat', $kategorija_ls_o_ppkat['id_kat'], PDO::PARAM_INT);
			    			$podkategorija_ls_ppkat->execute();
		    				while($podkategorija_ls_o_ppkat=$podkategorija_ls_ppkat->fetch()){
		    					echo '<option value="'.$podkategorija_ls_o_ppkat['id_pkat'].'"';
					            if($pri_ppkat_izmena_o['id_pkat']==$podkategorija_ls_o_ppkat['id_pkat']){
					              echo ' selected';
					            }
					            echo '>'.$podkategorija_ls_o_ppkat['ime_pkat'].'</option>';
		    			}
		    		echo '</optgroup>';
		    	}
		    		echo '</select><br>';
			        echo '<input type="hidden" name="id_ppkat_izmena" value="'.$pri_ppkat_izmena_o['id_ppkat'].'">';
			        echo '<input type="hidden" name="slika_ppkat_brisanje" value="'.$pri_ppkat_izmena_o['slika_ppkat'].'">';
		    		echo '<label for="ime_ppkat">Naslov:</label><br>';
		    		echo '<input class="form-control" type="text" name="ime_ppkat" value="'.$pri_ppkat_izmena_o['ime_ppkat'].'"><br>';
		            echo '<label for="opis">Opis:</label><br>';
		            echo '<textarea row="4"  class="form-control" type="text" id="opis" name="opis_ppkat">'.$pri_ppkat_izmena_o['opis_ppkat'].'</textarea> <br>';
		            echo '<button type="submit" name="izmena_ppkategorije" class="btn btn-info" onclick="return ';
		            echo "confirm('Da li ste sigurni da želite da izmenite (".$pri_ppkat_izmena_o['ime_ppkat'].")')";
		            echo '">Sačuvaj promene</button>';
		            echo '<button type="submit" name="obrisi_ppkategoriju" class="btn btn-danger pull-right" onclick="return ';
		            echo "confirm('Da li ste sigurni da želite da obrišete (".$pri_ppkat_izmena_o['ime_ppkat'].")')";
		            echo '">Obriši</button>';
		    	}
		    	  	echo'</form>';
		    	}
		     ?>
		</div>
        <div class="col-lg-4">
		    <hr>
		    <h4>Izmeni sliku pod-podkategorije</h4>
		    <hr>
		    <?php
		    	$pri_kat = $conn->query("SELECT * FROM kategorija");
		    	$pri_kat->execute();
		    	echo '<form method="POST">';
		    	echo '<select class="form-control" name="izmena_ppkat_slike" onchange="this.form.submit()">';
		    	echo '<option>Izaberite pod-podkategoriju</option>';
		    	while ($pri_kat_o=$pri_kat->fetch()) {
		    		 echo '<optgroup label="'.$pri_kat_o['ime_kat'].'">';
		    		 	$pri_pkat = $conn->prepare("SELECT * FROM podkategorija WHERE id_kat= :id_kat");
		    		 	$pri_pkat->bindParam(':id_kat', $pri_kat_o['id_kat'], PDO::PARAM_INT);
		    		 	$pri_pkat->execute();
		    		 	while ($pri_pkat_o=$pri_pkat->fetch()) {
				    		echo '<optgroup label="&nbsp;&nbsp;'.$pri_pkat_o['ime_pkat'].'">';
				    			$pri_ppkat = $conn->prepare("SELECT * FROM ppkategorija WHERE id_pkat = :id_pkat");
				    			$pri_ppkat->bindParam(':id_pkat', $pri_pkat_o['id_pkat'], PDO::PARAM_INT);
				    			$pri_ppkat->execute();
				    			while($pri_ppkat_o=$pri_ppkat->fetch()){
				    				echo '<option';
							          if($_POST['izmena_ppkat']==$pri_ppkat_o['id_ppkat']){
							            echo ' selected';
							          }
							          echo '  value="'.$pri_ppkat_o['id_ppkat'].'">'.$pri_ppkat_o['ime_ppkat'].'</option>';
				    			}
				    		echo '</optgroup>';
		    		 	}
		    		  echo '</optgroup><test>';
		    	}
		    	echo '</select>';
		    	echo '</form>';
		    	if(isset($_POST['izmena_ppkat_slike'])){
		    		echo '<hr>';
		    		echo '<form method="POST" enctype="multipart/form-data">';
		    		$ppkategorija_izmena_slika = $conn->prepare("SELECT * FROM ppkategorija WHERE id_ppkat = :id_ppkat");
        			$ppkategorija_izmena_slika->bindParam(':id_ppkat', $_POST['izmena_ppkat_slike'], PDO::PARAM_INT); 
       				$ppkategorija_izmena_slika->execute();
       				while ($ppkategorija_izmena_slika_output=$ppkategorija_izmena_slika->fetch()){
	       			    echo '<img class="form-control" style="height:auto;" src="'.$url.$ppkategorija_izmena_slika_output['slika_ppkat'].'"><br>';
	        			echo '<input type="hidden" name="slika_ppkat_brisanje_izmena" value="'.$ppkategorija_izmena_slika_output['slika_ppkat'].'">';
	        			echo '<input type="hidden" name="slika_ppkat_ime" value="'.$ppkategorija_izmena_slika_output['ime_ppkat'].'">';
	       			    echo '<input type="hidden" name="slika_ppkat_id" value="'.$ppkategorija_izmena_slika_output['id_ppkat'].'">';
	       			    echo '<label for="ppkat_izmena_slike">Izaberite drugu željenu sliku:</label><br>
						      <div class="input-group">
						          <label class="input-group-btn">
						              <span class="btn btn-primary">
						                  Browse&hellip; <input type="file" name="ppkat_izmena_slike" style="display: none;">
						               </span>
						          </label>
						          <input type="text" class="form-control" readonly>
						      </div><br>
	                          <input type="hidden" name="MAX_FILE_SIZE" value="20480">
	                          <button type="submit" name="izmena_slike" class="btn btn-info">Dodajte drugu sliku</button>';
        			}
        			echo '</form>';			
		    	}
		    	?>
		</div>
        <div class="col-lg-4">
		    <hr>
		    <h4>Unesite novu pod-podkategoriju</h4>
		    <hr>
		    <form method="POST" enctype="multipart/form-data">
		    <label for="podkategorija_ls">Izaberite u kojoj podkategoriji će da se nalazi pod-podkategorija</label>
		    <select name="id_pkat_new" class="form-control" id="podkategorija_ls">
		    <option>Izaberite podkategoriju u kojoj će se nalaziti pod-podkategorija</option>
		    	<?php
		    	$kategorija_ls = $conn->query("SELECT * FROM kategorija");
		    	$kategorija_ls->execute();
		    	while ($kategorija_ls_o=$kategorija_ls->fetch()) {
		    		echo '<optgroup label="'.$kategorija_ls_o['ime_kat'].'">';
		    			$podkategorija_ls = $conn->prepare("SELECT * FROM podkategorija WHERE id_kat= :id_kat");
		    			$podkategorija_ls->bindParam(':id_kat', $kategorija_ls_o['id_kat'], PDO::PARAM_INT);
		    			$podkategorija_ls->execute();
		    			while($podkategorija_ls_o=$podkategorija_ls->fetch()){
		    				echo '<option value="'.$podkategorija_ls_o['id_pkat'].'">'.$podkategorija_ls_o['ime_pkat'].'</option>';
		    			}
		    		echo '</optgroup>';
		    	}
		    	?>
		    </select><br>
		    <label for="naslov">Naslov:</label>
		    <input type="text" name="naslov_add" id="naslov" class="form-control" placeholder="Unesite željeni naslov"><br>
		    <label for="opis">Opis:</label>
		    <textarea name="opis_add" class="form-control" id="opis" placeholder="Unesite željeni opis"></textarea><br>
		    <label for="new_ppkat">Izaberite sliku:</label>
		      <div class="input-group">
		          <label class="input-group-btn">
		              <span class="btn btn-primary">
		                  Browse&hellip; <input type="file" name="slika_add" id="new_ppkat" style="display: none;">
		               </span>
		          </label>
		          <input type="text" class="form-control" readonly>
		      </div><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="20480"><br>
            <button type="submit" class="btn btn-info" name="add_new" >Dodajte pod-podkategoriju</button>
      		<button type="reset" class="btn btn-warning pull-right">Obriši sve</button>
            </form>
		</div>
    </div>
    <?php
    //Izmena ppkategorije
    if(isset($_POST['izmena_ppkategorije'])){
	    $izmena_ppkategorija_change = $conn->prepare("UPDATE ppkategorija SET ime_ppkat= :ime_ppkate , opis_ppkat= :opis_ppkate, id_pkat= :id_pkat WHERE id_ppkat= :id_ppkat_izmena");
	    $izmena_ppkategorija_change->bindParam(':id_ppkat_izmena', $_POST['id_ppkat_izmena'], PDO::PARAM_INT); 
	    $izmena_ppkategorija_change->bindParam(':ime_ppkate', $_POST['ime_ppkat'], PDO::PARAM_STR);  
	    $izmena_ppkategorija_change->bindParam(':opis_ppkate', $_POST['opis_ppkat'], PDO::PARAM_STR); 
	    $izmena_ppkategorija_change->bindParam(':id_pkat', $_POST['promeni_ppkategoriju'], PDO::PARAM_STR);
	    $izmena_ppkategorija_change->execute();
	    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/podpodkategorije"</script>'; 	
    }
    //BRISANJE KATEGORIJE
    if(isset($_POST['obrisi_ppkategoriju'])){
      $provera_proiz = $conn->prepare("SELECT * FROM proizvod WHERE id_ppkat= :id_ppkat");
      $provera_proiz->bindParam(':id_ppkat', $_POST['id_ppkat_izmena'], PDO::PARAM_INT); 
      $provera_proiz->execute();
      if(count($provera_proiz) > 0){
        $promeni_id_ppkat = $conn->prepare("UPDATE proizvod SET id_ppkat ='0'  WHERE id_ppkat= :id_ppkat");
        $promeni_id_ppkat->bindParam(':id_ppkat', $_POST['id_ppkat_izmena'], PDO::PARAM_INT);
        $promeni_id_ppkat->execute();
      }
      $obrisi_pkategoriju_delete = $conn->prepare("DELETE FROM ppkategorija where id_ppkat = :id_ppkat");
      $obrisi_pkategoriju_delete->bindParam(':id_ppkat', $_POST['id_ppkat_izmena'], PDO::PARAM_INT); 
      $obrisi_pkategoriju_delete->execute();
      unlink("../".$_POST['slika_ppkat_brisanje']);
      echo '<script type="text/javascript">window.location = "'.$url.'upravljac/podpodkategorije"</script>';
    }
    //Dodavanje nove ppkategorije
    if(isset($_POST['add_new'])){
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
  $upfile = '../images/pp_kat/'.$_POST['naslov_add'].$b;
  $up_file = 'images/pp_kat/'.$_POST['naslov_add'].$b;
  if ( is_uploaded_file ($_FILES ['slika_add']['tmp_name'])){
     if ( !move_uploaded_file ($_FILES ['slika_add']['tmp_name'], $upfile)){
        echo greska('Problem','Nije premestena slika u sajt');
        exit;
     }
  }else{
     echo greska('Problem','Nismo ucitali sliku pod nazivom:'.$_FILES ['slika_add']['name']);
     exit;
  }
    $kategorija_add_new = $conn->prepare("INSERT INTO ppkategorija (id_ppkat, ime_ppkat, slika_ppkat, opis_ppkat, id_pkat) VALUES (NULL , :naslov_add, :slika_add, :opis_add, :id_pkat)");
    $kategorija_add_new->bindParam(':naslov_add', $_POST['naslov_add'], PDO::PARAM_STR);  
    $kategorija_add_new->bindParam(':opis_add', $_POST['opis_add'], PDO::PARAM_STR);   
    $kategorija_add_new->bindParam(':id_pkat', $_POST['id_pkat_new'], PDO::PARAM_STR);   
    $kategorija_add_new->bindParam(':slika_add', $up_file, PDO::PARAM_STR);  
    $kategorija_add_new->execute();
    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/podpodkategorije"</script>';
    }
    //IZMENA SLIKE
          if(isset($_POST['izmena_slike'])){
            unlink("../".$_POST['slika_kat_brisanje_izmena']);
            if ($_FILES ['ppkat_izmena_slike']['error'] > 0){
             switch ($_FILES ['ppkat_izmena_slike']['error']){
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
          if ($_FILES ['ppkat_izmena_slike']['size'] > 1048576*$max_vrednost) { echo greska('Problem','Slika je prevelika pokusajte ponovo'); exit;}
          if ($_FILES ['ppkat_izmena_slike']['type']=='image/jpeg'){ $a="ok"; $b=".jpg";}
          if ($_FILES ['ppkat_izmena_slike']['type']=='image/png'){ $a="ok"; $b=".png";}
          if ($a!="ok"){ echo greska('Problem','Problem: slika nije u okviru ponudjenih formata jpg i png, pokusajte ponovo'); exit;}
          $upfile = '../images/pp_kat/'.$_POST['slika_kat_ime'].$b;
          $up_file = 'images/pp_kat/'.$_POST['slika_kat_ime'].$b;  
            if ( is_uploaded_file ($_FILES ['ppkat_izmena_slike']['tmp_name'])){

             if (!move_uploaded_file ($_FILES ['ppkat_izmena_slike']['tmp_name'], $upfile)){
                echo greska('Problem','Nije premestena slika u sajt');
                exit;
             }

          }else{
             echo greska('Problem','Nismo ucitali sliku pod nazivom:'.$_FILES ['ppkat_izmena_slike']['name']);
             exit;
          }
          $izmena_slike = $conn->prepare("UPDATE ppkategorija SET slika_ppkat= :slika_ppkate WHERE id_ppkat= :id_ppkat_izmenas");
          $izmena_slike->bindParam(':slika_ppkate', $up_file, PDO::PARAM_STR);  
          $izmena_slike->bindParam(':id_ppkat_izmenas', $_POST['slika_ppkat_id'], PDO::PARAM_STR);
          $izmena_slike->execute();
          echo '<script type="text/javascript">window.location = "'.$url.'upravljac/podpodkategorije"</script>';
          }
    ?>
</div>