

                <div class="row main-pocetna">
<?php
                $postavi_row = 3;

                  $counter = 0;
                $pocetna_kategorija = $conn->prepare("select * from kategorija");
                $pocetna_kategorija->execute();
                while($pocetna_kategorija_output = $pocetna_kategorija->fetch()){
                  
                  $id_kat = (int)$pocetna_kategorija_output['id_kat'];
                  $pocetna_podkategorija = $conn->prepare("select * from kat_pkat where id_kat_pkat = :idkat");
                  $pocetna_podkategorija->bindParam(':idkat', $id_kat, PDO::PARAM_INT);
                  $pocetna_podkategorija->execute();
                  $brojac_pocetna = 0;
                  $brojac_pocetna2 = 0;
                  while ($pocetna_podkategorija_output = $pocetna_podkategorija->fetch()) {
                    $link_kategorije = new linkovanje();
                    $href_katg = $url.$pocetna_podkategorija_output['ime_kat'].'/'.$pocetna_podkategorija_output['ime_pkat'].'/'.$pocetna_podkategorija_output['id_pkat'];
                    $ime_kateg = $link_kategorije->getA($href_katg,"imena-href",$pocetna_podkategorija_output['ime_pkat']);
                    $ime_kateg_slika1 = $link_kategorije->getIMG("img-responsive slika-velika",$href_katg,$pocetna_podkategorija_output['slika_pkat'],$pocetna_podkategorija_output['ime_pkat']);
                    $ime_kateg_slika = $link_kategorije->getIMG("img-responsive slika-mala",$href_katg,$url.$pocetna_podkategorija_output['slika_pkat'],$pocetna_podkategorija_output['ime_pkat']);
                    if($brojac_pocetna==0){
                        if($counter==0){
                            echo ' <div class="col-md-12 glavni-pocetna">';
                        }else{
                            echo ' <div class="col-md-12 glavni-pocetna marr-top">';
                        }             
                  echo '<p class="lead">'.$pocetna_kategorija_output['ime_kat'].'</p><hr>';
                  echo '        '.$ime_kateg_slika1.'
                             <h3>
                                '.$ime_kateg.'
                             </h3></div>';
                              ++$counter;
              }else{
                 if ($brojac_pocetna2 % $postavi_row == 0) {
        echo '<div class="row row-pocetna">';
    }
                echo ' <div class="col-md-4">';
                 echo '         '.$ime_kateg_slika.'
                             <h3>
                               '.$ime_kateg.'
                             </h3></div>    ';
                             if ($brojac_pocetna2 % $postavi_row == ($postavi_row-1)) {
            echo '<!--KRAJ--></div><!--KRAJ-->';
          } 
                             ++$brojac_pocetna2;        
          }          
                         ++$brojac_pocetna;
                    }//Zatvaranje druge while petlje
                           if ((($brojac_pocetna2-1) % $postavi_row) != ($postavi_row-1)) {
            echo '<!--KRAJ--></div><!--KRAJ-->';
          }   
           }               
                    ?>
                </div><!--KRAJ POCETNE-->
                          

                 