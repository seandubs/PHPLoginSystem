<?php
  include './header.php';


?>

  <section class="main-container">
    <div class="main-wrapper">
      <h2>Home</h2>
      <?php
        if(isset($_SESSION['u_id'])){
          echo "<p>You are logged in!</p>";
        }
      ?>
    </div>
  </section>

<?php
  include './footer.php';
?>
