opencart-shipping-cost-by-category
==================================

Opencart module to calculate shipping cost by category. 

opencart-shipping-cost-by-category plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

opencart-shipping-cost-by-category plugin is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with opencart-shipping-cost-by-category plugin. If not, see <http://www.gnu.org/licenses/>.

Description 
==================================

This plugin will allow admin user to set a fixed cost for each category. The total shipping cost is the minimum of the cost of each category, once for each category in the cart.

For example, if a client has 3 product in cart as follows:
product A category A
product B category A
product C category B

The costs are:
3 category A
5 category B

The total shipping cost will be 5.

Install
==================================

Extract/add files to proper filepath:
	admin/controller/shipping/category.php
	admin/language/italian/shipping/category.php
	admin/view/template/shipping/category.tpl
	catalog/model/shipping/category.php
	catalog/language/italian/shipping/category.php
	catalog/language/english/shipping/category.php

Modify MySQL DB:
	INSERT INTO <PREFIX>_extension (`type`, `code`) VALUES ('shipping', 'category');

Access OpenCart admin backend:
	Give permission to system -> user groups -> top admin ->  */category (ie: to all entries with category)
	Set costs by category in extensions -> shipping -> fixed cost by category

Changelog
==================================

2014-01-06 -> Initial release.
