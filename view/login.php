<main>
  <div class="container py-5 form40">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="form-group">
        <label for="exampleAddress">Email-Adresse</label>
        <small class="form-text text-danger mt-0 mb-2">
          <?php echo $emailError ?? ""; ?>
        </small>
        <input type="email" id="exampleAddress" class="form-control" name="email_address" aria-describedby="email address" required>
        <small id="emailHelp" class="form-text text-muted">Wir geben Ihre Email-Adresse nicht an Dritte weiter.</small>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <small class="form-text text-danger mt-0 mb-2">
          <?php echo $passwordError ?? ""; ?>
        </small>
        <input type="password" id="password" class="form-control" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Anmelden</button>
      <small class="form-text mt-3">
        <a href="<?php echo $indexPath; ?>/forgotpassword" id="forgotPassword">Passwort vergessen?</a>
      </small>
    </form>
  </div>
</main>