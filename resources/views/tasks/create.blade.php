@extends('layouts.app')

@section('content')
    <h1>Create Task</h1>

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <label>Title:</label>
        <input type="text" name="title" value="{{ old('title') }}" required><br><br>

        <label>Description:</label>
        <textarea name="description">{{ old('description') }}</textarea><br><br>

        <label>Due Date:</label>
        <input type="date" name="due_date" value="{{ old('due_date') }}"><br><br>

        <label>Category ID:</label>
        <input type="number" name="category_id" value="{{ old('category_id') }}"><br><br
          <label>Status</label>
    <select name="status">
        <option value="pending" {{ old('status', $task->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="completed" {{ old('status', $task->status ?? '') == 'completed' ? 'selected' : '' }}>Completed</option>
    </select>
        <button type="submit">Save Task</button>
    </form>
@endsection
