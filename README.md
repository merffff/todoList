# Task Management API

REST API для управления задачами (To-Do List), разработанный на PHP с использованием Laravel и Docker.

## Установка и запуск

### 1. Клонирование репозитория

```bash
git clone git@github.com:merffff/todoList.git
cd task-api
```

### 2. Запуск проекта

```bash
# Поднимаем Docker-контейнеры
docker-compose up -d

# Настраиваем и запускаем миграции БД
docker exec -it task_api_php php artisan migrate

# Очищаем кэш Laravel для корректной работы
docker exec -it task_api_php php artisan config:clear
```

После запуска, API будет доступно по адресу: `http://localhost/api/tasks`

## Интерфейс пользователя

Веб-интерфейс доступен по адресу: `http://localhost`

В интерфейсе реализованы:
- Просмотр списка задач с пагинацией (по 10 задач на странице)
- Создание новых задач
- Редактирование существующих задач
- Удаление задач

## API Endpoints

### 1. Получение списка задач
- **URL**: `/api/tasks`
- **Метод**: `GET`
- **Заголовки**:
    - `Accept: application/json`
- **Пример ответа**:
  ```json
  {
    "status": "success",
    "data": [
      {
        "id": 1,
        "title": "Задача 1",
        "description": "Описание задачи 1",
        "status": "pending",
        "created_at": "2023-01-01T12:00:00.000000Z",
        "updated_at": "2023-01-01T12:00:00.000000Z"
      }
    ]
  }
  ```

### 2. Получение одной задачи
- **URL**: `/api/tasks/{id}`
- **Метод**: `GET`
- **Заголовки**:
    - `Accept: application/json`
- **Пример ответа**:
  ```json
  {
    "status": "success",
    "data": {
      "id": 1,
      "title": "Задача 1",
      "description": "Описание задачи 1",
      "status": "pending",
      "created_at": "2023-01-01T12:00:00.000000Z",
      "updated_at": "2023-01-01T12:00:00.000000Z"
    }
  }
  ```

### 3. Создание задачи
- **URL**: `/api/tasks`
- **Метод**: `POST`
- **Заголовки**:
    - `Accept: application/json`
    - `Content-Type: application/json`
- **Тело запроса** (JSON):
  ```json
  {
    "title": "Новая задача",
    "description": "Описание задачи",
    "status": "pending"
  }
  ```
- **Пример ответа**:
  ```json
  {
    "status": "success",
    "message": "Task created successfully",
    "data": {
      "id": 2,
      "title": "Новая задача",
      "description": "Описание задачи",
      "status": "pending",
      "created_at": "2023-01-02T12:00:00.000000Z",
      "updated_at": "2023-01-02T12:00:00.000000Z"
    }
  }
  ```

### 4. Обновление задачи
- **URL**: `/api/tasks/{id}`
- **Метод**: `PUT`
- **Заголовки**:
    - `Accept: application/json`
    - `Content-Type: application/json`
- **Тело запроса** (JSON):
  ```json
  {
    "title": "Обновленная задача",
    "description": "Новое описание",
    "status": "completed"
  }
  ```
- **Пример ответа**:
  ```json
  {
    "status": "success",
    "message": "Task updated successfully",
    "data": {
      "id": 1,
      "title": "Обновленная задача",
      "description": "Новое описание",
      "status": "completed",
      "created_at": "2023-01-01T12:00:00.000000Z",
      "updated_at": "2023-01-02T14:00:00.000000Z"
    }
  }
  ```

### 5. Удаление задачи
- **URL**: `/api/tasks/{id}`
- **Метод**: `DELETE`
- **Заголовки**:
    - `Accept: application/json`
- **Пример ответа**:
  ```json
  {
    "status": "success",
    "message": "Task deleted successfully"
  }
  ```

## Возможные статусы задач
- `pending` - ожидает выполнения
- `in_progress` - в процессе выполнения
- `completed` - завершена

## Структура проекта

- `docker-compose.yml` - конфигурация Docker-контейнеров
- `docker/php/Dockerfile` - настройка PHP-контейнера
- `docker/nginx/default.conf` - конфигурация Nginx
- `laravel/` - проект Laravel с API и веб-интерфейсом

## Требования к данным

При создании и обновлении задач используется следующая валидация:
- `title` - обязательное поле, строка не более 255 символов
- `description` - необязательное поле, текст
- `status` - одно из значений: `pending`, `in_progress`, `completed`

## Возможные проблемы и их решения

**Ошибка при запросах к API:**
1. Проверьте, что все заголовки указаны правильно
2. Убедитесь, что тело запроса содержит корректный JSON
3. Очистите кэш конфигурации Laravel:
   ```bash
   docker exec -it task_api_php php artisan config:clear
   ```

**Проблемы с базой данных:**
```bash
docker exec -it task_api_php php artisan migrate:fresh
```

**Ошибка "Call to a member function connection() on null":**
Проверьте, что MySQL-контейнер запущен и настройки соединения в `.env` файле указаны корректно.