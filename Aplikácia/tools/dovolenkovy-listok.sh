#!/bin/bash

set -eu
exec 2>&1

TEXFNAME="dovolenkovy-listok.tex"

scriptdir="$(realpath -- "$(dirname -- "$0")")"
scriptname="$(basename -- "$0")"

declare -a params
params=(printer_host printer jobname)
texparams=(meno priezvisko osobnecislo utvar cisloutvaru rok dovolenkaod dovolenkado dovolenkadni datum)
allparams=(${params[@]} ${texparams[@]})

usage() {
    echo "Usage: $scriptname ${allparams[@]}" >&2
    echo "Missing $1" >&2
    exit 1
}

for var in ${allparams[@]}; do
    [ "$#" -ge 1 ] || usage "$var"
    eval "$var=\"\$1\""
    shift
done

texcmds=""
for param in ${texparams[@]}; do
    eval "texcmds=\"\$texcmds\\newcommand\\\\\$param{\$$param}\""
done
texcmds="$texcmds\\input{$TEXFNAME}"

tmpdir="$(mktemp -d "$TMPDIR/pritomnost.$jobname.XXXXXXXX")"

cd "$tmpdir"
# TeXu sa nepacia cesty k suborom v kodovani UTF-8
ln -s "$scriptdir/$TEXFNAME" "$TEXFNAME"
pdflatex -jobname "$jobname" -interaction batchmode -no-shell-escape "$texcmds" > /dev/null

lp -h "$printer_host" -d "$printer" \
        -o PageSize=A6 -o InputSlot=MultipurposeFeeder -o landscape \
        "$jobname.pdf" | \
    grep -o "$printer-[1-9][0-9]*"

cd - > /dev/null

rm -r "$tmpdir"
