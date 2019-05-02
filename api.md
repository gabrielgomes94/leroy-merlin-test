### Authentication

To use the API, the user must pass the valid API_KEY through the `Authorization` header.
The API_KEY is setted on .env file

#### Example:
curl -X GET \
  http://localhost:8000/api/products \
  -H 'Authorization: p2lbgWkFrykA4QyUmpHihzmc5BNzIABq'
