# ATC-SYSTEM
WorldSkills project


1. Для установки всех зависимостей в Symfony проекте, выполните команду:
`composer install`
2. После, настройте подключение к БД в файле .env
```
#/.env

DATABASE_URL=mysql://username:password@127.0.0.1:3306/db_name

``` 
- Выполните следующие команды, для создания новой базы данных:
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
- Если требуется использовать существующую БД, то выполните эти команды:
```
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```
3. `index.php` файл находиться в директории `public`. Подключите его к веб-серверу. 
4. Переходите по ссылке `/create-admin` для создания администратора
5. Переходите по ссылке `/admin/login` для авторизации
> login:    admin,
> password: admin123
