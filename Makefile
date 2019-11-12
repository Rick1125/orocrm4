dirs=data/mysql logs/mysql
all: $(dirs)
	@chown www-data.www-data var -R

$(dirs):
	@-mkdir -p $@
	@chown 999.docker $@

plugin:
	curl -fsSL https://raw.githubusercontent.com/MatchbookLab/local-persist/master/scripts/install.sh | sudo bash
image:
	docker build -t shu300/oro-crm4 .
