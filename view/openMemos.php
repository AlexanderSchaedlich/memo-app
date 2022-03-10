<?php  
  var_dump($test);
?>
<main>
  <div class="container py-5">
    <div id="cards" class="d-flex justify-content-center flex-column align-items-center">
<?php 
  if (empty($openMemos)) {
?>
    <h4>Es gibt noch keine Notizen.</h4>
    <h4>Sei der Erste, der eine öffentliche Notiz erstellt!</h4>
<?php
  } else {
    // try to set locale to german and use utf-8
    setlocale(LC_ALL, "de_DE@euro.utf-8", "de.utf-8", "de_DE.utf-8", "de.utf-8", "deu.utf-8", "ge.utf-8", "german.utf-8", "germany.utf-8", "0");
    // setlocale(LC_ALL, "de.utf-8", "de_DE@euro", "de_DE", "de", "deu", "ge", "german", "germany", "0");
    foreach ($openMemos as $memo) {
      // merge the full name
      $memo["name"] = $memo["first_name"] . " " . $memo["last_name"];
      // create a nice date format
      $memo["date"] = strftime("%A, den %d. %B %Y", strtotime($memo["date"]));
?>
      <div>
        <!--cards-->
        <div class="card my-4 shadow">
            <div class="card-header d-flex justify-content-between">
              <div>
                <h6 class="mt-0 mb-2">
                  <?php echo $memo["name"]; ?>
                </h6>
                <p class="mb-0">
                  <?php echo $memo["date"]; ?>
                </p>
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
      </div>
<?php
    }
  }
?>
    </div>
  </div>
</main>