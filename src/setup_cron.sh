#!/bin/bash
&nbsp;
&nbsp;

# This script sets up a cron job to run cron.php every 24 hours
(crontab -l 2>/dev/null; echo "0 * * * * /usr/bin/php /path/to/your/src/cron.php") | crontab -
echo "Cron job set to run cron.php every 24 hours."
