<h2>Edit Task</h2>
<form action="{{ route('tasks.update', $task) }}" method="POST">
    @csrf @method('PUT')
    <input type="text" name="title" value="{{ $task->title }}" required>
    <textarea name="description">{{ $task->description }}</textarea>
    <button type="submit">Update</button>
</form>
