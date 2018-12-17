COM_COLOR = \033[0;34m
OBJ_COLOR = \033[0;36m
OK_COLOR = \033[0;32m
ERROR_COLOR = \033[0;31m
WARN_COLOR = \033[0;33m
NO_COLOR = \033[m
ABORT_MSG = \n==========\nAnnulation\n
SUCCESS_MSG = \n========\nSuccès !\n

deploy: .env.prod .git
	@if [ -z "$(SITE_PATH)" ]; then\
		echo -e "\n$(ERROR_COLOR)Erreur : Le chemin vers le site sur le serveur n'est pas spécifié. Vérifier .env.dev"; \
		echo -e "$(ERROR_COLOR)$(ABORT_MSG)$(NO_COLOR)"; exit 1; \
	fi
	@echo -e "$(WARN_COLOR)"
	@read -p "Transférer le dossier vers $(SITE_PATH) ? Cela va modifier le dossier du site public ! ([O]ui/[N]on) " yn; \
	case $$yn in \
		[oO])  echo -e "\n$(COM_COLOR)Transfert du dépôt local vers le serveur...$(NO_COLOR)"; \
			echo -e "rsync -rlPv -e "ssh -p $(SSH_PORT)" --delete --exclude-from .rsyncignore . $(SSH_USER)@51.75.246.250:$(SITE_PATH)"; \
			rsync -rlPq -e "ssh -p $(SSH_PORT)" \
			--exclude .git \
			--exclude .gitignore \
			--exclude Makefile \
			--exclude .env \
			--exclude .env.prod \
			--exclude .vscode \
			--delete --info=progress0,stats . $(SSH_USER)@51.75.246.250:$(SITE_PATH) $$i; \
			if [ $$? -ne 0 ]; then echo -e "$(ERROR_COLOR)\nErreur : le transfert des fichiers a échoué.\n$(ABORT_MSG)$(NO_COLOR)"; exit 1; fi; \
			echo -e "$(OK_COLOR)$(SUCCESS_MSG)$(NO_COLOR)"; \
			break;; \
		*)  echo -e "$(ERROR_COLOR)$(ABORT_MSG)$(NO_COLOR)"; \
			break;; \
	esac;

.PHONY: server deploy
include .env.prod