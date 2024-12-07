# Homeowner Parser

## Overview
The **Homeowner Parser** is a PHP application that processes homeowner data from a CSV file. It parses names, splits multiple homeowners into individual records, and structures the data for easy access.

The application supports:
- Titles like `Mr`, `Mrs`, `Dr`, `Prof`, `Miss`, and `Mister`.
- Hyphenated last names (e.g., `Hughes-Eastwood`).
- Multiple homeowners in one field (e.g., `Dr & Mrs Joe Bloggs`).
- Complex combinations like `Mr Tom Staff and Mr John Doe`.

---

## Features
- **CSV Parsing**: Reads and processes homeowner data.
- **Name Splitting**: Splits names into structured fields:
  - `title`
  - `first_name`
  - `initial`
  - `last_name`
- **Handles Edge Cases**:
  - Hyphenated last names.
  - Multiple homeowners in one field.
  - Conjunctions like `and` or `&`.

---

## Running the Project

You can run the project using **Docker** or **Composer**. Choose the method that works best for your environment.

### Run with Docker

1. Build the Docker image:
   - Run the command: `docker-compose build`.

2. Start the application:
   - Run the command: `docker-compose up`.

3. Access the application:
   - Open your browser and go to: `http://localhost:8000`.

4. Stop the application:
   - Run the command: `docker-compose down`.

---

### Run with Composer

1. Install dependencies:
   - Ensure Composer is installed.
   - Run the command: `composer install`.

2. Start the PHP server:
   - Run the command: `php -S localhost:8000 -t public`.

3. Access the application:
   - Open your browser and go to: `http://localhost:8000`.

## Prerequisites

### For Docker
- Docker must be installed on your system.
- Docker Compose must be installed.

### For Composer
- PHP 8.1 or higher must be installed on your system.
- Composer must be installed globally.

### For Local Setup
- A web browser to access the application.
- Access to a terminal or command prompt for running commands.