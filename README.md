# Pet Appointment Booking System

## Overview

Pet Appointment Booking System is a full-stack web application developed to manage online appointment scheduling for pets. The system allows users to submit appointment requests through a responsive booking interface, while administrators can manage and monitor appointment records through a dedicated admin panel.

The application was developed using PHP and MySQL for backend processing and database management, while HTML, CSS, Bootstrap, and JavaScript were used for frontend development. The project demonstrates complete integration between frontend and backend technologies for implementing workflow management and appointment tracking.

---

## Features

### User Module
- Online pet appointment booking
- Responsive appointment form
- Appointment status tracking
- User-friendly interface
- Real-time form validation

### Admin Module
- View all appointment requests
- Approve or reject appointments
- Manage appointment workflow
- Update appointment status dynamically
- Monitor booking records efficiently

---

## Technology Stack

### Frontend
- HTML5
- CSS3
- Bootstrap
- JavaScript

### Backend
- PHP

### Database
- MySQL

### Additional Technologies
- SQL Queries
- Session Management

---

## System Functionality

The frontend interface was designed using HTML, CSS, and Bootstrap to provide a responsive and user-friendly appointment booking system. Users can enter details such as name, appointment date, appointment time, and purpose of appointment through the booking form.

JavaScript-based client-side validation was implemented to ensure all required fields are properly filled and valid data is submitted. This validation reduces invalid form submissions and improves data accuracy.

On the backend, PHP was used to process form submissions and handle appointment management operations. Appointment details submitted through the form are captured using the POST method and stored in the MySQL database using SQL INSERT queries.

The database structure includes fields such as:
- Appointment ID
- User Name
- Appointment Date
- Appointment Time
- Purpose of Appointment
- Appointment Status

The appointment status field is used to track whether the request is Pending, Approved, or Rejected.

An admin panel was developed to manage appointment requests efficiently. Administrators can view all submitted bookings using SQL SELECT queries and update appointment status using SQL UPDATE operations. This workflow allows proper management and monitoring of appointment requests.

The system also provides appointment status visibility to users so they can track the current state of their booking request in real time.

---

## Database Operations

The project uses MySQL as the database management system. The following SQL operations were implemented:

- INSERT – Store appointment details
- SELECT – Fetch appointment records
- UPDATE – Modify appointment status
- DELETE – Remove appointment records if required

---

## Security and Validation

- Client-side form validation using JavaScript
- Input field verification
- Session-based admin management
- Controlled appointment workflow
- Status-based appointment tracking

---

## Development Environment

The project was developed using Visual Studio Code as the primary code editor for frontend and backend development.

### Tools and Software Used

- Visual Studio Code – Source code editor
- XAMPP – Local server environment
- phpMyAdmin – Database management
- Bootstrap – Responsive UI framework

---

## Installation and Setup

1. Install XAMPP on your system.
2. Start Apache and MySQL services from XAMPP Control Panel.
3. Copy the project folder into the `htdocs` directory.
4. Import the database file into phpMyAdmin.
5. Open the project in Visual Studio Code.
6. Run the project in browser using:

```bash
http://localhost/pet-appointment-booking-system