<?php
//Navigator - PODKATEGORJA
echo '<p class="kategorija-navigator">';
$navigator_proiz = $conn->prepare("select * from kat_pkat_ppkat_proiz where id_proiz = :idproiz");
$navigator_proiz->execute(array(':idproiz' => $_GET['id_proiz']));
    while($navigator_proiz_output = $navigator_proiz->fetch()){
        $link_navigator_proizvod = new linkovanje();
        $navigator_pr = $link_navigator_proizvod->getA($url,"","početna").' &rArr; ';
        $navigator_pr.= $link_navigator_proizvod->getA($url.$navigator_proiz_output['id_kat'].'/'.$navigator_proiz_output['ime_kat'],"",$navigator_proiz_output['ime_kat']).' &rArr; ';
        $navigator_pr.= $link_navigator_proizvod->getA($url.$navigator_proiz_output[ime_kat].'/'.$navigator_proiz_output[ime_pkat].'/'.$navigator_proiz_output['id_pkat'],"",$navigator_proiz_output['ime_pkat']).' &rArr; ';
        $navigator_pr.=$link_navigator_proizvod->getA($url.$navigator_proiz_output['ime_kat'].'/'.$navigator_proiz_output['ime_pkat'].'/'.$navigator_proiz_output['id_ppkat'].'/'.$navigator_proiz_output['ime_ppkat'], "", $navigator_proiz_output['ime_ppkat']).' &rArr; ';
        $navigator_pr.=$link_navigator_proizvod->getA($url.$navigator_proiz_output['ime_kat'].'/'.$navigator_proiz_output['ime_pkat'].'/'.$navigator_proiz_output['ime_ppkat'].'/'.$navigator_proiz_output['id_proiz'].'/'.$navigator_proiz_output['ime_proiz'],"",$navigator_proiz_output['ime_proiz']);
        echo $navigator_pr;
                                }
echo '</p>';
//Kraj navigatora
    $proizvod_pregled = $conn->prepare("select * from kat_pkat_ppkat_proiz where id_proiz = :idproiz");
    $proizvod_pregled->execute(array(':idproiz' => $_GET['id_proiz']));
    while($proizvod_pregled_output = $proizvod_pregled->fetch()){
        echo '<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header h1-proizvod pull-left">'.$proizvod_pregled_output['ime_proiz'].'</h1>
                <div class="cena-proizvoda pull-right">';
                if(!empty($proizvod_pregled_output['cena_proiz'])){
                echo $proizvod_pregled_output['cena_proiz'].''.$valuta;
                }elseif (empty($proizvod_pregled_output['cena_proiz'])) {
                    echo 'Pozovite ze cenu';
                }
                

                echo '</div>
            </div>
        </div>

        <!-- Portfolio Item Row -->
        <div class="row">

            <div class="col-md-4">
                <img class="img-responsive" src="'.$url.$proizvod_pregled_output['slika_proiz'].'" alt="'.$proizvod_pregled_output['ime_proiz'].'">
            </div>

            <div class="col-md-8">
                <h3 class="h3-opis-proizvoda">Opis proizvoda</h3>
                <p>'.$proizvod_pregled_output['opis_proiz'].'</p>
            </div>

        </div>

        ';
    }
