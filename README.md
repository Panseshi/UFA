# UFA
Project Title
Description
This project is a simple example of using XAMPP for PHP development and Ngrok for testing a Telegram bot locally.

Requirements
XAMPP: Apache, MySQL, PHP, and Perl stack for local web development.
Ngrok: Secure introspectable tunnels to localhost.
Setup Instructions
Install XAMPP:

Download and install XAMPP from the official website.
Start the Apache and MySQL services using the XAMPP control panel.
Clone Repository:

Place your PHP files in the htdocs directory within the XAMPP installation folder.
Access your PHP projects via http://localhost/ in your web browser.
Configure Ngrok:

Download and install Ngrok on your machine.
Run Ngrok and create a secure tunnel to your local web server:
Copy code
ngrok http 80
Note the Ngrok URL (e.g., https://randomstring.ngrok.io) for testing your webhooks or APIs.
Usage
Use XAMPP for PHP development and hosting your local website or web applications.
Use Ngrok to expose your local server to the internet for testing webhooks, APIs, or Telegram bot integration.
Resources

create a db named ufa_holidays and import the sql
