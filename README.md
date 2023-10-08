Welcome to sportify-shop our new sport e-commerce.
We are delightful to afford you the access of the limitless sport.
To reach our goal we developped a sportify-shop website in two distinguished apps : 
- a [React application](https://github.com/sportify-shop/frontend)

  ![React](https://img.shields.io/badge/react-%2320232a.svg?style=for-the-badge&logo=react&logoColor=%2361DAFB) ![Typescript](https://img.shields.io/badge/TypeScript-007ACC?style=for-the-badge&logo=typescript&logoColor=white) ![Redux Toolkit](https://img.shields.io/badge/Redux-593D88?style=for-the-badge&logo=redux&logoColor=white) ![Material UI](https://img.shields.io/badge/Material%20UI-007FFF?style=for-the-badge&logo=mui&logoColor=white)

- linked to a [Symfony API](https://github.com/sportify-shop/backend) requesting a MySQL DataBase.
  
  ![Symfony](https://img.shields.io/badge/symfony-%23000000.svg?style=for-the-badge&logo=symfony&logoColor=white) ![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)

- Here are our ToolKit to manage our project : 

  ![Miro](https://img.shields.io/badge/Miro-F7C922?style=for-the-badge&logo=Miro&logoColor=050036) ![Trello](https://img.shields.io/badge/Trello-0052CC?style=for-the-badge&logo=trello&logoColor=white) ![Obsidian](https://img.shields.io/badge/Obsidian-483699?style=for-the-badge&logo=Obsidian&logoColor=white) ![Github](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white) ![Discord](https://img.shields.io/badge/Discord-5865F2?style=for-the-badge&logo=discord&logoColor=white)

## Quick Start
### Backend

At first, you must verify if you have all the requirements needed to run a symfony project on your computer : 

``` php
symfony check:requirements
```

Whether all is good you can follow the quick starter. Otherwise, you will have to make the installation by yourself depending on what you need to run the Symfony API app. 

Then you can clone the backend repository starting by :

```
git clone git@github.com:sportify-shop/backend.git
```

open the project : 
``` php
cd sportify-shop-api/
```

Use composer to install the project's dependencies into vendor 

``` php
composer install
```

Add a `.env.local ` file within your project : 
``` php
touch .env.local
```

Add a `DB_URL` and `DB_PASSWORD` in the `.env.local` previously created : 
``` php
DATABASE_URL="mysql://user-name:password@localhost:3306/db_name"

DATABASE_PASSWORD="password"
```

Then you can create you db : 
```php
php bin/console doctrine:database:create
```

Then you'll need to create a migration to get your entity within the DB using : 
```php
symfony console make:migration

// it will create a migration

php bin/console doctrine:migrations:migrate
```

To seed your DB use `faker` by running: 
``` php
composer require --dev fakerphp/faker
```

You can adjust the seed deping on your need within the `src/DataFixtures` 's folder 

To run the server open your console terminal, take a look if you are within the project's folder and start the local web server as follows :

``` php
symfony server:start
```

Now you're In ! Congrats !! 


Get access to sportify, get access to the limitless sport. 
-> [Sportify-Shop]() will be soon in production.
Stay tunes.

## Features 
#### Done

 - [x] DB 
 - [x]  Home page
 - [x] Category_show page
 - [x] Filters to sort product by categoryId, categoryName, gender and price
 - [x] You can sort the product list in ascending order or descending order. Suit yourself !
 - [x] Product_show page
 - [x] Cart handle in the LocalStorage

#### Soon

- [ ] Register and Login authentication token
- [ ] Use an algorithme and make a try with an analytique model (DATA&IA)
- [ ] Connect Stripe to the app

## Authors Details 

@[Ericcost](https://github.com/Ericcost)
@[Ludovic](https://github.com/ludovic-sbr)
@[Hugo](https://github.com/Zeleph75)
