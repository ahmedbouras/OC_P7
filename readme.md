# OC_P7


## Who made it ?

Me -> Ahmed Bouras (Actually student)
To contact me -> ahmed.bouras@outlook.fr

## What's this project ?

This is a project from my professional training with Openclassrooms.
I had to make a api to make some data available.

## When I worked on it ?

During december2020/january2021 

## The Progression of the project ?

This project is done

## How is it made it ?

Symfony4.4

## Why you should work on it ?

It's my first api in Symfony.
So if you can help me to improve myself with better code's version, please work on it.

# How can you install this project ?

Follow this instructions step by step to install this project in your computer:
 1. Clone this project : `git clone https://github.com/ahmedbrs/OC_P7.git`
 2. Install needed librairies : `php bin/console composer install`
 3. Create and configure your database dependig what you're using, please refer to the official documentation : https://symfony.com/doc/4.4/doctrine.html#configuring-the-database
 4. I prepared some fictive data. If you want to use them, do this command : 
`php bin/console doctrine:fixtures:load`
 5. To configure LexikJWTAuthentication, please refer to the official documentation : https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#installation
 Make sure to create a `.env.local` and add the passphrase which you used when you generated your ssl keys with "openssl" like this : `JWT_PASSPHRASE=yourpassword`
 
 

For any questions, you can contact me at ahmed.bouras@outlook.fr
