<?php
  require_once("session.php");
  require_once("class.user.php");
  $user_id = $_SESSION['user_session'];
?>
    <div class="container-fluid" style="margin-top:80px;">
    	<div class="container">
    		<h2>Profil - <?php echo $userRow['user_name']; ?></h2>
    		<hr>
    		<div class="col-lg-4">
    			<p>Promena osnovnih podataka</p>
    			<form method="POST">
    			<label for="user_name">Korisnicko ime:</label><br />
    			<div class="input-group">
    				<input class="form-control" type="text" name="user_name" value="<?php echo $userRow['user_name']; ?>"><br />
    				<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
    			</div>
    			<label for="user_email">E-mail:</label>
    			<div class="input-group">
    				<input class="form-control" type="text" name="user_email" value="<?php echo $userRow['user_email']; ?>">
    				<span class="input-group-addon">@</span>
    			</div><br />
    			<button class="btn btn-info" name="sacuvaj_podatke" type="submit">Sacuvaj</button>
    			</form>
    		</div>
    		<div class="col-lg-4">
    			<p>Promena korisnicke lozinke</p>
    			<form method="POST" role="form" data-toggle="validator" id="myForm">
    			<label for="user_pass">Stara lozinka:</label><br />
    			<div class="input-group">
    			<input class="form-control" type="password" name="user_pass" placeholder="Unesite staru lozinku" required>
    				<span class="input-group-addon">#</span>
    			</div><br />
    			<label for="user_pass_new">Nova lozinka:</label><br />
    			<div class="input-group">
    			<input class="form-control" data-minlength="6" type="password" name="user_pass_new" id="user_pass_new" onchange="form.user_pass_new_ch.pattern = this.value;" placeholder="Unesite vasu novu lozinku" required>
    				<span class="input-group-addon">#</span>    				
    			</div>
    			<div class="help-block">Minimalno 6 karaktera</div>
    			<label for="user_pass_new_ch">Potvrdite vasu lozinku:</label><br />
    			<div class="input-group">
    			<input class="form-control" type="password" name="user_pass_new_ch" data-match="#user_pass_new" data-match-error="Lozinke se ne poklapaju" placeholder="Ponovo unesite vasu novu lozinku" required>
    				<span class="input-group-addon">#</span>
    			</div>
    			<div class="help-block with-errors"></div>
    			<button class="btn btn-info" name="promena_lozinke" type="submit">Promeni lozinku</button>
    			</form>
    		</div>
    	</div>
    </div>
<?php
	if(isset($_POST['sacuvaj_podatke'])){
		$podatci_up = $conn->prepare("UPDATE users SET user_name= :user_name, user_email= :user_email WHERE user_id= :user_id");
		$podatci_up->bindParam(':user_name', $_POST['user_name'], PDO::PARAM_STR);
		$podatci_up->bindParam(':user_email', $_POST['user_email'], PDO::PARAM_STR);
		$podatci_up->bindParam(':user_id', $userRow['user_id'], PDO::PARAM_INT);
		$podatci_up->execute();
		echo '<script type="text/javascript">window.location = "'.$url.'upravljac/profil"</script>';
	}
	if(isset($_POST['promena_lozinke'])){
		$lozinka_up = $conn->prepare("SELECT * FROM users where user_id= :user_id");
		$lozinka_up->bindParam(':user_id', $userRow['user_id'], PDO::PARAM_STR);
		$lozinka_up->execute();
		while($lozinka_up_o=$lozinka_up->fetch()){
			if(password_verify($_POST['user_pass'], $lozinka_up_o['user_pass'])){
				if($_POST['user_pass_new']==$_POST['user_pass_new_ch']){
					$lozinka_hash = password_hash($_POST['user_pass_new'], PASSWORD_DEFAULT);
					$lozinka_promena=$conn->prepare("UPDATE users SET user_pass= :user_pass WHERE user_id= :user_id");
					$lozinka_promena->bindParam(':user_pass', $lozinka_hash, PDO::PARAM_STR);
					$lozinka_promena->bindParam(':user_id', $userRow['user_id'], PDO::PARAM_INT);
					$lozinka_promena->execute();
					echo '<script type="text/javascript">window.location = "'.$url.'upravljac/logout.php?logout=true"</script>';
				}else{
					greska("Lozinke", "se ne poklapaju");
				}
			}else{
				greska("Vasa","stara lozinka nije lepo ukucana, pokusajte ponovo!");
			}
		}
	}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<script type="text/javascript">
	$('#myForm').validator()
</script>