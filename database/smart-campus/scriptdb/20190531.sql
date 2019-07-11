DROP VIEW gis.view_building_room_geom;
CREATE OR REPLACE VIEW gis.view_building_room_geom AS
select D."Name" as "NamaGedung",C."Name" as "NamaLantai",B."Description" as "NamaRuang", A."Master" as "RuangId",A."Geometry",
case when C."Name" = 'Basement' then -1 
when C."Name" = 'Basement 2' then -2 
when C."Name" = 'Lantai 1' then '0' 
when C."Name" = 'Lantai 2' then '1' 
when C."Name" = 'Lantai 3' then '2' 
when C."Name" = 'Lantai 4' then '3' 
when C."Name" = 'Lantai 5' then '4' 
when C."Name" = 'Lantai 6' then '5' 
when C."Name" = 'Lantai 7' then '6' 
when C."Name" = 'Lantai 8' then '7' else
'0' end as "id_lantai" 
from gis."Detail_Room_the_geom" A 
join public."Room" B on A."Master" = B."Id"
join public."Floor" C on B."Floor" = C."Id"
join public."Building" D on C."Building" = D."Id" 

DROP VIEW gis.view_floor_distinct_get;
CREATE OR REPLACE VIEW gis.view_floor_distinct_get AS
select 
case when "Name" = 'Basement' then -1 
when "Name" = 'Basement 2' then -2 
when "Name" = 'Lantai 1' then '0' 
when "Name" = 'Lantai 2' then '1' 
when "Name" = 'Lantai 3' then '2' 
when "Name" = 'Lantai 4' then '3' 
when "Name" = 'Lantai 5' then '4' 
when "Name" = 'Lantai 6' then '5' 
when "Name" = 'Lantai 7' then '6' 
when "Name" = 'Lantai 8' then '7' else
'0' end as "id_lantai"
from
(select distinct "Name" from public."Floor") X order by "id_lantai" desc

