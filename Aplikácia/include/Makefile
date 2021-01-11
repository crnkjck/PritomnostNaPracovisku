SUMS =  ../script/main.js.sha1 ../style/main.css.sha1

all:	sha1sums.php

.PHONY: all clean

clean:
	rm $(SUMS)

sha1sums.php: $(SUMS)
	{ echo "<?php \$$sha1sums = array("; \
	  cat $^ | sed 's/^\([0-9a-f]*\)\s*\(.*\/\)\?\(.*\)/\t"\3" => "\1",/'; \
	  echo ");"; } > '$@'

%.sha1: %
	sha1sum '$<' > '$@'
