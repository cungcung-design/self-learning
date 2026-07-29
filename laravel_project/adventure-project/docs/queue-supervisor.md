# Queue Worker - Production Supervisor Config

Use Supervisor to keep Laravel queue workers running continuously in production.

## Install Supervisor

```bash
sudo apt-get update
sudo apt-get install supervisor
```

## Create config

Create `/etc/supervisor/conf.d/adventure-queue.conf`:

```
[program:adventure-queue-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
numprocs=2
directory=/path/to/your/project
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/queue-worker.log
stopwaitsecs=3600
```

## Update and start

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start adventure-queue-worker:*
```
