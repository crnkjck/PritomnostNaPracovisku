#!/bin/bash

set -eu
exec 2>&1

scriptdir="$(realpath -- "$(dirname -- "$0")")"
scriptname="$(basename -- "$0")"
declare -a params
params=(tmpdir jobname printer_host printer)

usage() {
    echo "Usage: $scriptname ${params[@]} [printer_option...]" >&2
    echo "Missing $1" >&2
    exit 1
}

for var in ${params[@]}; do
    [ "$#" -ge 1 ] || usage "$var"
    eval "$var=\"\$1\""
    shift
done

cd "$tmpdir"
pdflatex -jobname "$jobname" -interaction batchmode -no-shell-escape \
    "$scriptdir/dovolenkovy-listok.tex" > /dev/null
lp -h "$printer_host" -d "$printer" "$@" -- "$jobname.pdf" | \
    grep -o "$printer-[1-9][0-9]*"
cd - > /dev/null
rm -r "$tmpdir"
