<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4
 *  @Info : https://www.clicshopping.org/forum/trademark/
 *
 */

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\HTML;
?>
<div class="col-md-<?php echo $content_width . ' ' . $position; ?>">
  <div class="separator"></div>
  <div class="sitemapCategoryTreeTittleCategories"><h3><?php echo CLICSHOPPING::getDef('modules_sitemap_tree_categories_box_heading_categories'); ?></h3></div>
  <div class="SitemapCategoryTreeBlockCategories">
    <div class="SitemapCategoryTreeCategories">
      <i class="fas fa-home fa-2x"></i>&nbsp;<?php echo HTML::link(CLICSHOPPING::link(), CLICSHOPPING::getDef('modules_sitemap_tree_categories_header_title_top')); ?>
      <?php echo $CLICSHOPPING_CategoryTree->getTree(); ?>
    </div>
  </div>
</div>