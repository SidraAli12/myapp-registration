{{-- Edit Form (hidden by default) --}}
<div id="editForm" style="display:none; margin-top:20px;">
    <h3>Edit Task</h3>
    <form id="updateTaskForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="editTaskId">

        <label>Title</label>
        <input type="text" name="title" id="editTitle" required><br><br>

        <label>Description</label>
        <textarea name="description" id="editDescription"></textarea><br><br>

        <label>Due Date</label>
        <input type="date" name="due_date" id="editDueDate"><br><br>

        <label>Status</label>
        <select name="status" id="editStatus">
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
        </select><br><br>

        <button type="submit">Update Task</button>
    </form>
</div>

<script>
$(document).ready(function(){

    // Show edit form with data
    $(document).on("click", ".editTask", function(){
        let row = $(this).closest("tr");
        let id = row.data("id");
        let title = row.find("td:eq(0)").text();
        let description = row.find("td:eq(1)").text();
        let due_date = row.find("td:eq(2)").text();
        let status = row.find("select.updateStatus").val();

        $("#editTaskId").val(id);
        $("#editTitle").val(title);
        $("#editDescription").val(description);
        $("#editDueDate").val(due_date);
        $("#editStatus").val(status);

        $("#editForm").show();
    });

    // Submit Edit Form via AJAX
    $("#updateTaskForm").submit(function(e){
        e.preventDefault();

        let id = $("#editTaskId").val();

        $.ajax({
            url: "/tasks/" + id,
            method: "POST",
            data: $(this).serialize(),
            success: function(response){
                alert("Task Updated!");

                // Update row without reload
                let row = $(`#tasksTable tr[data-id="${id}"]`);
                row.find("td:eq(0)").text(response.task.title);
                row.find("td:eq(1)").text(response.task.description);
                row.find("td:eq(2)").text(response.task.due_date);
                row.find("select.updateStatus").val(response.task.status);

                $("#editForm").hide();
            },
            error: function(){
                alert("Error updating task");
            }
        });
    });

});
</script>
