<section class="slidersection">
    <div class="container-fluid">
        <div class="row">
            <div class="sliderp slider">
            <?php
                foreach($this->slidesData as $slides) {
            ?>
                <div class="slide">
                    <img src="<?php echo SITE_URL.SITE_UPLOADPATH.$slides->slide_image;?>" alt="">
                    <div class="slidercontent">
                        <h2 class="wow fadeInUp animated"><?php echo $slides->slide_title;?></h2>
                        <p class="wow fadeInUp animated"><?php echo nl2br($slides->slide_text);?></p>
                    </div>
                </div>
            <?php
               }
            ?>
            </div>
        </div>
    </div>
</section>