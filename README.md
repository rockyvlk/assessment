### Как развернуть проект

- Указать переменные окружения NGINX_PORT, MARIADB_PORT (опционально)
- Выполнить `make init`

### Как запустить тесты

- Выполнить `make test-init`
- Выполнить `make test`


### Основные комманды make

- **init** - Развернуть проект

- **docker-up** - Запустить проект
- **docker-down** - Остановить проект
- **docker-restart** - Перезапустить проект
- **docker-rebuild** - Пересобрать проект

- **database-migrate** - Выполнение миграций
- **database-rollback** - Выполнение миграций
- **database-diff** - Генерация миграций
- **database-validate-schema** - Проверка схемы

- **console {command_name}** - Выполнение консольной комманды
