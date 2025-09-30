<h2>Add Task</h2>
<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Task title" required>
    <textarea name="description" placeholder="Task description"></textarea>
    <button type="submit">Save</button>
</form>
