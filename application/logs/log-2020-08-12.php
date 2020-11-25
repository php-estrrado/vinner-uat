<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-12 08:34:06 --> Severity: Warning --> Invalid argument supplied for foreach() /home/estrradodemo/public_html/vinner/application/views/back/admin/demo_request_list.php 3
ERROR - 2020-08-12 11:28:07 --> Query error: Column 'equipment' cannot be null - Invalid query: INSERT INTO `product` (`title`, `category`, `description`, `short_description`, `meta_description`, `product_type`, `sub_category`, `sale_price`, `purchase_price`, `add_timestamp`, `update_time`, `featured`, `status`, `rating_user`, `product_code`, `location`, `equipment`, `sub_equipment`, `item_type`, `shipping_info`, `moreinfo`, `type`, `alt_text`, `return_policy`, `request_demo`, `tax_type`, `shipping_cost`, `tag`, `num_of_imgs`, `current_stock`, `front_image`, `unit`, `model`, `sku`, `mpn`, `length`, `width`, `height`, `length_class_id`, `weight`, `weight_class_id`, `admin_approved`, `vendor_approved`, `request_quote`, `dg`, `added_by`) VALUES ('test prod1', '1', '<p><br></p>', '', '', 'New', '1', '3000', '3500', 1597208287, 1597208287, '0', 'ok', '[]', 'prod1', '0', NULL, NULL, '0', NULL, NULL, 'single', '', '', 0, 'percent', 0, '', 1, 0, NULL, 'BOX', 'm1', '', '', '2', '1', '1', '1', '3', '1', 1, 1, NULL, '0', '{\"type\":\"admin\",\"id\":\"1\"}')
ERROR - 2020-08-12 12:19:49 --> The path to the image is not correct.
ERROR - 2020-08-12 12:19:49 --> Your server does not support the GD function required to process this type of image.
ERROR - 2020-08-12 13:08:10 --> Query error: Table 'estrrado_vinner.product_price_request' doesn't exist - Invalid query: SELECT `R`.*, `P`.`title`, `P`.`product_code`, `V`.`name`
FROM `product_price_request` as `R`
JOIN `product` as `P` ON `R`.`prd_id` = `P`.`product_id`
JOIN `vendor` as `V` ON `R`.`vendor_id` = `V`.`vendor_id`
ORDER BY `R`.`status`
ERROR - 2020-08-12 13:08:10 --> Severity: error --> Exception: Call to a member function result() on boolean /home/estrradodemo/public_html/vinner/application/models/admin/Warehouses.php 15
