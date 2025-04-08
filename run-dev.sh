#!/bin/bash

docker run --rm -d -p 8000:8000 -v ./:/webapp --network host php-app
