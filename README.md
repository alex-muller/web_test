# web_test

*Set up:*

```
git clone git@github.com:postindustria-tech/web_test.git {prodject dir}
cd {prodject dir}
cp .env.example .env 
vim .env - set up DB_*
composer install

php artisan key:generate
php artisan migrate
php artisan passport:install
php artisan command:MakeUser {email} {password}

npm install
npm run dev
```

go to /auth/login to rock
