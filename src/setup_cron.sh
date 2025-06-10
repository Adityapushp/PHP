#!/bin/bash

CRON_JOB="0 0 * * * /usr/bin/php /path/to/your/repo/src/cron.php"

(crontab -l; echo "$CRON_JOB") | crontab -
echo "Cron job has been set up to run cron.php every 24 hours."
