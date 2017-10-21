<?php
  require_once("session.php");
  require_once("class.user.php");
  $user_id = $_SESSION['user_session'];
?>
    <div class="container-fluid" style="margin-top:80px;">
    <div class="container">
<?php        
  $pregled_broja_proizvoda = $conn->query("select count(*) from proizvod")->fetchColumn();        
  $pregled_broja_kategorija = $conn->query("select count(*) from kategorija")->fetchColumn();        
  $pregled_broja_podkategorija = $conn->query("select count(*) from podkategorija")->fetchColumn();        
  $pregled_broja_podpodkategorija = $conn->query("select count(*) from ppkategorija")->fetchColumn();
  ?>
<div class="col-lg-3">
 <p>Broj kategorija: <?php echo $pregled_broja_kategorija; ?></p>
        <a href="kategorije#naslov_add" class="btn btn-info" role="button">Napravi novu</a> 
        <?php
        echo '<hr><p>Poslednje dodate kategorije</p><hr>';
        echo '<ul class="list-group">';
        $upit_za_poslednju_kat = $conn->query("SELECT * FROM kategorija ORDER BY id_kat DESC LIMIT 10");
        $upit_za_poslednju_kat->execute();
        while($upit_za_poslednju_kat_o=$upit_za_poslednju_kat->fetch()){
          echo '<li class="list-group-item"><span class="badge">'.$upit_za_poslednju_kat_o['id_kat'].'</span>'.$upit_za_poslednju_kat_o['ime_kat'].'</li>';
        }
        echo '</ul>';
        ?>
 </div>
 <div class="col-lg-3">
 <p>Broj podkategorija: <?php echo $pregled_broja_podkategorija; ?></p>
        <a href="podkategorije#naslov_add" class="btn btn-info" role="button">Napravi novu</a> 
        <?php
        echo '<hr><p>Poslednje dodate podkategorije</p><hr>';
        echo '<ul class="list-group">';
        $upit_za_poslednju_pkat = $conn->query("SELECT * FROM podkategorija ORDER BY id_pkat DESC LIMIT 10");
        $upit_za_poslednju_pkat->execute();
        while($upit_za_poslednju_pkat_o=$upit_za_poslednju_pkat->fetch()){
          echo '<li class="list-group-item"><span class="badge">'.$upit_za_poslednju_pkat_o['id_pkat'].'</span>'.$upit_za_poslednju_pkat_o['ime_pkat'].'</li>';
        }
        echo '</ul>';
        ?>
 </div>
 <div class="col-lg-3">
 <p>Broj pod-podkategorija: <?php echo $pregled_broja_podpodkategorija; ?></p> 
        <a href="podpodkategorije#naslov_add" class="btn btn-info" role="button">Napravi novu</a> 
        <?php
        echo '<hr><p>Poslednje dodate pod-podkategorije</p><hr>';
        echo '<ul class="list-group">';
        $upit_za_poslednju_ppkat = $conn->query("SELECT * FROM ppkategorija ORDER BY id_ppkat DESC LIMIT 10");
        $upit_za_poslednju_ppkat->execute();
        while($upit_za_poslednju_ppkat_o=$upit_za_poslednju_ppkat->fetch()){
          echo '<li class="list-group-item"><span class="badge">'.$upit_za_poslednju_ppkat_o['id_ppkat'].'</span>'.$upit_za_poslednju_ppkat_o['ime_ppkat'].'</li>';
        }
        echo '</ul>';
        ?>
 </div>
 <div class="col-lg-3">
 <p>Broj proizvoda: <?php echo $pregled_broja_proizvoda; ?></p>
        <a href="proizvodi#ime_add" class="btn btn-info" role="button">Napravi novi</a> 
        <?php
        echo '<hr><p>Poslednji dodati proizvodi</p><hr>';
        echo '<ul class="list-group">';
        $upit_za_poslednju_proiz = $conn->query("SELECT * FROM proizvod ORDER BY id_proiz DESC LIMIT 10");
        $upit_za_poslednju_proiz->execute();
        while($upit_za_poslednju_proiz_o=$upit_za_poslednju_proiz->fetch()){
          echo '<li class="list-group-item"><span class="badge">'.$upit_za_poslednju_proiz_o['id_proiz'].'</span>'.$upit_za_poslednju_proiz_o['ime_proiz'].'</li>';
        }
        echo '</ul>';
        ?>
 </div>
        <hr />
        
               
        
  
    
    </div>

</div>