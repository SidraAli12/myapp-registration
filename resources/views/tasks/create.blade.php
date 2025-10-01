<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    {{--  jQuery add karo --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

{{-- Create Form --}}
<div id="createForm">
    <h3>Add Task</h3>
    <form id="taskForm">
        @csrf
        <label>Title</label>
        <input type="text" name="title" required><br><br>

        <label>Description</label>
        <textarea name="description"></textarea><br><br>

        <label>Due Date</label>
        <input type="date" name="due_date"><br><br>

        <label>Status</label>
        <select name="status">
            <option value="pending" selected>Pending</option>
            <option value="completed">Completed</option>
        </select><br><br>

        <button type="submit">Save Task</button>
    </form>
</div>

<hr>

{{-- Task List --}}
<div id="taskList">
    <h3>Your Tasks</h3>
    <ul></ul>
</div>

<script>
$(document).ready(function(){

    //  Load Tasks initially
    loadTasks();

    function loadTasks(){
        $.ajax({
            url: "{{ route('tasks.index') }}",
            method: "GET",
            success: function(tasks){
                let list = "";
                tasks.forEach(task => {
                    list += `
                        <li data-id="${task.id}">
                            <b>${task.title}</b> 
                            - ${task.description ?? ''} 
                            - Due: ${task.due_date ?? 'N/A'} 
                            - Status: ${task.status}
                        </li>
                    `;
                });
                $("#taskList ul").html(list);
            }
        });
    }

    //  Create Task via AJAX
    $("#taskForm").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: "{{ route('tasks.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response){
                alert("Task Created!");
                loadTasks(); // refresh list
                $("#taskForm")[0].reset();
            },
            error: function(xhr){
                alert("Error creating task");
                console.log(xhr.responseText);
            }
        });
    });

});
</script>
</body>
</html>
