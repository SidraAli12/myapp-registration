@extends('layouts.app')

@section('content')
    <h1>Your Tasks</h1>

    <a href="{{ route('tasks.create') }}">+ Add New Task</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>

        @foreach($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->due_date }}</td>
                <td>{{ $task->due_date }}</td>
     <td>{{ ucfirst($task->status) }}</td>

                <td>
                    <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()">
                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </form>
                </td>
                <td>{{ $task->category_id ?? '-' }}</td>
                <td>
                    <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this task?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
