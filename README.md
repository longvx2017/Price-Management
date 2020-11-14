# Price Management

## Requirement
As a Project Manager, I want to build a price management module for Magento 2.4.x which the
Administrator can use to schedule the special price for different customers.

Expected criteria :

● It should be new logic (not catalog nor sales price rules, not default special price etc)

● The price should be able to set for a specific product and a specific customer i.e the
administrator can choose any product, any schedule to set a price for the customer.

● Administrators should be able to schedule special prices for each customer. (You can
use configuration)

● After customer login, he should be able to see the special price set for him within that
schedule.


Notes:
- Please send your answer via link on github
- Please submit your assignment by 12pm Thursday 12 Nov 2020
- Don't hesitate to contact me if you have any questions
- Please make sure that you will not invest more than 8hours to research, architect and
develop for this feature as we dont want to abuse your valuable time.

## Installation

- Download the module from Github:

https://github.com/longvx2017/Price-Management

- Extract and copy the folders and files to the folder:

```bash
[your-magento-root-folder]\app\code\Shopstack\PriceManagement
```

- Go to Magento root folder and run below commands:

```bash
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy en_US
bin/magento cache:flush
```

- Installed successfully!
