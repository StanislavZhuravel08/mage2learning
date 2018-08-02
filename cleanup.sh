#!/usr/bin/env bash
mysql -ushops -pshops shops -e "DROP TABLE IF EXISTS mage_recently_visited_categories;"
mysql -ushops -pshops shops -e "DELETE FROM mage_setup_module WHERE module = 'Stanislavz_CurrentCategory';"
php bin/magento cache:clean
php bin/magento setup:upgrade