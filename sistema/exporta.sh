#!/bin/bash
#/usr/local/mysql/bin/mysqldump \
#-uroot \
#-ppyc89w \
#--databases test > \
#/rede/www/html/intranet/imobiliarias/murask/venda/bd_test.txt
#
#/usr/local/mysql/bin/mysqldump \
#-uroot \
#-ppyc89w \
#--databases Sistema > \
#/rede/www/html/intranet/imobiliarias/murask/venda/bd_Sistema.txt
#
#
#/usr/local/mysql/bin/mysqldump \
#             --databases test \
#             --all \
#             --extended-insert \
#             --quote-names \
#             --host=localhost \
#             --complete-insert \
#             --user=root \
#             --password=pyc89w \
#             --set-charset=latin1 \
#             --default-character-set=latin1 > \
#             /rede/www/html/intranet/imobiliarias/murask/venda/bd_test.txt
#
/usr/local/mysql/bin/mysqldump \
             --databases Sistema \
             --tables area rel_area_usuario usuarios \
             --all \
             --extended-insert \
             --quote-names \
             --host=localhost \
             --complete-insert \
             --user=root \
             --password=cl@#d1rm#r@sk1 \
             --set-charset=latin1 \
             --default-character-set=latin1 > \
             /rede/www/html/intranet/sistema/tabelas_atualizadas_usuarios.txt
