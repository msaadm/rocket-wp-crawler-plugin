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
activation/deactivation of the plugin respectively. Then I created admin
page to list all the links. Then created a Crawler Class which can fetch the
homepage and parse it to get all the internal links and return these.

To Parse the homepage, I used DomDocument, load the HTML, fetch all the links
and filter the links which start with domain.

I created a File Management Class by which we can create Homepage
and Sitemap. Also, it can delete Homepage and Sitemap.

I updated Admin Page class to create a button to trigger ajax which start
the process which crawls, get_links, save links to db, save homepage, and
generate sitemap.

Also Updated DB Class to add methods for insert links, delete rows and
get all rows, then I fetched rows and showed in the table on the admin page.

Lastly I created the Cron class, and trigger it on the Click of the button on
Admin page.

### The technical decisions you made and why.
For me using Oops is quite helpful, first it divides the code, which is
easier to manage, secondly later in time, if someone want to upgrade the plugin,
it's also easier for him by using traits or inheritance.

I create 5 classes in total, but I used static functions in all of them.
The reason for that is that it's easier to use it in hooks and calling it.
I resist to make normal classes because I didn't find any properties, which I
should use. Also In normal class way, I need to create objects for all classes
as well.

I can use trait or helper functions in a single file, but again that will
scramble the code, mix things together.

### How your solution achieves the admin’s desired outcome per the user story
Admin will install the plugin, and activate it. Once it's done, he/she will be
able to see a "Rocket WP Crawler" menu as a submenu under "Settings" menu, on
the left hand side menu in Admin.
After clicking on it, it will take him to the screen, where he/she can start
the crawler by clicking the Blue Button "Crawl Now".

This action will Start the Crawler and also Scheduled it to run hourly. This
action will save homepage, and generate a sitemap at root of wp site.
And store all the internal links in the database, which will be shown in the
table on Admin page.

Also, I implemented Unscheduler as well. Like after sometime, admin wants to
deactivate the cron, he/she can come again to the page and click the blue 
button "Remove Crawler Cron", and Voilla! cron will be disabled.
