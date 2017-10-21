<?php
  require_once("session.php");
  require_once("class.user.php");
  $user_id = $_SESSION['user_session'];
?>
    <div class="container-fluid" style="margin-top:80px;">
    <div class="container">
    <div class="col-lg-6">
    <div class="row">
    <hr>
      <h2>Pozadina sajta</h2>
      <hr>
    <?php
$brojac = 0;
$postavi_row = 3;
    foreach (glob("../images/dizajn/pozadina/*") as $filename)
{
	if ($brojac % $postavi_row == 0) {
      	echo '<div class="row">';
    }
	echo '<div class="col-md-4 col-sm-3 hero-feature"><div class="thumbnail" style="height:200px;">';	
    echo '<img width="150px" height="150px" src="'.$filename.'">';
   $array = explode('/',$filename); $count = count($array);
   echo '<div class="caption text-center" style="position: absolute;bottom: 15px;">';
   if($array[$count-1]==$background_image){
   	echo '<input type="submit" class="btn btn-success" value="Trenutna" disabled="disabled"><br>';
   }else{
  echo '<span class="pull-left">';
   echo '<form method="POST">';
  echo '<input type="hidden" name="background_image" value="'.$array[$count-1].'">  <input type="submit" class="btn btn-info" value="Promeni" onclick="return ';
           echo "confirm('Da li ste sigurni da želite da napravite promene?')";
           echo '">';
  echo '</form>';
  echo '</span>';
  echo '&nbsp;';
  echo '<span class="pull-right">';
  echo '<form method="POST">';
  echo '<input type="hidden" name="obrisi_sliku" value="'.$array[$count-1].'">  <input type="submit" class="btn btn-danger" value="Obrisi" onclick="return ';
           echo "confirm('Da li ste sigurni da želite da napravite promene?')";
           echo '">';
  echo '</form>';
  echo '</span>';
	}
	echo '</div></div></div>';
  if ($brojac % $postavi_row == ($postavi_row-1)) {
     echo '</div>';
  }
  ++$brojac;
}
  if ((($brojac-1) % $postavi_row) != ($postavi_row-1)) {
    echo '</div>';
  }          
	if(isset($_POST['background_image'])){
  	$promena_bg = $conn->prepare("UPDATE konfiguracija SET vrednost_konf= :vrednost WHERE ime_konf='background_image'");
  	$promena_bg->bindParam(':vrednost', $_POST['background_image'], PDO::PARAM_STR); 
  	$promena_bg->execute();
    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/pozadina"</script>';
	}
  if(isset($_POST['obrisi_sliku'])){
    unlink('../images/dizajn/pozadina/'.$_POST['obrisi_sliku']);
    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/pozadina"</script>';
  }
    ?>
      
        </div>
        </div>
            <div class="col-lg-5 pull-right">
        <div class="row">
        <hr>
        <h2>Dodajte novu pozadinu</h2>
        <hr>
        <form method="POST" enctype="multipart/form-data">
        <label for="slika_add">Izaberite željenu sliku:</label><br>
      <div class="input-group">
          <label class="input-group-btn">
              <span class="btn btn-primary">
                  Browse&hellip; <input type="file" name="slika_add" style="display: none;" accept=".jpeg, .jpg, .png">
               </span>
          </label>
          <input type="text" class="form-control" readonly>
      </div><br>
      <input type="hidden" name="MAX_FILE_SIZE" value="20480">
      <button type="submit" name="nova_pozadina" class="btn btn-info">Dodaj novu pozadinu</button>
    </form>
       
        </div>
        </div>
    </div>
</div>
 <?php
         if(isset($_POST['nova_pozadina'])){
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
          if ($_FILES ['slika_add']['size'] > 1048576*3) { echo greska('Problem','Slika je prevelika pokusajte ponovo'); exit;}
          if ($_FILES ['slika_add']['type']=='image/jpeg'){ $a="ok"; $b=".jpg";}
          if ($_FILES ['slika_add']['type']=='image/png'){ $a="ok"; $b=".png";}
          if ($a!="ok"){ echo greska('Problem','Problem: slika nije u okviru ponudjenih formata jpg i png, pokusajte ponovo'); exit;}
          $upfile = '../images/dizajn/pozadina/'.$_FILES['slika_add']['name'].$b;  
            if ( is_uploaded_file ($_FILES ['slika_add']['tmp_name'])){

             if (!move_uploaded_file ($_FILES ['slika_add']['tmp_name'], $upfile)){
                echo greska('Problem','Nije premestena slika u sajt');
                exit;
             }

          }else{
             echo greska('Problem','Nismo ucitali sliku pod nazivom:'.$_FILES ['kat_izmena_slike']['name']);
             exit;
          }
    echo '<script type="text/javascript">window.location = "'.$url.'upravljac/pozadina"</script>';
        }
        ?>