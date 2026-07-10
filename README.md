# installation 

run npm install 
npm build
npm run dev --port=8000

# Using the API 

/api/list will return all events
/api/create with a JSON that contains the following fields: event_name as a string, event_date as a date and current_attendees as an integer will create an event in the sqllite database.
/api/update_event with a JSON that contains the following fields: event_name as a string, event_date as a date and current_attendees as an integer will update an event in the sqllite database.
/api/update_attendees with a JSON that contains the following fields: event_name as a string, event_date as a date and
/api/remove with the a JSON that contains the following fields event_name as a string, event_date as a date and current_attendees as an integer will delete an event in the sqllite database.

