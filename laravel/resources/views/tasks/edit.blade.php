@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Редактирование задачи</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Название задачи</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                           id="title" name="title" value="{{ old('title', $task->title) }}" required>
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Описание задачи</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="3">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Статус</label>
                    <select class="form-select @error('status') is-invalid @enderror"
                            id="status" name="status">
                        <option value="pending" {{ (old('status', $task->status) == 'pending') ? 'selected' : '' }}>Ожидает</option>
                        <option value="in_progress" {{ (old('status', $task->status) == 'in_progress') ? 'selected' : '' }}>В процессе</option>
                        <option value="completed" {{ (old('status', $task->status) == 'completed') ? 'selected' : '' }}>Завершена</option>
                    </select>
                    @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex">
                    <button type="submit" class="btn btn-primary me-2">Сохранить изменения</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Отмена</a>
                </div>
            </form>
        </div>
    </div>
@endsection
