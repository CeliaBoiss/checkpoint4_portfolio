# Portfolio

### This project is a showcase site for me and my work.

With this site, you can :

* show a list of projects with photos, description, customers, working partners and skills used
* be able to be contacted with a link to social network in the footer
* be able to acces an admin page for add, modified or delete a : project, customer, skill or working partner

This project was made with symfony 5.

## Requirements

- Php ^7.2 http://php.net/manual/fr/install.php;
- Composer https://getcomposer.org/download/;

## Installation

1. Clone the current repository.

2. With mysql, create a database and create a user. Don't forget to give the rights to the user.
> If you want to use another service, see the official symfony documentation

3. Move into the directory and create an `.env.local` file (copy env file). **This one is not committed to the shared repository.**

4. Line 30, set `db_name` to a name of your choice and set the user `db_user` and the password `db_password`.
> Make sure the connection with the base is functional

5. Execute the following commands in your working folder to install the project:

```bash
# Install dependencies
composer install

# Create 'wewelcome' DB
php bin/console d:d:c

# Execute migrations and create tables
php bin/console d:m:m
```

7. Go on the /init page and register you as an admin user : you have to put a username and a password

> Reminder: Don't use composer update to avoid problem

> Assets are directly into _public/_ directory, **we will not use** Webpack with this project

## Usage

Launch the server with the command below

```bash
$ symfony server:start
```
