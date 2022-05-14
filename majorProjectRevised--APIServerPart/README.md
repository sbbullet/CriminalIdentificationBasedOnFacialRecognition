### Setup

#### Optional

- setup heroku (`brew install heroku`)
- Use a python virtualenv

#### Required
- `pip install -r finalRequirements.txt`

### Run locally

IF YOU HAVE HEROKU:
- `heroku local`
IF NOT:
- `gunicorn -k eventlet -w 1 app:app --log-file=-`

if you want to use your own port replace '127.0.0.1:5150' with the host and port you want to use
- `gunicorn -k eventlet -w 1 -b 127.0.0.1:5150 app:app --log-file=-`


- in your browser, navigate to localhost:5000

### Deploy to heroku

- `git push heroku master`
- heroku open

### Common Issues

If you run into a 'protocol not found' error, see if [this stackoverflow answer helps](https://stackoverflow.com/questions/40184788/protocol-not-found-socket-getprotobyname).
