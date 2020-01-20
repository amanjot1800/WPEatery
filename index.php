<?php include "header.php"; ?>
<?php include "menuItem.php"; ?>

			<?php

					$stars = "*";
					$menuItems = array();
					$i = 1;
					while ($i < 5) {


						if (!($i%2==0)){
							$menuItems[$i-1] = new MenuItem("The WP Burger $stars$i", "Freshly made all-beef patty served up with homefries", 14);
						}
						else {
                            $menuItems[$i-1] = new MenuItem("WP Kebabs $stars$i", "Tender cuts of beef and chicken, served with your choice of side", 17);
                        }

                        $stars .= "*";
						$i++;

					}
?>
				
				
				
                <aside>
                        <h2><?php echo date("l") . "'s" ?> Specials</h2>
                        <hr>
                        <img src="images/burger_small.jpg" alt="Burger" title="Monday's Special - Burger">
                        <h3><?php echo $menuItems[0]->get_itemName(); ?></h3>
                        <p><?php echo $menuItems[0]->get_description() . " - $" . $menuItems[0]->get_price() ?>  </p>
                        <hr>
                        <img src="images/kebobs.jpg" alt="Kebobs" title="WP Kebobs">
                        <h3><?php echo $menuItems[1]->get_itemName(); ?></h3>
                        <p><?php echo $menuItems[1]->get_description() . " - " . $menuItems[1]->get_price() ?>  </p>
                        <hr>
						<img src="images/burger_small.jpg" alt="Burger" title="Monday's Special - Burger">
                        <h3><?php echo $menuItems[2]->get_itemName(); ?></h3>
                        <p><?php echo $menuItems[2]->get_description() . " - " . $menuItems[2]->get_price() ?>  </p>
                        <hr>
						<img src="images/kebobs.jpg" alt="Kebobs" title="WP Kebobs">
                        <h3><?php echo $menuItems[3]->get_itemName(); ?></h3>
                        <p><?php echo $menuItems[3]->get_description() . " - " . $menuItems[3]->get_price() ?>  </p>
                        <hr>
						
                </aside>
                <div class="main">
                    <h1>Welcome</h1>
                    <img src="images/dining_room.jpg" alt="Dining Room" title="The WP Eatery Dining Room" class="content_pic">
                    <p>Lorem ipsum dolor sit amet, lollipopp adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    <h2>Book your Christmas Party !</h2>
                    <p>Lorem ipsum dolor sit hmat, lollipopp adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    <p>Lorem ipsum dolor sit amet, lollipopp adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                </div><!-- End Main -->
			
			
			
<?php include "footer.php" ?>