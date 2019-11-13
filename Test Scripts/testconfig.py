import configparser


config = configparser.ConfigParser()
config.sections()


config.read('/var/www/credentials.ini')

test = config.get("credentials", "user")

print(test)
