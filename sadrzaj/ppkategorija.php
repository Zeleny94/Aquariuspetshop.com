<?php
$strana = $_GET['strana'];
$strana_pre = $_GET['strana']-1;
$strana_posle = $_GET['strana']+1;
$ukupno_upit = $conn->prepare("SELECT count(*) FROM proizvod WHERE id_ppkat = :idppkatt"); 
$ukupno_upit->execute(array(':idppkatt' => $_GET['id_ppkat']));
$ukupno = $ukupno_upit->fetchColumn(); 
$broj_po_strani = (int)$broj_ppkat_po_strani;
$broj_strana=ceil($ukupno/$broj_po_strani); 

if(isset($_GET['strana']) and is_numeric($_GET['strana'])) { //u slucaju da je neko dosao prvi put. Proveramo da li postoji $_GET['strana']. Ako ne postoji to znaci da je tek dosao na prikaz.
    $tekuci_korisnik=$_GET['strana'];
} else {
    $tekuci_korisnik=1; //vraca mu se na prvu stranu. Ili je pocetna strana 1 ili je ona koji je neko izabrao.
}
$pocetni_proizvod=($tekuci_korisnik-1)*$broj_po_strani;//izracunavanje pocetnog proizvoda. Putem formule.
        if($broj_strana<@$_GET['strana']) { 
                echo "ALO 404!";
        } else {

//Navigator - PODPODKATEGORJA
echo '<p class="kategorija-navigator">';
$navigator_ppkat = $conn->prepare("select * from kat_pkat_ppkat where id_ppkat = :idppkat");
$navigator_ppkat->execute(array(':idppkat' => $_GET['id_ppkat']));
    while($navigator_ppkat_output = $navigator_ppkat->fetch()){
        $link_navigator_ppodkategorija = new linkovanje();
        $uzimanje_linka_za_stranu = $url.$navigator_ppkat_output[ime_kat].'/'.$navigator_ppkat_output[ime_pkat].'/'.$navigator_ppkat_output['id_ppkat'].'/'.$navigator_ppkat_output['ime_ppkat'];
        $navigator_ppk = $link_navigator_ppodkategorija->getA($url,"","početna").' &rArr; ';
        $navigator_ppk.= $link_navigator_ppodkategorija->getA($url.$navigator_ppkat_output['id_kat'].'/'.$navigator_ppkat_output['ime_kat'],"",$navigator_ppkat_output['ime_kat']).' &rArr; ';
        $navigator_ppk.= $link_navigator_ppodkategorija->getA($url.$navigator_ppkat_output[ime_kat].'/'.$navigator_ppkat_output[ime_pkat].'/'.$navigator_ppkat_output['id_pkat'],"",$navigator_ppkat_output['ime_pkat']).' &rArr; ';
        $navigator_ppk.= $link_navigator_ppodkategorija->getA($url.$navigator_ppkat_output[ime_kat].'/'.$navigator_ppkat_output[ime_pkat].'/'.$navigator_ppkat_output['id_ppkat'].'/'.$navigator_ppkat_output['ime_ppkat'],"",$navigator_ppkat_output['ime_ppkat']);
        echo $navigator_ppk;
                                }
echo '</p>';
//Kraj navigatora
//Pocetak liste ppkatvoda u toj podkategoriji
$lista_ppkatvoda = $conn->prepare("select * from kat_pkat_ppkat_proiz where id_ppkat = :idppkat order by id_proiz desc LIMIT :pocetni_proizvod , :broj_po_strani");
$lista_ppkatvoda->bindParam(':idppkat', $_GET['id_ppkat'], PDO::PARAM_INT);
$lista_ppkatvoda->bindParam(':pocetni_proizvod', $pocetni_proizvod, PDO::PARAM_INT);
$lista_ppkatvoda->bindParam(':broj_po_strani', $broj_po_strani, PDO::PARAM_INT);
$lista_ppkatvoda->execute();
$brojac = 0;
$postavi_row = 3;
    while($lista_ppkatvoda_output = $lista_ppkatvoda->fetch()){
    $link_ppkatv = new linkovanje();
    $href_ppkatv = $url.$lista_ppkatvoda_output['ime_kat'].'/'.$lista_ppkatvoda_output['ime_pkat'].'/'.$lista_ppkatvoda_output['ime_ppkat'].'/'.$lista_ppkatvoda_output['id_proiz'].'/'.$lista_ppkatvoda_output['ime_proiz'];
    $link_ppkatg = $link_ppkatv->getA($href_ppkatv, "", $lista_ppkatvoda_output['ime_proiz']);
    $ppkatv_slika = $link_ppkatv->getIMG("img-responsive slika-mala",$href_ppkatv,$url.$lista_ppkatvoda_output['slika_proiz'],$lista_ppkatvoda_output['ime_proiz']);
              if ($brojac % $postavi_row == 0) {
        echo '<div class="row">';
    }
        echo '<div class="col-md-4 portfolio-item">
                '.$ppkatv_slika.'
                <h3>';
                echo $link_ppkatg.'
                    
                </h3>
                <p>'.substr($lista_ppkatvoda_output['opis_proiz'], 0, 100).'...'.$link_ppkatv->getA($url.$lista_ppkatvoda_output['ime_kat'].'/'.$lista_ppkatvoda_output['ime_pkat'].'/'.$lista_ppkatvoda_output['ime_ppkat'].'/'.$lista_ppkatvoda_output['id_proiz'].'/'.$lista_ppkatvoda_output['ime_proiz'], "", "Opširnije").'</p>
               </div>';
               if ($brojac % $postavi_row == ($postavi_row-1)) {
            echo '</div>';
          } 
               ++$brojac;
           }
           if ((($brojac-1) % $postavi_row) != ($postavi_row-1)) {
            echo '</div>';
          }
if($ukupno>$broj_po_strani){

    echo '
        <div class="row">
            <div class="col-lg-12">
            <div class="text-center">
                <ul class="pagination ">';
                $link_nova_klasa = new linkovanje();
                $link_za_stranu = $link_nova_klasa->getLink($uzimanje_linka_za_stranu);
                if(isset($_GET['strana']) AND $_GET['strana']!='1') {
    echo '<li><a href="'.$link_za_stranu.'/1"><span aria-hidden="true">&#9664;</span></a></li>';
} 
if(isset($_GET['strana']) AND $_GET['strana']!='1') {
    echo '<li><a href="'.$link_za_stranu.'/'.$strana_pre.'"><span aria-hidden="true">&#9665;</span></a></li>';
} 

        for ($i=1;$i<=$broj_strana;++$i) { //ispisujemo od 1 do maximalnog broja strana
         echo '<li';    
         if($tekuci_korisnik==$i) {
        echo ' class="active" ';
        
        } else {
            echo ' ';
            }
 echo '>';
        echo '<a href="'.$link_za_stranu.'/'; echo $i; echo '">'; echo $i; echo '</a>'; //pravimo linkove koji ispisuju od 1 do maksimalnog broja strana. Ali takodje prosledjuje $_GET['strana'] koja u sebi sadrzi broj strana
        echo '</li>';
    }
    if($_GET['strana']!=$broj_strana) { 
    echo '<li><a href="'.$link_za_stranu.'/';
    if(isset($_GET['strana'])) {
    echo $strana_posle;
} else {
    echo '2';
}
    echo '">  <span aria-hidden="true">&#9655;</span></a></li>';
    }
    if($_GET['strana']<$broj_strana) {
    
    echo '<li><a href="'.$link_za_stranu.'/'.$broj_strana.'"><span aria-hidden="true">&#9654;</span></a></li>';
    }
    echo '</ul></div></div></div>';
    }
    }