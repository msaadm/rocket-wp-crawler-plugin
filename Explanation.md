### The problem to be solved in your own words.  
First I read the requirements for task twice, so I can totally understand
what is needed in the plugin. So I found that I need a plugin which can
crawl the homepage to find all the internal links, store them in the db,
and list them on the plugin page. Also with the same links a sitemap
should be created and stored in the root of the site so google can index it.
Lastly when ever User start the crawl, it should be scheduled for an hourly
execution using cron. Also, it needs to store the homepage as homepage.html  

Whenever it executes again, it should delete all the links from db, and
remove the sitemap.html and homepage.html

### A technical specification of your design, explaining how it works.
First of all the given template was amazing with the most of the initial
things set up already, thank you for that. I follow the same naming
convention as the package offers for the Plugin class. Then I divide the
functionalities in 5 major parts which were DB, Admin, Cron, Crawl and
File Management. So I created separate classed for each one.

I started with the DB Management to create and remove table at the time of
activation/deactivation of the plugin. Then I created a basic admin page at
the moment. _(continues...)_

The main feature is crawler, so for that I was thinking to store the home page
and then parse the html to get the internal links and work through it.

### The technical decisions you made and why.
For me using Oops is quite helpful, first it divides the code, which is
easier to manage, secondly later in time, if someone want to upgrade the plugin,
it's also easier for him by using traits or inheritance.

### How your solution achieves the admin’s desired outcome per the user story
Admin will install the plugin, and activate it. Once it's done, he/she will be
able to see a "Rocket WP Crawler" menu on the left hand side menu in Admin.
After clicking on it, it will take him to the screen, where he/she can start
the crawler by clicking the Blue Button "Crawl Now".

This action will Start the Crawler and also Scheduled it to run hourly.
_(continues...)_
