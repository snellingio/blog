# Slack Alias

Someone told me the other day about Slack's `/remind` command, which is an awesome way to remind you to do simple things at pre determined intervals. However, were using the `/remind` command to remind them to check on long running builds and tests. 

What I do, is set up an [incoming webhook](https://api.slack.com/incoming-webhooks), and then use my Slack alias that I created. This allows me to send myself a notification when whatever task I was running is done, like so:

```sh
➜  ~ sleep 30 | slack 'Long running task complete!'
```

To do this, just modify the incoming webhook link and add the alias to your bash or `~/.zshrc` file:

```sh
alias slack='_slack() { curl -X POST -H "Content-type: application/json" --data "{\"text\":\" "$1" \"}" https://hooks.slack.com/services/T00000000/B00000000/XXXXXXXXXXXXXXXXXXXXXXXX }; _slack'
```

Enjoy!