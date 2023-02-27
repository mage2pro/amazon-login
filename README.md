The «[**Login with Amazon**](https://mage2.pro/c/extensions/amazon-login)» single sign-on module for Magento 2 securely connect your store with millions of Amazon customers and personalize their experience: http://login.amazon.com  
The module is **free** and **open source**.

## Screenshots
### 1. 
![](https://mage2.pro/uploads/default/original/2X/2/2c3e3073289bc0ee0c80eaa217be7735eb399551.png)

### 2. 
![](https://mage2.pro/uploads/default/original/2X/6/679e9ef696c4bde6be46139f4cf63e06eccbf039.png)

### 3. 
![](https://mage2.pro/uploads/default/original/2X/e/e0e4295451fa19baae7334fd29671a23b7e3a1f2.png)

### 4. 
![](https://mage2.pro/uploads/default/original/2X/2/299efa13397dbd002906a69169ff4579b7700ff9.png)

### 5. 
![](https://mage2.pro/uploads/default/original/2X/b/b21603a287477486339b2bd1b9689e12def2c3e5.png)

### 6. Registration page
![](https://mage2.pro/uploads/default/original/2X/4/4e38de6aeb6b825ff2a346e4bb3661153b481e74.png)

### 7. Login page 
![](https://mage2.pro/uploads/default/original/2X/7/7ecf0e27e2474041f7e50eaf9dba9a28b91c033f.png)

### 8. Backend settings 
![](https://mage2.pro/uploads/default/original/2X/e/e0ce28ea6326ddaa18f87d0e24f5cc8a302e7f4d.png)

## How to install
[Hire me in Upwork](https://upwork.com/fl/mage2pro), and I will: 
- install and configure the module properly on your website
- answer your questions
- solve compatiblity problems with third-party checkout, shipping, marketing modules
- implement new features you need 

### 2. Self-installation
```
bin/magento maintenance:enable
rm -f composer.lock
composer clear-cache
composer require mage2pro/amazon-login:*
bin/magento setup:upgrade
bin/magento cache:enable
rm -rf var/di var/generation generated/code
bin/magento setup:di:compile
rm -rf pub/static/*
bin/magento setup:static-content:deploy -f en_US <additional locales>
bin/magento maintenance:disable
```

## How to update
```
bin/magento maintenance:enable
composer remove mage2pro/amazon-login
rm -f composer.lock
composer clear-cache
composer require mage2pro/amazon-login:*
bin/magento setup:upgrade
bin/magento cache:enable
rm -rf var/di var/generation generated/code
bin/magento setup:di:compile
rm -rf pub/static/*
bin/magento setup:static-content:deploy -f en_US <additional locales>
bin/magento maintenance:disable
```