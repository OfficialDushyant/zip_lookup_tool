# Zip Code Lookup Test Application
---

### Prerequisite

- System with PHP 8 and MySQl Installed.
- Composer package manage.
- An account with mailtrap https://mailtrap.io
---

### How to setup this project

- Form the root directory run `composer install`. to install Composer dependance.
- Run `npm install` to install node dependance.
- Run `cp .env.example .env`.
- Run `php artisan key:generate`.
- Run `npm run build` this will create production ready bundle of assets at public/build.
- Run `php artisan serve` to run the server.
- In you browser go to url that you see when you started the server.
- If you see a login page 👍 you'll need some more settings to add for your database and Mailer to work.
---
### .env Settings for Database and Mail
- In your MySQL create Database `zip_lookup`
- DB variables
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=zip_lookup
DB_USERNAME=<USER NAME> // you can use root for local env
DB_PASSWORD=<YOUR PASSWORD>
```
- Mail variables
if you want to know how to get Mailtrap SMTP settings checkout https://uhded.com/username-password-mailtrap
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=<YOUR MAILTRAP USER ID>
MAIL_PASSWORD=<YOUR MAILTRAP PASSWORD>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@ziplookuptool.com"
MAIL_FROM_NAME="${APP_NAME}"
```


---
### Custom Artisan command

1) `php artisan zip:lookup <zip code>` zip code as a argument to this command is required.
This command will display the API result to consol for given zip Code.

2) `php artisan zip:report <email address> < --hours=24 >` email address as argument is required and hours is optional.
This command will send activity report to given email address for past provided number of hours.

---
### Running tests 

You can run classic `php artisan test`. 
For the task specific test you can run
`php artisan test --filter ZipLookupServiceTest`.