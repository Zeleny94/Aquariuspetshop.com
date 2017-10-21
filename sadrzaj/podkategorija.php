<?php
//Navigator - PODKATEGORJA
echo '<p class="kategorija-navigator">';
$navigator_pkat = $conn->prepare("select * from kat_pkat where id_pkat = :idpkat");
$navigator_pkat->execute(array(':idpkat' => $_GET['id_pkat']));
    while($navigator_pkat_output = $navigator_pkat->fetch()){
        $link_navigator_podkategorija = new linkovanje();
        $navigator_pk = $link_navigator_podkategorija->getA($url,"","početna").' &rArr; ';
        $navigator_pk.= $link_navigator_podkategorija->getA($url.$navigator_pkat_output['id_kat'].'/'.$navigator_pkat_output['ime_kat'],"",$navigator_pkat_output['ime_kat']).' &rArr; ';
        $navigator_pk.= $link_navigator_podkategorija->getA($url.$navigator_pkat_output[ime_kat].'/'.$navigator_pkat_output[ime_pkat].'/'.$navigator_pkat_output['id_pkat'],"",$navigator_pkat_output['ime_pkat']);
        echo $navigator_pk;
                                }
echo '</p>';
//Kraj navigatora
//Pocetak liste ppkatvoda u toj podkategoriji
$lista_ppkatvoda = $conn->prepare("select * from kat_pkat_ppkat where id_pkat = :idpkat");
$lista_ppkatvoda->execute(array(':idpkat' => $_GET['id_pkat']));
$brojac = 0;
$postavi_row = 3;
    while($lista_ppkatvoda_output = $lista_ppkatvoda->fetch()){
        $link_pkatv = new linkovanje();
        $href_pkatg = $url.$lista_ppkatvoda_output['ime_kat'].'/'.$lista_ppkatvoda_output['ime_pkat'].'/'.$lista_ppkatvoda_output['id_ppkat'].'/'.$lista_ppkatvoda_output['ime_ppkat'];
        $naslov_pkatv = $link_pkatv->getA($href_pkatg,"",$lista_ppkatvoda_output['ime_ppkat']);
        $pkatv_slika = $link_pkatv->getIMG("img-responsive slika-mala",$href_pkatg,$url.$lista_ppkatvoda_output['slika_ppkat'],$lista_ppkatvoda_output['ime_ppkat']);
              if ($brojac % $postavi_row == 0) {
        echo '<div class="row">';
    }
    	echo '<div class="col-md-4 portfolio-item">
                '.$pkatv_slika.'
                <h4>';
                
                echo $naslov_pkatv.'
                    
                </h4>
               </div>';
               if ($brojac % $postavi_row == ($postavi_row-1)) {
            echo '</div>';
          } 
               ++$brojac;
           }
           if(!$lista_ppkatvoda->rowCount() == 0){
           if ((($brojac-1) % $postavi_row) != ($postavi_row-1)) {
            echo '</div>';
          }
        }
          