<?php
session_start();
session_destroy();

echo "<script>
alert('Logout Sukses');
location.href='../index.php';
</script>";

?>