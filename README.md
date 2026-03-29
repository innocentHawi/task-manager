## Live URL
https://task-manager-production-e7ba.up.railway.app


## API Endpoints

### Get Tasks
GET https://task-manager-production-e7ba.up.railway.app/api/tasks  
Lists all tasks


### Create Task
POST https://task-manager-production-e7ba.up.railway.app/api/tasks  

Example:
{
  "title": "Fix login bug",
  "due_date": "2026-04-05",
  "priority": "high"
}


### Update Task Status
PATCH https://task-manager-production-e7ba.up.railway.app/api/tasks/1/status  

Example:
{
  "status": "in_progress"
}


### Delete Task
DELETE https://task-manager-production-e7ba.up.railway.app/api/tasks/1  

Note: Only done tasks can be deleted


### Daily Report
GET https://task-manager-production-e7ba.up.railway.app/api/tasks/report?date=2026-04-01  

Returns tasks report for a specific date
