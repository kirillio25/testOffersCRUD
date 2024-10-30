# Установка зависимостей
composer install 
npm install

# Установка миграций 
yii migrate

# Для заполнения рандомными значениями таблицы 
php yii offer/generate 10

# Тестирование
php yii migrate --interactive=0 --appconfig=config/test.php
php vendor/bin/codecept run