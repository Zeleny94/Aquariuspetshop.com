<?php
//Navigator - KATEGORJA
echo '<p class="kategorija-navigator">';
$navigator = $conn->prepare("select * from kategorija where id_kat = :idkat");
$navigator->execute(array(':idkat' => $_GET['id_kat']));
    while($navigator_output = $navigator->fetch()){        
        $link_navigator_kategorija = new linkovanje();
        $navigator_k = $link_navigator_kategorija->getA($url,"","početna").' &rArr; ';
        $navigator_k.= $link_navigator_kategorija->getA($url.$navigator_output['id_kat'].'/'.$navigator_output['ime_kat'],"",$navigator_output['ime_kat']);
        echo $navigator_k;
                            }
echo '</p>';
//Kraj navigatora
//Pocetak liste proizvoda u toj podkategoriji
$lista_kategorija = $conn->prepare("select * from kat_pkat where id_kat = :idkat");
$lista_kategorija->execute(array(':idkat' => $_GET['id_kat']));
$brojac = 0;
$postavi_row = 3;
    while($lista_kategorija_output = $lista_kategorija->fetch()){
      $link_kategorije = new linkovanje();
      $href_katg = $url.$lista_kategorija_output['ime_kat'].'/'.$lista_kategorija_output['ime_pkat'].'/'.$lista_kategorija_output['id_pkat'];
      $ime_kateg = $link_kategorije->getA($href_katg,"",$lista_kategorija_output['ime_pkat']);
      $ime_kateg_slika = $link_kategorije->getIMG("img-responsive slika-mala",$href_katg,$url.$lista_kategorija_output['slika_pkat'],$lista_kategorija_output['ime_pkat']);
      if ($brojac % $postavi_row == 0) {
        echo '<div class="row">';
    }
      echo '<div class="col-md-4 portfolio-item">
                '.$ime_kateg_slika.'
                <h3>
                    '.$ime_kateg.'
                </h3>
                <p></p>
               </div>';
               if ($brojac % $postavi_row == ($postavi_row-1)) {
            echo '</div>';
          } 
               ++$brojac;
           }
           if ((($brojac-1) % $postavi_row) != ($postavi_row-1)) {
            echo '</div>';
          }
          