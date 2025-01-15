1 - Create the Database and Tables
Copy the SQL code provided in the sql/db.sql file and paste it into your SQL tool (e.g., phpMyAdmin, MySQL Workbench, or a command-line interface) to create the database and tables.

2 - Configure Database Connection
If the connection doesn't work, check the includes/db.php file. Ensure the following details are correct:
Host: Typically localhost.
Port: Default is 3306, but if you're using a custom port, update it accordingly.
Database Name: The name you provided in the SQL script.
Username and Password: Ensure they match your local MySQL setup.

3 - Start Your Server Environment
Make sure you have XAMPP or WAMP installed.
For XAMPP:
Open the XAMPP Control Panel.
Start the Apache and MySQL services.
For WAMP:
Launch WAMP and ensure the icon in the taskbar turns green, indicating all services are running.

4 - Start the Server
Place the project folder in the htdocs folder (for XAMPP) or the www folder (for WAMP). Open your browser and visit: http://localhost/your-project-folder-name

5 - Simulate a Match
Navigate to the Simulate Match page in the application. Select two teams and click on the "Simulate" button. The result will be saved to the database and displayed on the screen.

6 - Check Match History and Rankings
Go to the Historique des matches page to view a list of previously played matches.
Visit the Classement page to see team rankings based on their performance.

7 - Customize Your Project
To modify the design, edit the CSS files located in the css folder.
Update logos or other assets in the assets folder.

Notes : 
Ensure your server environment supports PHP and MySQL.
For alerts, the project uses SweetAlert2. Check their documentation for customizations.

Congratulations on setting up the League Manager project! 🚀
Feel free to explore and expand its features. If you encounter any issues or have ideas for improvements, don’t hesitate to contribute. Enjoy managing your league! ⚽
