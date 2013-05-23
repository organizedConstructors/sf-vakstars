set :application, "VAKStars"
set :domain,      "zoltanadamek.com/vakstars/"
set :deploy_to,   "/public_html/vakstars"
set :app_path,    "app"

set :repository,  "https://github.com/organizedConstructors/sf-vakstars.git"
set :scm,         :git
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Symfony2 migrations will run

set  :keep_releases,  3
set  :use_sudo,      false

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL