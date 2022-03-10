<?php 
  if (! empty($author)) {
?>
<main>
  <div class="container p-5 my-5 shadow form40">
    <h5 class="pb-4 text-center">Persönliche Daten</h5>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
      <div class="form-group">
        <label for="firstName">Vorname</label>
        <input type="text" id="firstName" class="form-control" name="first_name" aria-describedby="first name" value="<?php echo $author["first_name"]; ?>" required>
      </div>
      <div class="form-group">
        <label for="lastName">Nachname</label>
        <input type="text" id="lastName" class="form-control" name="last_name" aria-describedby="last name" value="<?php echo $author["last_name"]; ?>" required>
      </div>
      <div class="form-group">
        <label for="emailAddress" class="mb-0">Email-Adresse</label>
        <small class="form-text text-danger mt-0 mb-2">
<?php 
    if (! is_null($emailAddressExists) && $emailAddressExists) {
?>
        Es ist bereits ein Benutzer mit dieser Email-Adresse registriert.
<?php 
    } 
?>
        </small>
        <input type="email" id="emailAddress" class="form-control" name="email_address" aria-describedby="email address" value="<?php echo $author["email_address"]; ?>" required>
      </div>
      <div class="form-group">
        <label for="password" class="mb-0">Passwort*</label>
        <small class="form-text text-danger mt-0 mb-2">
          <?php echo $passwordError ?? ""; ?>
        </small>
        <input type="password" id="password" class="form-control" name="password" aria-describedby="password">
        <small class="form-text text-muted">
          * Füllen Sie dieses Feld aus, wenn Sie Ihr Passwort ändern möchten.
        </small>
      </div>
      <button type="submit" class="btn btn-primary mt-2">Aktualisieren</button>
<?php 
    if (! is_null($updatedAuthor)) { 
      if ($updatedAuthor) {
?>
      <small class="form-text text-success mt-0 mt-2">
        Ihre persönlichen Daten wurden aktualisiert.
      </small>
<?php 
      } else { 
?>
      <small class="form-text text-danger mt-0 mt-2">
        Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal.
      </small>
<?php 
      } 
    }
?>
    </form>
    <small id="userDeleteAccount" class="form-text text-muted mt-3">
      Konto löschen
    </small>
  </div>
</main>
<script src="<?php echo $path; ?>/ajax/functions.js"></script>
<script src="<?php echo $path; ?>/ajax/account.js"></script>
<?php  
  }
?>