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

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class si_sitemap_tree_categories {
    public $code;
    public $group;
    public string $title;
    public string $description;
    public ?int $sort_order = 0;
    public bool $enabled = false;

    public function __construct() {
      $this->code = get_class($this);
      $this->group = basename(__DIR__);

      $this->title = CLICSHOPPING::getDef('modules_sitemap_tree_categories_title');
      $this->description = CLICSHOPPING::getDef('modules_sitemap_tree_categories_description');

      if ( defined('MODULES_SITEMAP_TREE_CATEGORIES_STATUS')) {
        $this->sort_order = MODULES_SITEMAP_TREE_CATEGORIES_SORT_ORDER;
        $this->enabled = (MODULES_SITEMAP_TREE_CATEGORIES_STATUS == 'True');
      }
    }

    public function execute() {
      $content_width = (int)MODULES_SITEMAP_TREE_CATEGORIES_CONTENT_WIDTH;

      $position = MODULES_SITEMAP_TREE_CATEGORIES_POSITION;

      $CLICSHOPPING_CategoryTree = Registry::get('CategoryTree');
      $CLICSHOPPING_CategoryTree->reset();
      $CLICSHOPPING_Template = Registry::get('Template');
      $CLICSHOPPING_Category = Registry::get('Category');

// essentiel sinon conflit
      if (isset($_GET['SiteMap']))  {

        $sitemap_tree = '<!-- start sitemap_tree -->' . "\n";

        $CLICSHOPPING_CategoryTree->reset();
        $CLICSHOPPING_CategoryTree->setCategoryPath($CLICSHOPPING_Category->getPath(), '<strong>', '</strong>');
        $CLICSHOPPING_CategoryTree->setSpacerString('&nbsp;&nbsp;', 1);
        $CLICSHOPPING_CategoryTree->setFollowCategoryPath(false);
        $CLICSHOPPING_CategoryTree->setSpacerString('&nbsp;&nbsp;', 1);
        $CLICSHOPPING_CategoryTree->setParentGroupString('<ul class="list-group  list-group-SitemapTreeCategories">', '</ul>', true);
        $CLICSHOPPING_CategoryTree->setChildString('<li class="list-group-itemSitemapTreeCategories">', '</li>');

        ob_start();
        require_once($CLICSHOPPING_Template->getTemplateModules($this->group . '/content/sitemap_tree_categories'));

        $sitemap_tree .= ob_get_clean();

        $sitemap_tree .= '<!-- end sitemap_tree -->' . "\n";

        $CLICSHOPPING_Template->addBlock($sitemap_tree, $this->group);

      }

    } // end public function

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return defined('MODULES_SITEMAP_TREE_CATEGORIES_STATUS');
    }

    public function install() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Do you want to enable this module ?',
          'configuration_key' => 'MODULES_SITEMAP_TREE_CATEGORIES_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Do you want to enable this module in your shop ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Please select the width of the display?',
          'configuration_key' => 'MODULES_SITEMAP_TREE_CATEGORIES_CONTENT_WIDTH',
          'configuration_value' => '12',
          'configuration_description' => 'Please enter a number between 1 and 12',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_content_module_width_pull_down',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Where you want to display the sitemap ?',
          'configuration_key' => 'MODULES_SITEMAP_TREE_CATEGORIES_POSITION',
          'configuration_value' => 'float-none',
          'configuration_description' => 'Select where do you want to display the sitemap',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'float-start\', \'float-end\', \'float-none\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Sort order',
          'configuration_key' => 'MODULES_SITEMAP_TREE_CATEGORIES_SORT_ORDER',
          'configuration_value' => '110',
          'configuration_description' => 'Sort order of display. Lowest is displayed first. The sort order must be different on every module',
          'configuration_group_id' => '6',
          'sort_order' => '4',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );
    }

    public function remove() {
      return Registry::get('Db')->exec('delete from :table_configuration where configuration_key in ("' . implode('", "', $this->keys()) . '")');
    }

    public function keys() {
      return array('MODULES_SITEMAP_TREE_CATEGORIES_STATUS',
                   'MODULES_SITEMAP_TREE_CATEGORIES_CONTENT_WIDTH',
                   'MODULES_SITEMAP_TREE_CATEGORIES_POSITION',
                   'MODULES_SITEMAP_TREE_CATEGORIES_SORT_ORDER'
      );
    }
  }
