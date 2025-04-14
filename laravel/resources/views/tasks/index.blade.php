@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Список задач</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Добавить задачу</a>
    </div>

    @if($tasks->isEmpty())
        <div class="alert alert-info">
            Список задач пуст. Создайте новую задачу.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Статус</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr class="task-status-{{ $task->status }}">
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ Str::limit($task->description, 50) }}</td>
                        <td>
                            @if($task->status == 'pending')
                                <span class="badge bg-warning text-dark">Ожидает</span>
                            @elseif($task->status == 'in_progress')
                                <span class="badge bg-primary">В процессе</span>
                            @elseif($task->status == 'completed')
                                <span class="badge bg-success">Завершена</span>
                            @endif
                        </td>
                        <td>{{ $task->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-info me-2">
                                    Редактировать
                                </a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $tasks->links() }}
        </div>
    @endif
@endsection
