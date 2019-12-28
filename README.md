Yii2 DEMO Bank System
===================

Customers can invest at different rates

------------

Installation
----------------

Clone this project 

```
$ https://github.com/yashuk803/test_bank
```

Usage
----------------
At start enter in root folder of application
```
cd test_bank/

$ cp .env.test .env.local
$ cp /config/db_test.php /config/db.php
```

Run command:

```
$ docker-compose up -d --build
```

Run migration:

```
$ docker exec -it IDcontainer bash
php yii migrate

```

Set Cron:

```
$ crontab -e
0 1 /1 * * http://<host>/site/run-cron
```

Contacts: yashuk803@gmail.com

Copyright (c) 2019, Mariia Tarantsova
