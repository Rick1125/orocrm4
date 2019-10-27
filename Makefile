dirs=data/mysql logs/mysql
all: $(dirs)
	sudo chown www-data.www-data var -R

$(dirs):
	@-mkdir -p $@
	@sudo chown 999.docker $@

image:
	docker build -t shu300/oro-crm4 .
