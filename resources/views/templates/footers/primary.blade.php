<?php

use App\Libraries\HeaderFunctions;

$headerFunctions = new HeaderFunctions();
?>
<footer class="mainFooter">
    <div class="innerFooter container">
        <div class="row">
            <div class="leftNavigation col col-lg-8">
                <div class="row">
                    <?php
                        $categories = $headerFunctions->returnCategories();

                        // Display categories
                        foreach($categories as $category)
                        {
                            // Make sure its a nav link
                            if($category['display_nav'] == 1)
                            {
                            ?>
                            <div class="linkHold col-lg-3">
                                <h3><?php echo $category['name']; ?></h3>
                                <ul>
                                    
                                    <li><a href="">Sub-Category</a></li>
                                </ul>
                            </div><br />
                            <?php
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="logoRight col col-lg-4">
                <div style="display: none;" class="image"></div>
            </div>
        </div>
    </div>
</footer>
<div class="copyright">
    <h4>Copyright &copy; AEP 2021</h4>
</div>