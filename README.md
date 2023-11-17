## Create Task

**Headers:**
POST `/api/task/create_task/`

### Parameters:
**headers**
`{Authorization: access_token}`
**body**
| Parameters | required | data type | description |
| ------ | ------ | ------ | ------ |
| title | yes | string | Task title |
| task | yes | string | Task description |
| priority | no | int | Task priority (default: 1) |
| status | no | int | Task status (default: 1) |
| task_from | auto | string | Task assigner |
| task_for | no | string | Task assignee |
| date_create | auto | date | Task creation date |

### PHP

```sh
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
```

---

## Get Task List

**Headers:**
POST `/api/task/get_task_list/`

### Parameters:
**headers**
`{Authorization: access_token}`
**body**
| Parameters | required | data type | description |
| ------ | ------ | ------ | ------ |
| id | optional | int | Element ID |
| limit | optional | int | Limit |
| title | yes | string | Task title |
| task | yes | string | Task description |
| priority | no | int | Task priority |
| status | no | int | Task status |
| task_from | auto | string | Task assigner |
| task_for | no | string | Task assignee |
| date_create | auto | date | Task creation date |

### PHP

```sh
$headers = [
'Authorization: access_token'
];
$data = [
	'get' => [
		'id' => 3,
		'limit' => 5,
		'title' => 'title',
		'task' => 'task',
		'priority' => 1,
		'task_for' => '10',
		'task_from' => 'ee',
		'date_create' => '2023-11-16',//Y-m-d format
	]
];
```

---

## Deleted Task

**Headers:**
POST `/api/task/delete_task/`

### Parameters:
**headers**
`{Authorization: access_token}`
**body**
| Parameters | required | data type | description |
| ------ | ------ | ------ | ------ |
| id | optional | int | Element ID |
| limit | optional | int | Limit |
| title | yes | string | Task title |
| task | yes | string | Task description |
| priority | no | int | Task priority |
| status | no | int | Task status |
| task_from | auto | string | Task assigner |
| task_for | no | string | Task assignee |
| date_create | auto | date | Task creation date |

### PHP

```sh
$headers = [
'Authorization: access_token'
];
$data = [
	'dlt' => [
		'id' => 9,
		'limit' => 5,
		'title' => 'title',
		'task' => 'task',
		'priority' => 1,
		'status' => 1,
		'task_for' => '10',
		'task_from' => 'ee',
	]
];
```

---

## Edit Task

**Headers:**
POST `/api/task/edit_task//`

### Parameters:
**headers**
`{Authorization: access_token}`
**body**
| Parameters | required | data type | description |
| ------ | ------ | ------ | ------ |
| get[id] | optional | int | Element ID |
| get[limit] | optional | int | Limit |
| get[title] | yes | string | Task title |
| get[task] | yes | string | Task description |
| get[priority] | no | int | Task priority |
| get[status] | no | int | Task status |
| get[task_from] | auto | string | Task assigner |
| get[task_for] | no | string | Task assignee |
| get[date_create] | auto | date | Task creation date |

| Parameters | required | data type | description |
| ------ | ------ | ------ | ------ |
| new_data[limit] | optional | int | Limit |
| new_data[title] | yes | string | Task title |
| new_data[task] | yes | string | Task description |
| new_data[priority] | no | int | Task priority |
| new_data[status] | no | int | Task status |
| new_data[task_from ]| auto | string | Task assigner |
| tnew_data[ask_for] | no | string | Task assignee |
| new_data[date_create] | auto | date | Task creation date |

### PHP

```sh
$headers = [
'Authorization: access_token'
];
$data = [
	'get' => [
		'id' => 11,
		'limit' => 5,
		'title' => 'title',
		'task' => 'task',
		'priority' => 3,
		'status' => 1,
		'task_for' => '10',
		'task_from' => 'ee',
		'date_create' => '2023-11-16',//Y-m-d format
	],
	'new_data' => [
		'limit' => 5,
		'title' => 'title',
		'task' => 'task',
		'priority' => 4,
		'status' => 4,
		'task_for' => '10',
		'task_from' => 'ee',
	]
];

```

---
