# Variables
DOCKER_COMPOSE = docker-compose

# 📌 Main commands
.PHONY: up down restart logs build clean prune ps

# 🔼 Lifting containers in background mode
up:
	docker-compose up -d
	@if [ "$(action)" = "install-deps" ]; then \
		$(MAKE) install-deps; \
	fi

install-deps:
	@echo "Installing PHP and JS dependencies in services..."
	# Install dependencies in kitchen
	docker-compose exec kitchen chmod +x install-deps.sh
	docker-compose exec kitchen ./install-deps.sh
	# Install dependencies in  warehouse
	docker-compose exec warehouse chmod +x install-deps.sh
	docker-compose exec warehouse ./install-deps.sh
	# Install dependencies in purchases
	docker-compose exec purchases chmod +x install-deps.sh
	docker-compose exec purchases ./install-deps.sh
	# Install dependencies in  notifications
	docker-compose exec notifications chmod +x install-deps.sh
	docker-compose exec notifications ./install-deps.sh

# 🔽 Switch off and dispose of containers
down:
	@echo "🛑 Switching off and disposing of containers..."
	$(DOCKER_COMPOSE) down

# 🔄 Restarting the containers
restart: down up

# 🔎 View real-time logs
logs:
	@echo "📜 Displaying logs..."
	$(DOCKER_COMPOSE) logs -f

# 🛠️ Rebuild images without using cache
build:
	@echo "🔨 Rebuilding all containers..."
	$(DOCKER_COMPOSE) build --no-cache

# 🧹 Delete persistent volumes and data (Beware, this deletes everything!)
clean:
	@echo "⚠️ Removing Docker volumes (this deletes the DB and Redis)..."
	$(DOCKER_COMPOSE) down -v

# 🗑️ Delete unused images and containers
prune:
	@echo "🧹 Cleaning up unused images, volumes and containers..."
	docker system prune -af --volumes

# 📋 See the containers in execution
ps:
	@echo "📌 Showing active containers..."
	$(DOCKER_COMPOSE) ps
