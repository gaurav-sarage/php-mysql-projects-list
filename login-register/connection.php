<?php

  $conn = mysqli_connect("localhost", "root", "", "table");

  if (mysqli_connect_error()) {
    echo"<script>alert('cannot connect to the database')</script>";
    exit();
  }

?>