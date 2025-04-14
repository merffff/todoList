
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление задачами</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
body {
    padding-top: 20px;
        }
        .task-status-pending {
    background-color: #fff3cd;
        }
        .task-status-in_progress {
    background-color: #cfe2ff;
        }
        .task-status-completed {
    background-color: #d1e7dd;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="mb-4">
            <h1 class="text-center">Управление задачами</h1>
        </header>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@yield('content')

<footer class="mt-5 text-center text-muted">
    <p>ToDoList</p>
</footer>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
