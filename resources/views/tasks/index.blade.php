<h2>My Tasks</h2>
<a href="{{ route('tasks.create') }}">Add Task</a>
<ul>
    @foreach($tasks as $task)
        <li>
            <strong>{{ $task->title }}</strong> - {{ $task->description }}
            <a href="{{ route('tasks.edit', $task) }}">Edit</a>
            <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </li>
    @endforeach
</ul>
