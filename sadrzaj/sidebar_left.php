<div class="col-md-3"> 
	<div class="list-group kategorija">
		<p class="akcije-naslov"><a class="akcije-naslov" href="<?php echo $url.'akcije'; ?>">Trenutne akcije</a></p>
		<hr style="margin:0;">
		<?php
		
			$akcije_prikaz = $conn->query("SELECT * FROM akcije WHERE status='1'");
			$akcije_prikaz->execute();
			while($akcije_prikaz_o=$akcije_prikaz->fetch()){
				$link_levo = new linkovanje();
				$link_akcije = $link_levo->getA($url.'akcija/'.$akcije_prikaz_o['id_akcije'].'/'.$akcije_prikaz_o['naslov_akcije'],"",$akcije_prikaz_o['naslov_akcije']);
				$opsirnije = $link_levo->getA($url.'akcija/'.$akcije_prikaz_o['id_akcije'].'/'.$akcije_prikaz_o['naslov_akcije'],"","opširnije");

				$slika_akcija = $link_levo->getIMG("img-responsive",$url.'akcija/'.$akcije_prikaz_o['id_akcije'].'/'.$akcije_prikaz_o['naslov_akcije'],$url.$akcije_prikaz_o['slika'],$akcije_prikaz_o['naslov_akcije']);
				echo '<div>';
				echo $slika_akcija.$link_akcije.' '.$akcije_prikaz_o['cena_akcije'].$valuta;			
				echo '<br><p class="small">'.opis(substr($akcije_prikaz_o['opis'], 0, 115)).'...'.$opsirnije.'</p>';
				echo '</div>';
							}
							
		?>
	</div>
</div>