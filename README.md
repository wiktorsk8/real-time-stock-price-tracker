# Real-time Stock Price Tracker

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![Docker](https://img.shields.io/badge/docker-ready-brightgreen)

A simple Laravel application that shows real-time Bitcoin prices and trades. Users can register and immediately access a dashboard with live data.  

---

## Table of Contents

- [Installation](#installation)
- [How to Run](#how-to-run)
- [After Container Build](#after-container-build)
- [Usage](#usage)
- [License](#license)

---

## Installation

This application uses Docker Compose for container management.  
Before proceeding, make sure you have [Docker](https://www.docker.com/products/docker-desktop) installed.

---

## How to Run

First, grant execution permissions to the run script and start the containers:

```bash
chmod +x run.sh
docker compose up -d
```

---

## After Container Build

Once the container build process is finished, run the database migrations:

```bash
docker exec -it laravel-app php artisan migrate
```

> **Note:** Ensure the container is fully built before running the migrations.

---

## Usage

1. Open your browser and go to [http://localhost:8000/](http://localhost:8000/).
2. Click on **Register** to create a new user account.
3. Upon successful registration, you should be redirected automatically to your **/dashboard**.
4. On the dashboard, view real-time BTC price updates and latest trades.

### Common issues
- **Important:** Your password must be at least **8 characters long**.  
  Otherwise, the `/register` endpoint will return a 302 redirect back to the same page because of missing frontend validation handling.

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
