### CV-Creator
Website used to create CVs, with a set of templates to use

COP 4331 Fall 2017

Team 8

� Daquaris Chadwick
� Timothy Deligero
� Kaike Ferreira
� Avinash Kumar
� Kevin Negy
� Joshua Pollmann


### Setup Instructions:
1) Download CV Creator repository from github using https://github.com/GearTech0/CV-Creator.git
2) Download MAMP (free) at this website https://www.mamp.info/en/
3) Open MAMP and click on Preferences. 
	-under the Web Server tab, select for the "Document Root" to be the directory where CV creator is saved (the same folder as this README)
	-Note: if default MAMP Port Settings do not work, you must manually change your MAMP ports to open ports on your computer.
4) Once you click ok on MAMP settings, both the Apache Server and MySQL Server status squares in the top left corner of MAMP should be filled in.
5) Open an internet tab and in the url bar type "localhost" and press enter. The CV creator website should appear.

### Admin Usage:

	To create admin:
1) Assuming no user has been created or to create a new admin user, create one using the home CV Creation login page. Otherwise, skip to next step.
2) In a new browser tab in the URL type "localhost/MAMP" and press enter.
3) On the left side of the MAMP page under the "MySQL" header, there is a link called "phpMyAdmin". Click this link.
4) On the left side there is will be a list; click on the "test" listing. Then click on the "users" sub-listing.
5) The users will be printed on screen with options to edit each of them. Click "edit" on the desired user.
6) In the Admin row, change the value from 0 to 1. Admin status will now be true. Press "Go" at the bottom.
7) Back on the CV creation page, logout and log back in. There will be a new link on the homepage titled "Admin Tools".

	Admin features:
1) View all users and admin rights.
2) Add a user directly.
3) Update user password and/or admin rights.
4) Delete a user from the system.

### Customer Usage:

1) Create a username and password to create a user account. Login.
2) Homepage options:
	-View Templates	  - shows template styles to choose from for CV
	-Upload Templates - allows the user to create a template (using template language, described below) for future use.
	-Create CV 	  - asks the user for CV information and template style to generate CV
		Note: after inputting CV information and choosing template, clicking "Create" will create and save the CV.
	-Edit Existing CV - if the user has saved any CVs, they can edit them here
	-View Saved CV 	  - shows any saved CVs for re-download.


