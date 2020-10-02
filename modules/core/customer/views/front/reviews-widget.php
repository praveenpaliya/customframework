<div class="row">
    <div class="textimonial">
        <div class="testimonial slider">
            <?php
            foreach ($this->arrayData as $objReviews) {
            ?>
                <div class="slide">
                  <p><?php echo $objReviews->review;?></p>
                  <p class="testititle">- <?php echo $objReviews->customer_name;?></p>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
   