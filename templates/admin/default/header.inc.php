<header class="header sticky-top">
              <nav class="navbar navbar-light bg-white px-sm-4 ">
                <a class="navbar-brand py-2 d-md-none  m-0 material-icons toggle-sidebar" href="#">menu</a>
                <ul class="navbar-nav flex-row ml-auto">
                  
                  <li class="nav-item ml-sm-3 user-logedin dropdown">
                    <a href="#" id="userLogedinDropdown" data-toggle="dropdown" class="nav-link weight-400 dropdown-toggle"><img src="<?php echo SITE_URL;?>assets/img/icons/iconsweets/is/dark/single-user-small.png" class="mr-2 rounded">
                    	<?php 
                				$name = explode(" ", $_SESSION['adminLogin'][0]->name);
                				echo $name[0];
                			?>
             				 </span></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userLogedinDropdown">
                      <a class="dropdown-item" href="<?php echo mainframe::__adminBuildUrl('login/myProfile'); ?>">My Account</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="<?php echo mainframe::__adminBuildUrl('login/logoutadmin'); ?>">Log Out</a>
                    </div>
                  </li>
                  
                </ul>
              </nav>
            </header>


