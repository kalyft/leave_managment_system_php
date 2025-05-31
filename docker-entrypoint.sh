#!/bin/bash
# Start Apache in background
apache2-foreground &

# Keep container running
tail -f /dev/null