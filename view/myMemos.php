<main>
  <div class="container py-5">
    <div id="cards" class="d-flex flex-column justify-content-center align-items-center">
<?php 
  if (empty($myMemos)) {
?>
    <h4 id="noPrivateMemos">Sie haben noch keine Notizen erstellt.</h4>
<?php
  } else {
    // try to set locale to german and use utf-8
    setlocale(LC_ALL, "de.utf-8", "de_DE@euro.utf-8", "de_DE.utf-8", "de", "deu.utf-8", "ge.utf-8", "german.utf-8", "germany.utf-8", "0");
    foreach ($myMemos as $memo) {
      // create a nice date format
      $memo["styled_date"] = strftime("%A, den %d. %B %Y", strtotime($memo["date"]));
      $selectedPrivate = "selected";
      $selectedPublic = "";
      $visibility = "Privat";

      if ($memo["visibility"] == "public") {
        $selectedPrivate = "";
        $selectedPublic = "selected";
        $visibility = "Öffentlich";
      }
?>
      <div>
        <!--card-->
        <div class="card my-4 shadow" data-date="<?php echo $memo['date']; ?>">
          <div class="card-header d-flex justify-content-between">
            <div>
              <p class="card-date mt-0 mb-2">
                <?php echo $memo["styled_date"]; ?>
              </p>
              <p class="card-visibility mb-0">
                <?php echo $visibility; ?>
              </p>
            </div>
            <div class="buttonsParent">
              <button class="btn btn-primary mr-1" type="button" name="button" data-toggle="modal" data-target=".bd-example-modal-lg<?php echo $memo["id"]; ?>">Ändern</button>
              <button class="delete btn btn-primary" type="button" data-date="<?php echo $memo['date']; ?>">Löschen</button>
            </div>
          </div>
          <div class="card-body">
            <h5 class="card-title">
              <?php echo $memo["title"]; ?>
            </h5>
            <p class="card-text">
              <?php echo $memo["text"]; ?>
            </p>
          </div>
        </div>
        <!-- large modal -->
        <div class="modal fade bd-example-modal-lg<?php echo $memo["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <p class="message mb-0 p-2 text-center"></p>
              <form class="updateMemo mt-1 p-4 shadow d-flex justify-content-center flex-column align-items-center" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $memo["id"]; ?>">
                <input type="hidden" name="date" value="<?php echo $memo["date"]; ?>">
                <input class="d-block inputWidth pl-4" type="text" name="title" value="<?php echo $memo["title"]; ?>">
                <textarea class="inputWidth mt-4" rows="4" cols="50" name="text"><?php echo $memo["text"]; ?></textarea>
                <select class="m-4" name="visibility">
                  <option <?php echo $selectedPrivate; ?> value="private">Private Notiz</option>
                  <option <?php echo $selectedPublic; ?> value="public">Öffentliche Notiz</option>
                </select>
                <button class="btn btn-primary my-3 inputWidth" type="button" name="submit">Speichern</button>
              </form>
              <button type="button" class="btn btn-primary modalClose" data-dismiss="modal">Schließen</button>
            </div>
          </div>
        </div>
      </div>
<?php
    }
  }
?>
    </div>
    <p id="newMemoMessage" class="mt-5 text-center"></p>
    <form id="createMemo" class="pt-3 pb-4 d-flex justify-content-center flex-column align-items-center" action="javascript:void(0);">
      <input class="d-block inputWidth pl-4" type="text" placeholder="Titel" name="title">
      <textarea class="inputWidth mt-4" placeholder="Schreiben Sie Ihre Notiz..." name="text"></textarea>
      <select class="m-4" name="visibility">
        <option selected value="private">Private Notiz</option>
        <option value="public">Öffentliche Notiz</option>
      </select>
      <button class="btn btn-primary my-3 inputWidth" type="button" name="submit">Erstellen</button>
    </form>
  </div>
</main>
<script src="../ajax/functions.js"></script>
<script src="../ajax/myMemos.js"></script>