<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
    <div class="sidebar-brand-icon">
      <img src="<?=base_url('assets/backend/') ?>img/logoBwt.jpeg" width="50">
    </div>
    <div class="sidebar-brand-text mx-2">SDS Barunawati IV</div>
  </a>

  <hr class="sidebar-divider mt-0">
  
  <?php $role_id = $this->session->userdata('role_id');

    $queryMenu = "SELECT user_menu.id, menu
      FROM user_menu JOIN user_access_menu
      ON user_menu.id = user_access_menu.menu_id
      WHERE user_access_menu.role_id = $role_id
      ORDER BY user_menu.numrow ASC";

    $menus = $this->db->query($queryMenu)->result_array() ?>

  <!-- Heading -->
  <?php foreach($menus as $menu) : ?>
    <div class="sidebar-heading">
      <?=$menu['menu'] ?>
    </div>

    <!-- Sub Menu -->
    <?php $menu_id = $menu['id'];
    $querySubMenu = "SELECT *
        FROM user_submenu
        WHERE menu_id = $menu_id 
        AND is_active = 1";

    $submenus = $this->db->query($querySubMenu)->result_array(); ?>

    <?php foreach($submenus as $submenu) : ?>
      <li class="nav-item <?=($title == $submenu['title'] ? 'active' : '') ?>">
        
        <?php $link = $submenu['url']; ?>

        <a class="nav-link" href="<?=site_url($link) ?>">
          <i class="<?=$submenu['icon'] ?>"></i>
          <span><?=$submenu['title'] ?></span></a>
      </li>
    <?php endforeach ?>
    <!-- Divider -->
    <hr class="sidebar-divider mt-3">
  <?php endforeach ?>

  <li class="nav-item">
    <?php if($this->session->userdata('role_id') == 3) {
      $logout = 'logout';
    } else {
      $logout = 'administrador/auth/logout';
    } ?>
    <a class="nav-link" href="<?=site_url($logout) ?>">
      <i class="fas fa-fw fa-sign-out-alt"></i>
      <span>Logout</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">
  <div class="version" id="version-ruangadmin"></div>
</ul>