<?php 
/**
 * Contains the javascripts the page needs.
 *
 * @package mna
 * @subpackage views
 */
?>
    <!-- Bootstrap core JavaScript -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- Custom Javascript -->
    <script src="<?php echo BASE_URL; ?>static/js/jquery.js"></script>
    <?php 
      if ($controller == 'admin') {
        ?>
        <!-- AdminLTE -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/js/app.min.js" integrity="sha256-eme2xNun7OtlBK9zw3ohsdkqhvczHIXXAkujb8r/YjY=" crossorigin="anonymous"></script>
        <?php
      }
    ?>
  </body>
</html>
