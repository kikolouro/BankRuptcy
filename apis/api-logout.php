<?php
session_start();
session_destroy();
echo '<meta http-equiv="refresh" content="0.10;url=index.php" />';
header('Location: index.php');