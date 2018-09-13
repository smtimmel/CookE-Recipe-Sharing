# Project Description

CookE is a recipe sharing web application in which users can post their own recipes online and can view other users recipes.  The application begins on the login screen in which a valid username and password are required to enter the main application.
The initial page also contains a create account page which takes the user to a form for creating a username. Any unique username and other non empty details are allowed for account creation.  The sql provided does not insert any data into the system, 
but the first account made will be an admin account.  Subsequent accounts created are not admin accounts.  Once the user logins in (discussing components relevant to both general and admin accounts) the user will be on their home page which will show 
them all their created recipes.  Each recipe can be favorited, which increments the favorited count of the recipe.  Whenever recipes are displayed, they are displayed from most to least favorited. The favorited recipe is then available when the user clicks the 
My Favorites link which displays all recipes they have favorited along with a link back to their home page.  Also when dealing with the recipe items, a delete button will be available for recipes which the user has created.  This will delete the recipe.
The home page also has a search feature which allows users to search for any users recipes by either the recipe name, the name of the user, or the ingredient in the recipe.  The results are displayed on a page with a link to the home page.  The home page also 
contains a link to an add recipe form.  The form takes the name of the recipe, has a table of component inputs (Quantities, Measurements, Ingredients) and a sequence of inputs for recipe steps.  When opening the empty form the default amount of 
table and step values are 5.  The form is dynamic in that a new input slot can be added or removed at any position in the form.  This is done by selecting the appropriate task and slot position on the page for the addition/removal. When selecting the task
to add the recipe, if everything was filled out and validated, the recipe will be created.  When viewing recipes there is also a template option which loads all the values of the selected recipe back into the add recipe form to allow for edits and recreations.
All pages have a logout link which logs the user out.  When using the admin accounts, REST API becomes available for search and account objects. For searches use /rest.php?format='entertype'&action=searches in the url (will not work for non admin accounts).
For accounts use /rest.php?format='entertype'&action=accounts&admin='entervalue' where the value corresponds to if the account are admin accounts or not ('y' for admin, 'n' for not admin).  Extra links will also be available to the admin.  The admin will
be able to see a table of accounts from which they can delete non admin accounts and make non admin accounts into admin accounts.  The admin could also see a table of search queries sorted from most to least popular of all users. 

The database name and credentials are as follows: dbname=cs602termproject', username = 'cs602_user', password = 'cs602_secret';
