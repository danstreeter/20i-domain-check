# 20i Domain Check
_**A Docker image to utilise the 20i Domain Check API and return domain availability.**_
Runs a domain availability check against the 20i reseller API and returns an order link if the domain is available, or the expiry date if already registered.

## Motivation
To speed up the checking of domain name availability, ideally from the command line with little 'up front' requirements to perform and get a rapid and easy to read reply.

## Requirements
 - **An active 20i Reseller Account**
 - Your 20i API Key
 - Docker
  - _(Although the script could be used without Docker if needed)_

## Getting Started
### 20i API Key
API keys can be retrieved from [https://my.20i.com/reseller/api](https://my.20i.com/reseller/api). The key required is the 'General API Key'.

### Environment Variable
This image relies on an environment variable of your API key being present to work.
Adding the following to your system profile file, `.bash_profile` or `.oh-my-zsh` in my case.
```
export TWENTYIAPIKEY="api_key_from_20i"
```
This then allows you to run the container as an alias on your system, pulling in your API key from env vars.

## Quick Run
Once the environment variable is set, you can now run the container with the following:
```
docker run --rm danstreeter/20i-domain-check domainname.co.uk
```

### Alias Setup
To make this even easier, the following alias can be added to your `.bash_alias` or equivelant file:
```
alias domaincheck='docker run --rm danstreeter/20i-domain-checker $TWENTYIAPIKEY '
```