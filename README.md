Требования:

Symfony >= 5.0
PHP >= 7.4
MySQL >=5.7

Инициализация приложения:

Подготовка:

cd projects/

git clone ...

cd library/

composer install

Проверить настройки к базе данных в файле .dev 
Необходимо указать действующего пользователя базы данных и пароль, а также хост и порт:

DATABASE_URL=mysql://db_user:db_password@localhost:3306/library?serverVersion=5.7

Далее:

php bin/console doctrine:database:create

php bin/console make:migration

php bin/console doctrine:migrations:migrate
