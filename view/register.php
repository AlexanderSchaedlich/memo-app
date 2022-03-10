<main>
  <div class="container p-5 my-5 shadow form40">
<?php 
  if (! empty($errorMessage)) {
?>
    <p class="pb-4 text-center text-danger">
      <?php echo $errorMessage; ?>
    </p>
<?php  
  } 

  if (! is_null($emailWasSent)) {
    if ($emailWasSent) {
?>
    <p class="pb-4 text-center text-success">Bitte prüfen Sie Ihr Postfach und gegebenenfalls den Spam-Ordner. Wir haben Ihnen eine Mail mit einem Link für die Aktivierung Ihres Kontos geschickt.</p>
<?php  
    } else {
?>
    <p class="pb-4 text-center text-danger">Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.</p>
<?php  
    }
  }
?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group">
        <label for="firstName">Vorname</label>
        <input type="text" id="firstName" class="form-control" name="first_name" aria-describedby="first name" required>
      </div>
      <div class="form-group">
        <label for="lastName">Nachname</label>
        <input type="text" id="lastName" class="form-control" name="last_name" aria-describedby="last name" required>
      </div>
        <div class="form-group">
          <label for="emailAddress">Email-Adresse</label>
          <small class="form-text text-danger mt-0 mb-2">
            <?php echo $emailError ?? ""; ?>
          </small>
          <input type="email" id="emailAddress" class="form-control" name="email_address" aria-describedby="email address" required>
          <small id="emailHelp" class="form-text text-muted">Wir geben Ihre Email-Adresse nicht an Dritte weiter.</small>
        </div>
        <div class="form-group">
          <label for="password">Passwort</label>
          <small class="generatePassword form-text text-warning mt-0 mb-2">Passwort generieren</small> 
          <small class="form-text text-danger mt-0 mb-2">
            <?php echo $passwordError ?? ""; ?>
          </small>
          <input type="password" id="password" class="form-control d-inline w-auto" name="password" required>
          <i class="far fa-eye toggleEye"></i>
          <i class="far fa-eye-slash toggleEye"></i>
        </div>
        <button type="submit" class="btn btn-primary">Registrieren</button>
    </form>
  </div>
</main>
<script src="../ajax/functions.js"></script>
<script src="../ajax/generatePassword.js"></script>
