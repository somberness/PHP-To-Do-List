<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>My To-Do List 🎀</h1>
        <form action="index.php" method="POST">
            <input type="text" name="task" placeholder="Enter a new task" required>
            <button type="submit" name="add">Add Task</button>
        </form>

        <?php
        $file = 'tasks.json';

        if (file_exists($file)) {
            $tasks = json_decode(file_get_contents($file), true);
        } else {
            $tasks = [];
        }

        if (isset($_POST['add'])) {
            $task = htmlspecialchars($_POST['task']);
            $tasks[] = $task;
            file_put_contents($file, json_encode($tasks));
        }

        if (isset($_POST['delete'])) {
            $taskIndex = $_POST['task_index'];
            if (isset($tasks[$taskIndex])) {
                array_splice($tasks, $taskIndex, 1);
                file_put_contents($file, json_encode($tasks));
            }
        }

        if (!empty($tasks)) {
            echo '<ul>';
            foreach ($tasks as $index => $task) {
                echo '<li>' . htmlspecialchars($task) . '
                    <form action="index.php" method="POST" class="delete-form">
                        <input type="hidden" name="task_index" value="' . $index . '">
                        <button type="submit" name="delete" class="delete-button">Delete</button>
                    </form>
                </li>';
            }
            echo '</ul>';
        } else {
            echo '<p>No tasks yet!</p>';
        }
        ?>
    </div>
</body>
</html>
