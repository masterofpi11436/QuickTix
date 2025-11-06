# Developer Stuff
composer install
npm install
php artisan key:generate
sudo /etc/init.d/apache2 stop
sudo /opt/lampp/lampp start
https://localhost/phpmyadmin

# QuickTix Ticketing Application Overview

This ticketing system aims to assist mid-sized companies to allow users to submit tickets, technicians record and complete tickets, controllers to assign tickets to technicians, and administrators to perform C.R.U.D on users, user roles, departments, areas, statuses, and ticket templates. There is a simple reporting system to show administrators statistics on tickets.

The application ships with no predefined areas, departments, statuses, or ticket templates. This simple application is designed to be modular to allow different organizations to use their own jargon.

- Administrators
    - Perform C.R.U.D. on users and reset passwords if the user cannot figure out how to click the reset password button.
        - C.R.U.D. fields for Users:
            - First Name (required)
            - Middle Initial 
            - Last Name (required)
            - Email (required)
            - Phone
            - Department
        - C.R.U.D. for Departments (defines the type of work IT, Maintenance, etc)
            - Name (required)
            - Description
        - C.R.U.D. for Areas (defines the areas a user can submit a ticket for. Office A, B, C, etc)
            - Name (required)
            - Description
        - C.R.U.D. for Statuses (defines the types of statuses tickets can have Open, Assigned, Closed, Pending, etc)
            - Name (required)
            - Color (required) (color for graphs and div cards in web page. Stored in Hex Value)
            - Is Completed (Ticket is marked as finished, done, closed, denied, duplicate etc)
        - C.R.U.D. for Ticket Templates (Must have at least 1 User, Department, Area, and Status to create)
            - Title (required)
            - Description (required)
            - Area (required)
            - Department (required)
    - View Reports
        - Report Types (sorted data by trade, area, technician, and status):
            - All Time
            - Quarterly
            - Monthly
    - Same privileges as Controller.
- Controllers
    - Similar to Administrators, but can only perform C.R.U.D. on users.
    - This account is primarily used to assign technicians tickets.
    - Same privileges as Technician

- Technician
    - View assigned tickets
    - Change the status of ticket. If ticket is marked as the status to close the ticket, it will disappear from the list
    - Same privileges as User

- User
    - Creates Tickets
    - Cancel Tickets (Will delete the ticket out of the system)
    