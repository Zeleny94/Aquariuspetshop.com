<h1 class="akcije-naslov lead">Trenutne akcije</h1>
<hr>
<?php
//Pocetak liste ppkatvoda u toj podkategoriji
$lista_akcija = $conn->prepare("SELECT * FROM  `akcije`");
$lista_akcija->execute();
$brojac = 0;
$postavi_row = 3;
    while($lista_akcija_output = $lista_akcija->fetch()){
      if($lista_akcija_output['status']=='1'){
        $link_pkatv = new linkovanje();
        $href_pkatg = $url.'akcija/'.$lista_akcija_output['id_akcije'].'/'.$lista_akcija_output['naslov_akcije'];
        $naslov_pkatv = $link_pkatv->getA($href_pkatg,"imena-href",$lista_akcija_output['naslov_akcije']);
        $opsirnije = $link_pkatv->getA($href_pkatg,"imena-href","OPŠIRNIJE");
        $pkatv_slika = $link_pkatv->getIMG("img-responsive slika-mala",$href_pkatg,$url.$lista_akcija_output['slika'],$lista_akcija_output['naslov_akcije']);
              if ($brojac % $postavi_row == 0) {
        echo '<div class="row">';
    }
        echo '<div class="col-md-4 portfolio-item">'.$pkatv_slika.'<h4>'.$naslov_pkatv.' - '.$lista_akcija_output['cena_akcije'].'</h4><p>'.substr(opis($lista_akcija_output['opis']), 0, 100).'...'.$opsirnije.'</p></div>';
               if ($brojac % $postavi_row == ($postavi_row-1)) {
            echo '</div>';
          } 
               ++$brojac;
               }
           }
           if(!$lista_akcija->rowCount() == 0){
           if ((($brojac-1) % $postavi_row) != ($postavi_row-1)) {
            echo '</div>';
          }
        }
          