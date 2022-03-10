<?php  
  if (! empty($authors)) {
?>
<main>
  <div class="container p-4 my-5 shadow">
    <table class="table m-0 p-2 table-responsive table-hover">
      <thead class="bg-primary text-white">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Vorname</th>
          <th scope="col">Nachname</th>
          <th scope="col">Email-Adresse</th>
          <th scope="col">Rolle</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
<?php  
    foreach ($authors as $author) {
      $selectedUser = "selected";
      $selectedAdmin = "";

      if ($author["role"] == "admin") {
        $selectedUser = "";
        $selectedAdmin = "selected";
      }
?>
        <tr data-id="<?php echo $author['id']; ?>">
          <form action="javascript:void(0);" class="updateAuthor mb-5">
            <th scope="row">
              <?php echo $author["id"]; ?>
              <input type="hidden" name="id" value="<?php echo $author['id']; ?>">
            </th>
            <td>
              <input type="text" name="first_name" value="<?php echo $author['first_name']; ?>" class="adminFirstName" required>
            </td>
            <td>
              <input type="text" name="last_name" value="<?php echo $author['last_name']; ?>" class="adminLastName" required>
            </td>
            <td>
              <?php echo $author['email_address']; ?>
              <input type="hidden" name="email_address" value="<?php echo $author['email_address']; ?>" required>
            </td>
            <td>
              <select name="role" class="mt-1">
                <option value="user" <?php echo $selectedUser; ?>>Benutzer</option>
                <option value="admin" <?php echo $selectedAdmin; ?>>Admin</option>
              </select>
            </td>
            <td>
              <button type="button" class="btn btn-primary save">Speichern</button>
            </td>
            <td>
              <button type="button" class="btn btn-primary delete" data-id="<?php echo $author['id']; ?>">Löschen</button>
            </td>
          </form>
        </tr>
  <?php  
    }
  ?>
      </tbody>
    </table>
  </div>
</main>
<script src="../ajax/functions.js"></script>
<script src="../ajax/adminDashboard.js"></script>
<?php  
  }
?>