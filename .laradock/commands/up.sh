#!/bin/bash
#
# The laradockctl command to start up a development environment.

set -Ceuo pipefail

local NAME='up'
local DESCRIPTION='Start up a development environment'

handle() {
  source "$(laradockctl_command_path up.sh)"
  handle

  # Set environment variables to configure the testing environment
  sed -i 's/name="DB_HOST" value=""/name="DB_HOST" value="mysql"/g' ../phpunit.xml
  sed -i 's/name="DB_DATABASE" value=""/name="DB_DATABASE" value="test"/g' ../phpunit.xml
  sed -i 's/name="DB_USERNAME" value=""/name="DB_USERNAME" value="root"/g' ../phpunit.xml
  sed -i 's/name="DB_PASSWORD" value=""/name="DB_PASSWORD" value="root"/g' ../phpunit.xml
}
