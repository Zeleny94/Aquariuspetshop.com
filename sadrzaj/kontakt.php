  <?php
  $x = rand(1,20);
  $y = rand(1,20);
    if (isset($_POST["submit"])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $z = $_POST['x'] + $_POST['y'];
        $human = intval($_POST['human']);
        $from = 'Kontakt sa sajta'; 
        $to = $kontakt_email;
        $subject = 'Poruka sa sajta ';
        
        $body = "Od: $name\n E-Mail: $email\n Poruka:\n $message";
 
        // Check if name has been entered
        if (!$_POST['name']) {
            $errName = 'Molimo vas unesite vase ime';
        }
        
        // Check if email has been entered and is valid
        if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errEmail = 'Molimo unesite ispravnu email adresu';
        }
        
        //Check if message has been entered
        if (!$_POST['message']) {
            $errMessage = 'Molimo unesite Vasu poruku';
        }
        //Check if simple anti-bot test is correct
        if ($human !== $z) {
            $errHuman = 'Molimo ponovo izracunajte dati iznos';
        }
 
// If there are no errors, send the email
if (!$errName && !$errEmail && !$errMessage && !$errHuman) {
    if (mail ($to, $subject, $body, $from)) {
        $result='<div class="alert alert-success">Uskoro cemo vas kontaktirati!</div>';
    } else {
        $result='<div class="alert alert-danger">Doslo je do greske prilikom slanja poruke, molimo pokusajte ponovo!</div>';
    }
}
    }

?>
  <div class="row">
        <div class="col-md-12">
           
        <form class="form-horizontal" role="form" method="post">

        <legend class="text-center header">Kontaktirajte nas</legend>
         <?php echo $result; ?>
    <div class="form-group">
        <div class="col-sm-12">
       <label for="name" class="control-label">Unesite vase ime</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Ime i prezime" value="<?php echo htmlspecialchars($_POST['name']); ?>">
            <?php echo "<p class='text-danger'>$errName</p>";?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
       <label for="email" class="control-label">Unesite vasu email adresu</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="primer@gmail.com" value="<?php echo htmlspecialchars($_POST['email']); ?>">
            <?php echo "<p class='text-danger'>$errEmail</p>";?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
       <label for="message" class="control-label">Vasa poruka</label>
            <textarea class="form-control" rows="4" name="message"><?php echo htmlspecialchars($_POST['message']);?></textarea>
            <?php echo "<p class='text-danger'>$errMessage</p>";?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <label for="human" class="control-label"><? echo $x.' + '.$y; ?> = ?</label>
            <input type="hidden" class="form-control" id="x" name="x" value="<? echo $x; ?>">
            <input type="hidden" class="form-control" id="y" name="y" value="<? echo $y; ?>">
            <input type="text" class="form-control" id="human" name="human" placeholder="Vas odgovor?">
            <?php echo "<p class='text-danger'>$errHuman</p>";?>
        </div>
    </div>
    <div class="form-group">

        <div class="col-sm-12 col-sm-offset-5">
            <input id="submit" name="submit" type="submit" value="Posalji" class="btn btn-primary">
        </div>
    </div>

</form> 
        </div>
    </div>



<style>


    .header {
        color: #36A0FF;
        height: 70px;
        font-size: 27px;
        padding: 10px;
    }
</style>
