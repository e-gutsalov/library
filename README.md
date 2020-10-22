Требования:

Symfony >= 5.0
PHP >= 7.4
MySQL >=5.7

Инициализация приложения

Подготовка:
cd projects/
git clone ...

cd my_project_name/
composer install

Запуск веб сервера:
php bin/console server:start
или
php bin/console server:run

Режим отладки приложения:
cd my_project_name/
composer req debug --dev

Проверить настройки доступа к базе данных в файле .dev
