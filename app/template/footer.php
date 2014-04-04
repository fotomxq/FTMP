<?php
if(isset($appPage) != true) die();
?>
<div id="footer">
  <div class="container">
    <p class="text-muted"><?php echo $webData['WEB-TITLE']; ?> &copy; 2014</p>
  </div>
</div>
<script src="../../includes/assets/js/jquery.js"></script>
<script src="../../includes/assets/js/bootstrap.js"></script>
<?php
if(isset($appPage['glob']) == true){
  if(isset($appPage['glob']['js']) == true){
    foreach($appPage['glob']['js'] as $v){
      echo '<script src="../../includes/assets/js/'.$v.'.js"></script>';
    }
  }
}
if(isset($appPage['temp']) == true){
  if(isset($appPage['temp']['js']) == true){
    foreach($appPage['temp']['js'] as $v){
      echo '<script src="../template/assets/js/'.$v.'.js"></script>';
    }
  }
}
if(isset($appPage['js']) == true){
	foreach($appPage['js'] as $v){
		echo '<script src="assets/js/'.$v.'.js"></script>';
	}
}
?>

</body>
</html>