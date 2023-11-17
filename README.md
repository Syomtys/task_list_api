## Create Task

Endpoint: `you.domain/api/task/create_task/`

**Headers:**
{Authorization: access_token}


**Parameters:**
- **title** (required, string): Task title
- **task** (required, string): Task description
- **priority** (optional, int): Task priority (default: 1)
- **status** (optional, int): Task status (default: 1)
- **task_from** (auto, string): Task assigner
- **task_for** (optional, string): Task assignee
- **date_create** (auto, date): Task creation date

###PHP
$headers = [
	'Authorization: access_token'
];

$data = [
	'create' => [
		'title' => 'd',
		'task' => 'task',
		'priority' => '1',
		'status' => '1',
		'task_from' => '1',
		'task_for' => '',
		'date_create' => '1',
	]
];


---

## Get Task List

Endpoint: `you.domain/api/task/get_task_list/`

**Headers:**
{Authorization: access_token}


**Parameters:**
- **id** (optional, int): Element ID
- **limit** (optional, int): Limit
- **title** (optional, string): Title
- **task** (optional, string): Task description
- **priority** (optional, int): Task priority
- **task_for** (optional, string): Task assignee
- **task_from** (optional, string): Task assigner
- **date_create** (optional, date): Date in Y-m-d format
- **status** (optional, int): Task status

---

## Delete Task

Endpoint: `you.domain/api/task/delete_task/`

**Headers:**
{Authorization: access_token}


**Parameters:**
- **id** (optional, int): Element ID
- **limit** (optional, int): Limit
- **title** (optional, string): Title
- **task** (optional, string): Task description
- **priority** (optional, int): Task priority
- **status** (optional, int): Task status
- **task_for** (optional, string): Task assignee
- **task_from** (optional, string): Task assigner

---

## Edit Task

Endpoint: `you.domain/api/task/edit_task/`

**Headers:**
{Authorization: access_token}


**Parameters:**
- **get[id]** (optional, int): Element ID
- **get[limit]** (optional, int): Limit
- **get[title]** (optional, string): Title
- **get[task]** (optional, string): Task description
- **get[priority]** (optional, int): Task priority
- **get[task_for]** (optional, string): Task assignee
- **get[task_from]** (optional, string): Task assigner
- **get[date_create]** (optional, date): Date in Y-m-d format
- **get[status]** (optional, int): Task status
- **new_data[limit]** (optional, int): Limit
- **new_data[title]** (optional, string): Title
- **new_data[task]** (optional, string): Task description
- **new_data[priority]** (optional, int): Task priority
- **new_data[task_for]** (optional, string): Task assignee
- **new_data[task_from]** (optional, string): Task assigner
- **new_data[status]** (optional, int): Task status
