all : compil clean

clean :
	rm rapport.mtc*
	rm rapport.toc
	rm rapport.maf

compil: rapport.pdf

rapport.pdf : 
	pdflatex -shell-escape rapport.tex && pdflatex -shell-escape rapport.tex && rm -r *.aux *.log *.out
