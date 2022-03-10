<main>
  <div class="container py-5 form40">
<?php  
  if ($emailWasSent) {
?>
    <p class="text-success mb-3">Bitte prüfen Sie Ihr Postfach und gegebenenfalls den Spam-Ordner. Wir haben Ihnen eine Mail mit einem Link zum Zurücksetzen des Passworts geschickt.</p> 
    <a href="<?php echo $indexPath; ?>/login" class="btn btn-primary">Zur Anmeldung</a>
<?php  
  } else {
    if (! is_null($emailWasSent)) {
?>
    <p class="text-danger">Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.</p> 
<?php  
    }
?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group">
        <label for="exampleAddress">Bitte geben Sie Ihre Email-Adresse ein.</label>
        <small class="form-text text-danger mt-0 mb-2"><?php echo ! is_null($isRegistered) && ! $isRegistered ? "Es ist kein Benutzer mit dieser Email-Adresse registriert." : ""; ?></small> 
        <input type="email" id="exampleAddress" class="form-control" name="email_address" aria-describedby="email address" required>
      </div>
      <button type="submit" class="btn btn-primary">Link anfordern</button>
    </form>
<?php  
  }
?>
  </div>
</main>