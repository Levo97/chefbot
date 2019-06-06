<?php

session_start();

session_unset();

session_destroy();
?>
<script>window.location.href = 'index.php?out=1';</script>