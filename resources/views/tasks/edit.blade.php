@extends('layouts.app')

@section('content')
    <h1>Edit Task</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Title:</label>
        <input type="text" name="title" value="{{ old('title', $task->title) }}" required><br><br>

        <label>Description:</label>
        <textarea name="description">{{ old('description', $task->description) }}</textarea><br><br>

        <label>Due Date:</label>
        <input type="date" name="due_date" value="{{ old('due_date', $task->due_date) }}"><br><br>

        <label>Category ID:</label>
        <input type="number" name="category_id" value="{{ old('category_id', $task->category_id) }}"><br><br>

        <button type="submit">Update Task</button>
    </form>
@endsection
<div>
    <label>Due Date</label>
    <input type="date" name="due_date" value="{{ old('due_date', $task->due_date ?? '') }}">
</div>

<div>
    <label>Status</label>
    <select name="status">
        <option value="pending" {{ old('status', $task->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="completed" {{ old('status', $task->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
    </select>
</div>

