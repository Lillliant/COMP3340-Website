# Installation Instruction

1. Upload the repository to your web server.
2. In the file `/assets/php/db.php` and `/assets/php/createDB.php`, update the database access information of your database.
3. Run `/init/init.php` to set up the database with sample data (optional).
4. You have now installed the website.

# Frontend
- Technologies used: HTML5, CSS, Bootstrap, JavaScript, JQuery/JQuery UI

# Backend
- Technologies used: MyWeb server, PHP 8.3

# Website Structure

## Pages

There are a total of 25 pages in this website, as outlined in the following list.
This does not include helper PHP files that help implement various website functionalities and common components:

1. Home page
2. Login page
3. Register page
4. User dashboard page (for both user/admin)
5. Search page (for searching tours)
6. Tour detail page
7. Tour booking page
8. Booking confirmation page
9. Manage booking page (user/admin)
10. Edit booking page (user/admin)
11. Manage tour page (admin)
12. Edit tour page (admin)
13. Add tour page (admin)
14. Manage user page (admin)
15. View profile page
16. Edit profile page
17. Edit password page
18. Website monitor page
19. About us page
20. Tour help page
21. Booking help page
22. User help page
23. Login/Profile help page
24. Reservation help page
25. 404 page

The 5 help wiki pages (#20-24) consists of 2 user help wikis and 3 admin help wikis.
They are context-sensitive: the admin wikis are only viewable to admin users.
The admin wikis also tells the admins how to update the website contents (i.e., the specific tour products and the associated images).

## Code

The following PHP and JavaScript file code are explained below. This section does not include the website pages:

- `tour/book.php`: help validate and insert booking information into the database while making a reservation.
- `login/signup.php`: validate registration information and insert new user account information into the database.
- `login/logout.php`: log out of the account and destroy the associated session.
- `login/auth.php`: check account information against database and initiate associated session variables upon success.
- `edit/role.php`: flip the role of the given user (e.g., make an admin user, make an user admin) given constraints.
- `edit/profile_validate.php booking_validate.php option_validate.php password_validate.php tour_validate.php`: validate data passed from the editing forms and change the associated records in the database.
- `edit/image.php`: flip the featured status of an image associated with a tour (a featured image is used when there is no image carousels).
- `edit/enable_tour.php`: enable a tour to be bookable.
- `edit/disable_tour.php`: disable a tour, cancel any ongoing bookings, and make future bookings impossible.
- `delete/booking.php image.php option.php tour.php user.php`: delete associated records from the database.
- `add/image.php option.php tour_validate.php`: validate data passed from the editing forms and add to the database.

# Future Directions

- Optimize PHP code: simplify the process of adding/editing/deleting from database using functions.
