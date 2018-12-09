/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  ODEG
 * Created: 8/12/2018
 */

insert into programas (idArea,ProgramaNombre,valor_mes)
values 
(
	(select id from areas where areas.AreaNombre  = 'Educación'),
	'PROGRAMA PLAN PADRINO',
	0
),
(
	(select id from areas where areas.AreaNombre  = 'Educación'),
	'PROGRAMA PLAN VALENTINA TE SONRÍE',
	0
),
(
	(select id from areas where areas.AreaNombre  = 'Educación'),
	'PROGRAMA DE APOYO INSTITUCIONAL',
	0
),
(
	(select id from areas where areas.AreaNombre  = 'Educación'),
	'PROGRAMA DE CAPACITACIÓN',
	0
)
;



insert into programas (idArea,ProgramaNombre,valor_mes)
values 
(
	(select id from areas where areas.AreaNombre  = 'Bienestar'),
	'PROGRAMA DE FAMILIA',
	0
),
(
	(select id from areas where areas.AreaNombre  = 'Bienestar'),
	'PROGRAMA DE APOYO INSTITUCIONAL',
	0
),
(
	(select id from areas where areas.AreaNombre  = 'Bienestar'),
	'PROGRAMA DE DESARROLLO ARTÍSTICO Y DEPORTIVO',
	0
),
(
	(select id from areas where areas.AreaNombre  = 'Bienestar'),
	'PROGRAMA PREVENCIÓN Y PROMOCIÓN',
	0
)
;



insert into programas (idArea,ProgramaNombre,valor_mes)
values 
(
	(select id from areas where areas.AreaNombre  = 'Salud'),
	'PROGRAMA ASISTENCIA AL USUARIO',
	0
),
(
	(select id from areas where areas.AreaNombre  = 'Salud'),
	'PROGRAMA DE APOYO INSTITUCIONAL',
	0
),
(
	(select id from areas where areas.AreaNombre  = 'Salud'),
	'PROGRAMA DE APOYO PROMOCIÓN Y PREVENCIÓN',
	0
),
(
	(select id from areas where areas.AreaNombre  = 'Salud'),
	'PROGRAMA VOLUNTARIADO HOSPITALARIO',
	0
)
;