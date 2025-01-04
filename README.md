# Task Management Application

This repository contains a simple Task Management Application with a **Laravel** backend and a **Next.js** frontend. The application allows users to fetch and display a list of tasks.

## Features

### Backend (Laravel)

- **API Endpoint**:
  - `GET /tasks`: Fetches a list of tasks (hardcoded or from a RethinkDB database).
- **Database Integration**:
  - Tasks can be stored and fetched from a RethinkDB database.
- **Custom Commands**:
  - `php artisan rethinkdb:migrate`: Creates the database and tasks table in RethinkDB.
  - `php artisan rethinkdb:seed`: Seeds the tasks table with sample data.

### Frontend (Next.js)

- Fetches tasks from the Laravel API.
- Displays tasks in a responsive list format with fields: **title**, **description**, and **status**.

## Getting Started

### Prerequisites

- Docker & Docker Compose installed.
- Node.js and npm/yarn installed (optional, if running the frontend locally).

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/2hmad/task-management-app
   cd task-management-app
   ```
2. Start the application using Docker Compose:
   ```bash
   docker-compose up --build
   ```
3. Access the services:

   API: http://localhost:8081/api/tasks

   Frontend: http://localhost:3000

## Backend (Laravel) Setup

The Laravel API runs in the api container. Environment variables for RethinkDB connection are defined in .env:

- DB_HOST=rethinkdb
- DB_PORT=28015
- DB_DATABASE=palm_outsourcing

To run migrations and seed data, use the following commands inside the api container:

```bash
docker exec -it api php artisan rethinkdb:migrate
docker exec -it api php artisan rethinkdb:seed
```

## Frontend (Next.js) Setup

The frontend is configured to fetch data from the Laravel API. The base URL is defined as:

```
NEXT_PUBLIC_API_URL=http://webserver:80
```

Access the frontend at http://localhost:3000.

## Project Structure

```bash
task-management-app/
├── backend/ # Laravel backend code
├── frontend/ # Next.js frontend code
├── nginx/ # Nginx configuration
├── docker-compose.yml
├── README.md
└── rethinkdb/ # Data volume for RethinkDB
```

## Approach

### Backend:

The Laravel API was created with hardcoded tasks initially.
An optional integration with RethinkDB was implemented for additional functionality.

Artisan commands (rethinkdb:migrate and rethinkdb:seed) were added to manage the database lifecycle.

### Frontend:

A single page fetches tasks from the API and displays them in a responsive list format.
Tailwind CSS is used for responsive design.

### Docker:

A docker-compose.yml file orchestrates services for RethinkDB, Laravel API, and Next.js frontend.

Health checks ensure services are initialized in the correct order.
