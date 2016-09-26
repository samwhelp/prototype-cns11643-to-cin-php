
THE_MAKEFILE_FILE_PATH := $(abspath $(lastword $(MAKEFILE_LIST)))
THE_BASE_DIR_PATH := $(abspath $(dir $(THE_MAKEFILE_FILE_PATH)))
THE_BIN_DIR_PATH := $(THE_BASE_DIR_PATH)/bin

.PHONY: usage cin asset

usage:
	$(THE_BIN_DIR_PATH)/usage.sh

cin:
	$(THE_BIN_DIR_PATH)/cin.php

asset:
	$(THE_BIN_DIR_PATH)/asset.sh
