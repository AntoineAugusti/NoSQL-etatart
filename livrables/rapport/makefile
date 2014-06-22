all : compil clean

clean :
	rm rapport.mtc*
	rm rapport.toc
	rm rapport.maf
	rm rapport.bbl
	rm rapport.blg
	rm rapport.pyg
	rm *.aux *.log *.out

compil: rapport.pdf

rapport.pdf : 
	pdflatex -shell-escape rapport.tex;
	bibtex rapport;
	pdflatex -shell-escape rapport.tex;
	pdflatex -shell-escape rapport.tex;
