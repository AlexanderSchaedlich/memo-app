<main>
  <div class="container py-5 form40">
    <p class="form-text text-danger mt-0 mb-2"><?php echo (!is_null($author) && ! $author) || (! is_null($author) && $author && ! $passwordWasUpdated) ? "Es ist ein Fehler aufgetreten. Bitte versuchen Sie es später noch einmal." : ""; ?></p> 
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group">
        <label for="password">Neues Passwort</label>
        <small class="generatePassword form-text text-warning mt-0 mb-2">Passwort generieren</small> 
        <small class="form-text text-danger mt-0 mb-2"><?php echo ! is_null($isLongEnough) && ! $isLongEnough ? "Das Passwort muss mindestens sechs Zeichen lang sein." : ""; ?></small>        
        <small class="form-text text-danger mt-0 mb-2"><?php echo ! is_null($containsSpecialCharacters) && ! $containsSpecialCharacters ? "Das Passwort muss mindestens ein Sonderzeichen enthalten." : ""; ?></small> 
        <input type="password" id="password" class="form-control d-inline w-auto" name="password" aria-describedby="password" required>
        <i class="far fa-eye toggleEye"></i>
        <i class="far fa-eye-slash toggleEye"></i>
      </div>
      <button type="submit" class="btn btn-primary">Setzen</button>
    </form>
  </div>
</main>
<script src="../ajax/functions.js"></script>
<script src="../ajax/generatePassword.js"></script>