all : before compil clean

before:
	rm -f bdAujourdhui.pdf

clean:
	rm -f bdAujourdhui.mtc*
	rm -f bdAujourdhui.toc
	rm -f bdAujourdhui.maf
	rm -f bdAujourdhui.bbl
	rm -f bdAujourdhui.blg
	rm -f bdAujourdhui.pyg
	rm -f *.aux *.log *.out *.snm *.nav

compil: bdAujourdhui.pdf

bdAujourdhui.pdf:
	pdflatex -shell-escape bdAujourdhui.tex;
	pdflatex -shell-escape bdAujourdhui.tex;
