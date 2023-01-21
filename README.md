## About Junior Team Forums
Junior Team Forums is a simple forum software created as a trial for Senior Team.

## Installation Instructions
To install this application, you'll need to spin up a VPS, I recommend using Linode.

You can also install this on shared hosting, though will require some additional setup, see this guide [here](https://laravelarticle.com/deploy-laravel-on-shared-hosting)

### Setup the Application
I recommend using [this script](https://github.com/Yiddishe-Kop/server-setup) to install and setup the application.
If you'd like to do this manually, I recommend Digital Oceans guide: https://www.digitalocean.com/community/tutorials/how-to-install-and-configure-laravel-with-nginx-on-ubuntu-20-04

Once you've installed and setup the app, please run the following command from your application directory:
``` 
php artisan system:setup
```

This will setup the databases, roles and permissions and create an admin user for you.
