<?php
$categories = $this->listAllActiveCategories(0);
?>
<div class="productsidebar">
  <h2><?php echo $this->__t('Category');?></h2>
  <ul>
  <?php
  foreach($categories as $objcategory) {
  ?>
    <li><a href="<?php echo $this->getUrl($this->category_url.$objcategory->category_id);?>"><?php echo $this->getCategoryAttributeValueModel($objcategory->category_id, 'cat_name');?></a></li>
  <?php
	}
	?>
  </ul>
</div>
