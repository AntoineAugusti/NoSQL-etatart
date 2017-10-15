all: compil clean

compil:
	pdflatex -shell-escape tp.tex
	pdflatex -shell-escape tp.tex
	pdflatex -shell-escape correction.tex
	pdflatex -shell-escape correction.tex

clean:
	rm -f tp.aux correction.aux
	rm -f tp.fdb_latexmk correction.fdb_latexmk
	rm -f tp.log correction.log
	rm -f tp.nav correction.nav
	rm -f tp.out correction.out
	rm -f tp.snm correction.snm
	rm -f tp.synctex.gz tp.correction.gz
	rm -f tp.toc correction.toc
	rm -f tp.pyg correction.pyg
