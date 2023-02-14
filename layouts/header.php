<?php 

    function active_nav(array $url) {
        foreach($url as $v) {
            if($v == str_replace('/election/', '' ,$_SERVER['PHP_SELF'])) {
                echo 'active';
            }else {
                echo '';
            }
        }
    }


?>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Election Cmtc</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-content">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav-content">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php if($_SESSION['user_role'] == 2) {?>
            <li class="nav-item">
                <a href="admin_index.php" class="nav-link <?= active_nav(['admin_index.php']) ?>">Home</a>
            </li>
            <li class="nav-item">
                <a href="admin_user.php" class="nav-link <?= active_nav(['admin_user.php']) ?>">Management User</a>
            </li>
            <li class="nav-item">
                <a href="admin_election.php" class="nav-link <?= active_nav(['admin_election.php']) ?>">Management Elector</a>
            </li>
        <?php } ?>
        <?php if($_SESSION['user_role'] == 1) {?>
            <li class="nav-item">
                <a href="elector_index.php" class="nav-link <?= active_nav(['elector_index.php']) ?>">Home</a>
            </li>
            <li class="nav-item">
                <a href="elector_profile.php" class="nav-link <?= active_nav(['elector_profile.php']) ?>">Profile</a>
            </li>
        <?php }?>
        <?php if($_SESSION['user_role'] == 0) {?>
            <li class="nav-item">
                <a href="user_index.php" class="nav-link <?= active_nav(['user_index.php']) ?>">Home</a>
            </li>
            <li class="nav-item">
                <a href="user_profile.php" class="nav-link <?= active_nav(['user_profile.php']) ?>">Profile</a>
            </li>
        <?php }?>
      </ul>
        <div class="d-flex" role="search">
            <a href="auth_logout.php" class="text-danger">Logout</a>
        </div>
    </div>
  </div>
</nav>