### AutomatedAttendanceSystem


# AUTOMATED ATTENDANCE SYSTEM

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://github.com/DestroyerAlpha/AutomatedAttendanceSystem/tree/master)
An automated attendance system for SSL Project 2019
## Steps to perform before using
- Give **MySql** credentials in sql_login/login.php for MySql connection.
- Run the website on localhost:8000/automate/automate.php.
## Login Page
- Enter login credentials for student/faculty/admin.
- Student and Faculty would get credentials from admin.

### Admin

- Admin can add a new student (by clicking at the **Add new student** button) and a new faculty (by clicking at the **Add new faculty** button) by entering detalis of a student and a faculty respectively.
- Admin can have an attendance data of a particular student by searching it by it's roll number/userid.
- In the page of a particular student, admin can get different excel sheets for that student which includes absent dates with course, present dates with course, total present and absent for a particular course just by clicking a **converttoxls**.
- **Defaulter List** gives list of students having attendance below 80%. It also has a feature to get that data in **.xls** format
- Attendance data for a particular course can be fetched by searching it by it's **course code**
- In page of data of a particular course, we can search attendance data for a range of dates by filling dates as asked. Invalid date entries would give an error (**Invalid Dates**).

### Student

- When a student logs into his/her account, he/she can has an option to register into a course whose details are already present on the page. If a student tries to register into a course he/she already registered, an error will pop up showing that the course is already registered.
- He/she can view his/her attendance in all the courses regstered with present percentage by clicking on **view attendance**.
- He/she can view dates on which he/she was absent/present for a particular course.


### Faculty

- When a faculty logs into his/her  account, he/she can float a course by entering what is asked for.
- He/she also has an option to delete the course if necessary.
- After floating, faculty can take attendance of any course he/she has floated by clicking onto **Add Attendance**.
- Faculty can also see attendance of any course by selection that course and clicking onto **View Attendance**. It will show total attendance of the class on a particular date and also gives a list of students who were absent/present on that day for that course.


### Log Out
- Everyone has a **Log Out** button to log out and move to home page.