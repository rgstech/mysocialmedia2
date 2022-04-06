use mysocialmedia;
-- example of query used in main page's search bar
--exemplo da querie usada na search bar da pagina home
select  c.com_pk_id  as cid,   
        c.com_text   as texto,
        c.com_dt_com as data,
        u.usu_pk_id  as uid,
		u.usu_nome   as nome,
        u.usu_img    as image,
        p.pst_pk_id  as pid,
        ( select count(*) from tblike l2
          where l2.lik_fk_com = c.com_pk_id ) as qtdlike        
from tbcomment c 
        join tbpost p on p.pst_pk_id = c.com_fk_pst
        join tbusuario u on c.com_fk_usu = u.usu_pk_id
where c.com_text like  "%Oi!%"  
                                 
                            
                            
                            
                      
