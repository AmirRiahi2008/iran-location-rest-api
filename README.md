# iran-location-rest-api

A simple and powerful RESTful API built with vanilla PHP to manage **cities** and **provinces** in Iran, featuring JWT-based authentication and file-based caching.

> 🔐 Perfect for educational use, real-world practice, and microservices.

---

## 🚀 Features

- ✅ Full RESTful architecture (GET, POST, PUT, DELETE)
- ✅ Province and city management
- ✅ JWT authentication
- ✅ Pagination, sorting, and filtering
- ✅ File-based cache system for GET requests
- ✅ Built with plain PHP – no framework needed
- ✅ Clean and minimal folder structure

---

## 📦 Tech Stack

- PHP 8+
- MySQL
- [`firebase/php-jwt`](https://github.com/firebase/php-jwt) for token authentication


---

---

## 🧪 How to Use

Follow these steps to authenticate and interact with the API:

### ✅ 1. Generate JWT Token

Before calling any protected endpoints, you must obtain a JWT token using a predefined user email.

**Request:**
```http
POST /api/get_api_key.php
Content-Type: application/json

{
  "email": "sara@7learn.com"
}
```
```
GET /api/v1/cities/index.php?province_id=1&page=1&page_size=5
```
```
POST /api/v1/cities/index.php
Content-Type: application/json
Authorization: Bearer your.jwt.token

{
  "name": "Mazandaran",
  "province_id":40
}
```
```
PUT /api/v1/cities/index.php
Content-Type: application/json
Authorization: Bearer your.jwt.token

{
  "city_id": 7,
  "city_name": "New Gorgan"
}
```
```
DELETE /api/v1/cities/index.php?city_id=7
Authorization: Bearer your.jwt.token
```


