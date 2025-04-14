<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест на получение списка задач с пагинацией.
     */
    public function test_can_get_all_tasks_paginated(): void
    {
        Task::factory()->count(15)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data',
                'meta' => [
                    'current_page',
                    'last_page',
                    'per_page',
                    'total'
                ]
            ])
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.current_page', 1)
            ->assertJsonPath('meta.per_page', 10)
            ->assertJsonPath('meta.total', 15)
            ->assertJsonPath('status', 'success');
    }

    /**
     * Тест на работу пагинации - проверка второй страницы.
     */
    public function test_can_get_paginated_tasks_second_page(): void
    {

        Task::factory()->count(15)->create();

        $response = $this->getJson('/api/tasks?page=2');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data',
                'meta' => [
                    'current_page',
                    'last_page',
                    'per_page',
                    'total'
                ]
            ])
            ->assertJsonCount(5, 'data')
            ->assertJsonPath('meta.current_page', 2)
            ->assertJsonPath('status', 'success');
    }

    /**
     * Тест на получение конкретной задачи.
     */
    public function test_can_get_single_task(): void
    {

        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => ['id', 'title', 'description', 'status', 'created_at', 'updated_at']
            ])
            ->assertJsonPath('data.id', $task->id)
            ->assertJsonPath('data.title', $task->title)
            ->assertJsonPath('status', 'success');
    }

    /**
     * Тест на создание новой задачи.
     */
    public function test_can_create_task(): void
    {

        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'pending'
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['id', 'title', 'description', 'status', 'created_at', 'updated_at']
            ])
            ->assertJsonPath('data.title', $taskData['title'])
            ->assertJsonPath('data.description', $taskData['description'])
            ->assertJsonPath('data.status', $taskData['status'])
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('message', 'Task created successfully');

        $this->assertDatabaseHas('tasks', $taskData);
    }

    /**
     * Тест на валидацию при создании задачи.
     */
    public function test_cannot_create_task_without_title(): void
    {
        $taskData = [
            'description' => 'Test Description',
            'status' => 'pending'
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);

        $this->assertDatabaseMissing('tasks', $taskData);
    }
    /**
     * Тест на обновление задачи.
     */
    public function test_can_update_task(): void
    {
        $task = Task::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'status' => 'completed'
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => ['id', 'title', 'description', 'status', 'created_at', 'updated_at']
            ])
            ->assertJsonPath('data.title', $updateData['title'])
            ->assertJsonPath('data.description', $updateData['description'])
            ->assertJsonPath('data.status', $updateData['status'])
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('message', 'Task updated successfully');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $updateData['title'],
            'description' => $updateData['description'],
            'status' => $updateData['status']
        ]);
    }

    /**
     * Тест на валидацию при обновлении задачи.
     */
    public function test_cannot_update_task_with_invalid_status(): void
    {
        $task = Task::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'status' => 'invalid_status'
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
            'title' => $updateData['title']
        ]);
    }

    /**
     * Тест на удаление задачи.
     */
    public function test_can_delete_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message'
            ])
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('message', 'Task deleted successfully');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /**
     * Тест на получение несуществующей задачи.
     */
    public function test_cannot_get_nonexistent_task(): void
    {
        $response = $this->getJson('/api/tasks/999');

        $response->assertStatus(404);
    }
}
