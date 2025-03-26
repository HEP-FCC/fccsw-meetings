# fccsw-meetings

This PHP script publishes upcomming FCC Software meetings as a list, which can
be embeded in other web sites as `<iframe>` element.

Example of the usage can be seen at [FCC Software](https://fccsw.web.cern.ch)
webpage.

```
<iframe src="https://fccsw.web.cern.ch/fccsw-meetings/"
        title="FCC Software Meetings"></iframe>
```


## Local development

Install PHP, for RedHat based Linux distributions use:
```
dnf install php-cli
```

Run local server:
```
php -S localhost:8000
```


## Deployment

The script lives at
```
/eos/project/f/fccsw-web/www/fccsw-meetings/index.php
```
