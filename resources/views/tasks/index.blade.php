@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Create / Update Form --}}
    <div id="createForm">
        <h3>Add / Edit Task</h3>
        <form id="taskForm">
            @csrf
            <input type="hidden" name="task_id" id="task_id">

            <label>Title</label>
            <input type="text" name="title" id="title" required><br><br>

            <label>Description</label>
            <textarea name="description" id="description"></textarea><br><br>

            <label>Due Date</label>
            <input type="date" name="due_date" id="due_date"><br><br>

            <label>Status</label>
            <select name="status" id="status">
                <option value="pending" selected>Pending</option>
                <option value="completed">Completed</option>
            </select><br><br>

            <button type="submit" id="saveBtn">Save Task</button>
        </form>
    </div>

    <hr>

    {{-- Task List --}}
    <div id="taskList">
        <h3>Your Tasks</h3>
        <ul></ul>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){

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
                            - Status: 
                            <select class="updateStatus">
                                <option value="pending" ${task.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="completed" ${task.status === 'completed' ? 'selected' : ''}>Completed</option>
                            </select>
                            &nbsp;
                            <button class="editBtn">Edit</button>
                            <button class="deleteBtn">Delete</button>
                        </li>
                    `;
                });
                $("#taskList ul").html(list);
            },
            error: function(xhr){
                console.log("Load error:", xhr.responseText);
            }
        });
    }

    $("#taskForm").submit(function(e){
        e.preventDefault();

        let taskId = $("#task_id").val();
        let url = taskId ? "/tasks/" + taskId : "{{ route('tasks.store') }}";
        let formData = $(this).serialize();

        if(taskId){
            formData += "&_method=PUT";
        }

        $.ajax({
            url: url,
            method: "POST", // 👈 Always POST
            data: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function(response){
                alert(taskId ? "Task Updated!" : "Task Created!");
                loadTasks(); // refresh list
                $("#taskForm")[0].reset();
                $("#task_id").val('');
                $("#saveBtn").text("Save Task");
            },
            error: function(xhr){
                alert("Error saving task");
                console.log(xhr.responseText);
            }
        });
    });

    $(document).on("click", ".editBtn", function(){
        let li = $(this).closest("li");
        let taskId = li.data("id");

        $.ajax({
            url: "/tasks/" + taskId,
            method: "GET",
            success: function(task){
                $("#task_id").val(task.id);
                $("#title").val(task.title);
                $("#description").val(task.description);
                $("#due_date").val(task.due_date);
                $("#status").val(task.status);
                $("#saveBtn").text("Update Task");
            },
            error: function(xhr){
                console.log("Edit load error:", xhr.responseText);
            }
        });
    });

    $(document).on("click", ".deleteBtn", function(){
        if(!confirm("Are you sure?")) return;

        let taskId = $(this).closest("li").data("id");

        $.ajax({
            url: "/tasks/" + taskId,
            method: "POST", // 👈 Always POST
            data: { _token: "{{ csrf_token() }}", _method: "DELETE" },
            success: function(response){
                alert("Task Deleted!");
                loadTasks();
            },
            error: function(xhr){
                console.log("Delete error:", xhr.responseText);
            }
        });
    });

    $(document).on("change", ".updateStatus", function(){
        let taskId = $(this).closest("li").data("id");
        let newStatus = $(this).val();

        $.ajax({
            url: "/tasks/" + taskId + "/status",
            method: "PATCH",
            data: {
                _token: "{{ csrf_token() }}",
                status: newStatus
            },
            success: function(response){
                alert("Task status updated!");
            },
            error: function(xhr){
                console.log("Status update error:", xhr.responseText);
            }
        });
    });

});
</script>
@endsection
