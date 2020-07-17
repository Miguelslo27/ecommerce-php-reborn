# E COMMERCE APP (NO NAME YET)

> A complete **APP** and **API** to build fast and usefull **e-commerce** with all the features needed

## Getting Started

> These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See [deployment](#deployment) for notes on how to deploy the project on a live system.

### Prerequisites

* A local server on your machine (**XAMPP**, **MAMP**, **WAMP**)
  * Examples will be with **XAMPP**
* We asume your server is **Apache with PHP 7+, MySQL 5.6+**
* Basic understanding of **PHP**, **SQL** and **phpMyAdmin MySQL manager**
* Git installed on your system (**Git Bash**)
* GitHub account

### Roadmap

> A step by steap installation guide

* [Cloning the repo](#cloning-the-repo)
* [Setup the source folder into the server root folder](#setup-the-source-folder)
* [Setup the local domain pointing to your local IP](#setup-the-local-domain)
* [Setup the virtual host settings](#setup-the-virtual-host)
* [Install the database](#install-the-database)
* [Setup the local environment file](#setup-the-local-environment)

### Installing

A step by step series of examples that tell you how to get a development environment up and running

#### Cloning the repo

- Open your `git bash` terminal

- Clone the repo to your prefered location

  ```
  git clone https://github.com/Miguelslo27/ecommerce-php-reborn.git
  ```

#### Setup the source folder

- Setup a **symbolic link** to the project inside the root server `c:/xampp/htdocs`, for that, you need to go to the location in the terminal and use the next command

  ```
  ln -s [path to your git projects folder]/ecommerce-php-reborn ecommerce-php-reborn
  ```

#### Setup the local domain

> Add a local domain, a domain where you will see the e-commerce running from your local machine
    
> You will need to setup the domain and a virtual host

- Open the `hosts` file (this steps asumes that you are in **Windows**) **with administrative privileges**

  ```
  C:/Windows/System32/drivers/etc/hosts
  ```

- Edit the `hosts` file, adding the domain pointing to your localhost IP, at the end of the file

  ```
  ...
  127.0.0.1   demo.ecommerce.local
  ```

  > This will allow you to visit `demo.ecommerce.local` on your browser, pointing to your `localhost`, but you will see nothing until you set up your **virtual host**

#### Setup the virtual host

> Add a **Virtual Host** to your server configuration

> We asume you have **Apache** with **XAMPP**

- Open your **Apache virtual host** settings file

  ```
  C:\xampp\apache\conf\extra\httpd-vhosts.conf
  ```

- Add your **Virtual Host** settings at the end of the file

  ```
  ...
  <VirtualHost *:80>
    DocumentRoot "C:\xampp\htdocs\ecommerce-php-reborn"
    ServerName demo.ecommerce.local
  </VirtualHost>
  ```

  > With this setting, you are pointing `demo.ecommerce.local` to the folder `C:\xampp\htdocs\ecommerce-php-reborn`

  > Ass additional note, you will need to **restart your Apache server** so the changes can take effect

#### Install the database

> It's time to install the **database**, you will need your **xampp** server up and running

- Open `phpMyAdmin` on your preffered browser

  ```
  http://localhost/phpmyadmin
  ```

- Go to `Import` tab

- Click on `Browse your computer`

- Locate your project folder: `[path to your git projects folder]/ecommerce-php-reborn`

- Open the file `ecommerce_db.sql`

  > Let all the other setting as it is

- Scroll down, and click `Go`

> This will execute the **SQL sentences** in the `ecommerce_db.sql` file, creating the `ecommerce_db` **database**, all the needed **tables** and some **rows** (like users, categories and articles)

#### Setup the local environment

> The last, but not less, important step to run the project

- Open you project folder in your preferred code editor

- Create a new file at the root, named `.htaccess`

- Add these content

  ```
  SetEnv ENV 'dev'
  SetEnv DB_NAME 'ecommerce_db'
  SetEnv DB_HOST 'localhost'
  SetEnv DB_USER '[mysql_admin_user]'
  SetEnv DB_PASS '[mysql_admin_password]'

  Options +SymLinksIfOwnerMatch
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule . /404 [L]
  ```

- Replace the **`[mysql_admin_user]`** and **`[mysql_admin_password]`**, with the values you consider pertinent, if you don't know any, write **`root`** for the **`mysql_admin_user`** and let **`mysql_admin_pass`** **empty** (remove the straight parentheses as well)

You are all set...

### Deployment

> Pending To-Do for this module

<!-- End with an example of getting some data out of the system or using it for a little demo

## Running the tests

Explain how to run the automated tests for this system

### Break down into end to end tests

Explain what these tests test and why

```
Give an example
```

### And coding style tests

Explain what these tests test and why

```
Give an example
```

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Dropwizard](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Maven](https://maven.apache.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds

## Contributing

Please read [CONTRIBUTING.md](https://gist.github.com/PurpleBooth/b24679402957c63ec426) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Billie Thompson** - *Initial work* - [PurpleBooth](https://github.com/PurpleBooth)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone whose code was used
* Inspiration
* etc
 -->
