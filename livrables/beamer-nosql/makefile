all: compil clean

compil:
	pdflatex -shell-escape slides.tex
	pdflatex -shell-escape slides.tex

clean:
	rm -f slides.aux
	rm -f slides.fdb_latexmk
	rm -f slides.log
	rm -f slides.nav
	rm -f slides.out
	rm -f slides.snm
	rm -f slides.synctex.gz
	rm -f slides.toc
	rm -f slides.pyg