============================================================
Diwali Sale Campaign API
============================================================

This project implements a Laravel API for handling a Diwali sale campaign with various discount rules.

------------------------------------------------------------
Getting Started
------------------------------------------------------------

### Prerequisites

- PHP >= 7.3
- Composer
- Laravel CLI

### Installation

1. Clone the repository:

2. Install dependencies:

3. Set up environment variables:
- Copy `.env.example` to `.env`
- Update `.env` with your database and other configuration details (if applicable)

4. Generate application key:

------------------------------------------------------------
Running the Application
------------------------------------------------------------

Start the Laravel development server by ```php artisan serve```
The application will be served at `http://127.0.0.1:8000`.

------------------------------------------------------------
API Usage
------------------------------------------------------------

### Endpoint: `/api/apply-rule`

This endpoint applies one of three rules (1, 2, or 3) to a list of items and returns the discounted and payable items based on the selected rule.

#### Request

Send a POST request to `http://127.0.0.1:8000/api/apply-rule` with the following JSON payload in Postman:

Rule 1 
```json
{
    "items": [10, 20, 30, 40, 50, 60],
    "rule": 1
}
```

Rule 2	
```json
{
    "items": [10, 20, 30, 40, 40, 50, 60, 60],
    "rule": 2
}
```

Rule 3 
```json
{
    "items": [5, 5, 10, 20, 30, 40, 50, 50, 50, 60],
    "rule": 3
}
```