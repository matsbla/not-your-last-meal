<!DOCTYPE HTML>
<?php

include_once 'templates/layout.php';

?>

<title>Not your last meal</title>

<?php  if (isset($_SESSION['username'])) : ?>
<div id="profile-wrapper">
   <div id="user-profile">User profile</div>
   <div id="user-picture"><img src="user-picture" alt="pic"></div>
   <div id="user-name"><?php echo $_SESSION['username']; ?></div>
   <strong>
      <div id="user-email">user@gmail.com</div>
   </strong>
   <div id="user-alergies">
      List of alergies
      <p>Food</p>
      <p>Food</p>
      <p>Food</p>
   </div>
   <div id="user-about">
      <p>Info about user</p>
   </div>
</div>
