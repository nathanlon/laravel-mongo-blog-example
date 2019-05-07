# A Blog in Laravel & MongoDB

This blog is not complete, but a quick coding exercise to demonstrate the use of Laravel and MongoDB.

## Getting Started

To install you will need MongoDB and PHP 7.2. Composer will also need to be installed and run to install dependencies.

Add a .env file in the root, copying .env.example. Be sure to configure Mongo database credentials, eg:

```
DB_CONNECTION=mongodb
DB_HOST=localhost
DB_PORT=27017
DB_DATABASE=blog
DB_USERNAME=root
DB_PASSWORD=password
```

### First Visit

When you view the homepage, it will be blank, you need to register as an admin in the top right under "Admin Area", then
 "Register".
You can then log in and create a post, specifying a tag.

### Things left out

Because this was a quick test project, there are many things left to be done. These include:

- Would add validation for size and content on the forms (javascript).
- Would break the "posts.index" template into a separate one for year, month, tag display.
- Would add Year and Month indexing to allow for Archives nav on the right. The models are there but have not been wired
   in. Some routes have been commented out for this.
- Would conditionally show Login when on register and Register when on login.
- Would take away the ability to register for an existing blog, and associate a new blog to a new user as currently 
   can register in and pick up the existing blog. Register route could also be stopped upon finding one user, to make
   this code for a single blog only.
- Would show who you are logged in as.
- Would add validation on the models (to avoid javascript and form tampering - there is csrf there though.
- Would make the gui for adding tags more like a pill type down, and prevent the same tag from being made twice.
- Would remove tags that are no longer used by any posts when posts are deleted.
- Would add a factory for creating the post from the model.
- Would allow update of the date of the post when editing the post.
- Would use a WYSIWUG editor for editing (currently raw HTML).
- Would add pagination for when posts past 100.
- Would add functional end-to-end tests alongside the unit tests.
- Would look at testing the repositories.
- For unit tests, would make fixtures for populating data to use on test.
- Would log all exceptions.
- Would put PAGINATION_LIMIT and some other things in an environment variable.
- Would get previous and next post working when jumping directly to a post (only works when going from homepage (buttons below post).
- Would get next button to be disabled when no more pages. Currently fails with error.
- Would allow forgot password to work as email is not configured.
- Would use SASS for making CSS.
- Would add code standard tests that get run.
- Everything like phpunit would be run through ant or similar so I can run code standard tests and linting as well.
- Git hooks to check for code standards before committing.
- Image uploading and cropping to populate a picture for each post would be good.
- Vue.js support for displaying blog entries in a popup when on the post list against a tag.

## Running the tests

Under vendor/laravel/framework/src/Illuminate/Foundation/Testing/TestCase.php for setUp and tearDown methods, add ": void" to end of method declaration lines for tests to work.

Tests can be run by running phpunit on the command line at the root.

### Code Design Decisions

There is a frontend controller for display of posts, and a backend controller for CRUD of posts. These could have been
 combined, but I thought it best to keep them logically under /admin for admin and / for public, and one can then have
 global authentication on the controller.

Controllers have been kept light and basic. The only code in a controller relates to pulling out request data. 
 A PostService and TagService is quickly passed to for most operations.
 
The Service always abstracts database operations to a repository, so the service can be tested. A side benefit is that if
 we decided to move from MongoDB to mysql it would be less effort and most tests would still run.

Repositories have not been unit tested as this would take a lot more understanding of Mongo than I currently have.
 Some would choose to leave Repositories to be covered only by end-to-end tests as mocking becomes hard and brittle.

A model folder contains models for passing values between methods without having a large list of parameters. This can be
more easily refactored without needing to modify parameters in method calls. They are not database models and
are never persisted.

A PostServiceProvider was added, but this could have been put in AppServiceProvider.

A standard Bootstrap4 Blog template was utilised to create a quick design for this demo.

A fair bit of time was involved in learning the Laravel framework and MongoDB, as I am more used to Symfony and MySQL,
but it was good to get a many to many relationship for the tagging, which was something extra.

I could have added Vue.js support as I have used this before, but I felt that learning 3 things at once in a limited
time was a bit much.

Method doc-blocks are mainly left out as the goal is to type hint as much as possible, and make method names explain
themselves. My experience is that doc-blocks often become out of date and less helpful over time, but I understand when
they should be used when auto-generating api documentation, or if in a coding standard.

Exception classes have been added to allow throwing and catching of these in the controller with knowledge that the
Service exception messages can be shown to the user as they are safe and often
catching more generic exceptions like RepositoryException or \Exception.

Interfaces are used for all services and repositories so the Dependency Injection can use this. I understand that this
is a hotly contested difference of opinion for different developers as to how interfaces should be used, and so I'm open
to adopting any coding standards here.

Some methods and model classes (namely Year and Month) are unused and so commented at the bottom. This would
usually be removed before commit but this is a work in progress.

## Authors

* **Nathan O'Hanlon** - [GitHub](https://github.com/nathanlon)

## License

This project is licensed under the MIT License.

