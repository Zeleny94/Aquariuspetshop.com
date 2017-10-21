          <div class="col-md-2">
                <div class="list-group sidebar-2">
<?php
                $desni_sidebar = $conn->prepare("select * from kat_pkat where id_kat = :idkate");
                $desni_sidebar->execute(array(':idkate' => $desni_sidebar_kategorija));
                $desni_brojac = 1;
                $broj = $desni_sidebar->rowCount();
                while($desni_sidebar_output = $desni_sidebar->fetch()){
                  if($desni_brojac == 1){
                  echo '<p class="lead">'.$desni_sidebar_output['ime_kat'].'</p><div>';
                  }
                  
                  $link_desne_kategorije = new linkovanje();
                  $desna_kateg = $link_desne_kategorije->getA($url.$desni_sidebar_output['ime_kat'].'/'.$desni_sidebar_output['ime_pkat'].'/'.$desni_sidebar_output['id_pkat'],"desna-slika",$desni_sidebar_output['ime_pkat']);
                  $desna_slika = $link_desne_kategorije->getIMG("img-responsive slika-mala",$url.$desni_sidebar_output['ime_kat'].'/'.$desni_sidebar_output['ime_pkat'].'/'.$desni_sidebar_output['id_pkat'],$url.$desni_sidebar_output['slika_pkat'],$desni_sidebar_output['ime_pkat']);

                  echo $desna_slika.$desna_kateg;
                  if($broj > $desni_brojac){
                    echo '<hr style="margin:8px;border-top:1px solid #2990c7;">';
                  }
                    ++$desni_brojac;
                  }

                    ?>
                </div>
</div>
            </div>