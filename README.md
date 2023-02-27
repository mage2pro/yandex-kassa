The module integrates a Magento 2 based webstore with the **[Yandex.Kassa](https://checkout.yandex.com)** (as known as Yandex.Checkout, Яндекс.Касса) payment service (Russia).  
Yandex.Kassa is used by **[30% of Russian webstores](https://mage2.pro/t/topic/3716)** (2017).  
Yandex.Kassa also works in Armenia, Azerbaijan, Belarus, Georgia, Kazakhstan, Kyrgyzstan, Latvia, Moldova, Tajikistan.  
The module is **free** and **open source**.

## [Screenshots](https://mage2.pro/tags/yandex-kassa-screenshot)
- The frontend checkout screen:
    - [in the «**images**» mode](https://mage2.pro/t/topic/4562)
    - [in the «**text**» mode](https://mage2.pro/t/topic/4559)
- [The backend settings](https://mage2.pro/t/topic/4498)
- The user interfaces for a payment:
  - [bank card](https://mage2.pro/t/topic/4597)
- A payment confirmation to a customer:
  - [in the Yandex.Kassa interface](https://mage2.pro/t/topic/4619)
  - [by email](https://mage2.pro/t/topic/4622)

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
composer require mage2pro/yandex-kassa:*
bin/magento setup:upgrade
bin/magento cache:enable
rm -rf var/di var/generation generated/code
bin/magento setup:di:compile
rm -rf pub/static/*
bin/magento setup:static-content:deploy -f ru_RU en_US <additional locales, e.g.: kk_KZ>
bin/magento maintenance:disable
```


## How to update
```
bin/magento maintenance:enable
composer remove mage2pro/yandex-kassa
rm -f composer.lock
composer clear-cache
composer require mage2pro/yandex-kassa:*
bin/magento setup:upgrade
bin/magento cache:enable
rm -rf var/di var/generation generated/code
bin/magento setup:di:compile
rm -rf pub/static/*
bin/magento setup:static-content:deploy -f ru_RU en_US <additional locales, e.g.: kk_KZ>
bin/magento maintenance:disable
```

