<div class="row">
    <div class="col-xs-12 col-sm-12">
    <?php
    $num1 = rand(1,9);
    $num2 = rand(1,20);
    $_SESSION['captcha_sum'] = $num1 + $num2;

    $content = $this->postedData['content'];
    ISP ::parseContent($content);
    ?>
    </div>
    <div class="col-xs-12 col-sm-12">

        <div class="row">
            
            <div class="col-xs-12 col-sm-6" style="float:none; margin: 0 auto;">
                <div class="error col-xs-12"><?php echo mainframe::showError(); ?></div>
                <div class="error col-xs-12"><?php echo mainframe::showSuccess(); ?></div>
                <form method="post" class="col-md-12 nopadding" action="<?php echo SITE_URL . 'pages/saveContactus'; ?>">
                    <p>
                        <input type="text" class="form-control" name="md_contact_name" required placeholder="Name">
                    </p>
                    
                    <p>
                        <input type="text" class="form-control" name="md_contact_email" required placeholder="Email">
                    </p>
                    <p>
                        <input type="text" class="form-control" name="md_contact_number" required placeholder="Phone">
                    </p>
                    <p>
                        <textarea class="form-control" name="md_contact_message" required placeholder="Message"></textarea>
                    </p>

                    <p class="form-group">
                        <img src="<?php echo SITE_URL;?>captcha.php" class="captcha_image">
                        <input type="text" class="form-control" name="captcha" required placeholder="Security Code">
                    </p>

                    <p>
                        <!--<input type="text" value="Send Message" class="btn">-->
                        <button type="submit" value="exit" name="saveexit" class="btn btn-default"><?php echo $this->__aT('Send Message'); ?></button>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<!--END CONTACT US PAGE START HERE-->